/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'
import Messenger from '../helpers/messenger'
import { MessengerConstants } from '../helpers/constants'
const QuestionService = {
  findById (id, callback) {
    http.get(`/questions/${id}`)
      .then(response => {
        if (response === undefined) return
        callback(response.data)
      })
  },
  save (formData, callback, progress = null, error = null) {
    // let config = { headers: { 'Content-Type': 'multipart/form-data' } }
    http.post('/questions', formData, {
      headers: {
        'Content-Type': `multipart/form-data; boundary=${formData._boundary}`
      },
      onUploadProgress: (progressEvent) => {
        let uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total))
        if (progress !== null) progress(uploadPercentage)
      }
    }
    ).then(response => {
      if (response === undefined) return
      callback(response.data)
    }).catch(e => {
      Messenger.showError(MessengerConstants.errorMessage)
      if (error) {
        error(e)
      }
      console.log(e)
    })
  },
  delete (id, callback = null) {

  },
  searchQuestion (searchParams, callback, error = null) {
    let params = {
      branch_id: searchParams.branchId,
      class_level: searchParams.classLevel,
      searched_content: searchParams.searchedContent
    }
    http.get('/questions', { params }).then(response => {
      if (response !== undefined) {
        callback(response.data)
      }
    }).catch(e => {
      if (error !== null) {
        error(e)
      }
      Messenger.showError('Sunucu bazlı bir hata meydana geldi')
    })
  },
  getFile (id, callback, error = null) {
    http.get(`/questions/${id}/file`, {
      headers: {
        'cache-control': 'no-cache'
      }
    })
      .then(response => {
        if (response !== undefined) {
          callback(response.data)
        }
      }).catch(e => {
        if (error !== null) {
          error(e)
        }
        Messenger.showError('Sunucu bazlı bir hata meydana geldi')
      })
  }
}

export default QuestionService
