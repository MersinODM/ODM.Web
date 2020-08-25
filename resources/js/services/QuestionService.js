/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
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
