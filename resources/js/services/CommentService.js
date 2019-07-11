/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'

const CommentService = {
  save (suggestion) {
    return new Promise(function (resolve, reject) {
      http.post(`questions/${suggestion.questionId}/suggestions`, {
        content: suggestion.content
      }).then(response => {
        resolve(response.data)
      }).catch(e => {
        reject(e)
      })
    })
  },
  getComments (questionId) {
    return new Promise(function (resolve, reject) {
      http.get(`questions/${questionId}/suggestions`)
        .then(response => {
          resolve(response.data)
        }).catch(e => {
          reject(e)
        })
    })
  }
}

export default CommentService
