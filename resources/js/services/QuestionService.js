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
          let uploadPercentage = parseInt(Math.round(
            (progressEvent.loaded * 100) / progressEvent.total))
          if (progress !== null) {
            progress(uploadPercentage)
          }
        }
      })
        .then(response => resolve(response.data))
        .catch(e => reject(e))
    })
  },
  delete (id) {

  },
  searchQuestion (searchParams) {
    let params = {
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
  getFile (id) {
    return new Promise(function (resolve, reject) {
      http.get(`/questions/${id}/file`, {
        headers: {
          'cache-control': 'no-cache'
        }
      })
        .then(response => resolve(response.data))
        .catch(e => reject(e))
    })
  }
}

export default QuestionService
