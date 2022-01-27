/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright 2019-2020 Hakan GÜLEN
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

import http from '../helpers/axios'

const QuestionService = {
  findById (id) {
    return new Promise(function (resolve, reject) {
      http.get(`/questions/${id}`)
        .then(response => resolve(response.data))
        .catch(e => reject(e))
    })
  },
  save (formData, progress = null) {
    return new Promise(function (resolve, reject) {
      http.post('/questions', formData, {
        headers: {
          'Content-Type': `multipart/form-data; boundary=${formData._boundary}`
        },
        onUploadProgress (progressEvent) {
          const uploadPercentage = Math.round((progressEvent.loaded * 100) / progressEvent.total)
          if (progress !== null) {
            progress(uploadPercentage)
          }
        }
      })
        .then(response => resolve(response.data))
        .catch(e => reject(e))
    })
  },
  sendDeleteRequest (id, data) {
    return new Promise((resolve, reject) => {
      http.post(`/questions/${id}/delete_request`, data)
        .then(response => resolve(response.data))
        .catch(err => reject(err))
    })
  },
  searchQuestion (searchParams) {
    const params = {
      branch_id: searchParams.branchId,
      class_level: searchParams.classLevel,
      searched_content: searchParams.searchedContent
    }
    return new Promise(function (resolve, reject) {
      http.get('/questions', { params })
        .then(response => resolve(response.data))
        .catch(e => reject(e))
    })
  },
  getLastSavedQuestions (size) {
    return new Promise((resolve, reject) => {
      http.get(`/questions/last_saved/${size}`)
        .then(resp => resolve(resp.data))
        .catch(err => reject(err))
    })
  },
  getFile (id) {
    return new Promise(function (resolve, reject) {
      http.get(`/questions/${id}/file`, {
        headers: {
          'cache-control': 'no-cache',
          responseType: 'blob'
        }
      })
        .then(response => resolve(response.data))
        .catch(e => reject(e))
    })
  }
}

export default QuestionService
