/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
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
