/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

import http from '../helpers/axios'

export const QuestionDeleteService = {
  approve (questionId) {
    return new Promise((resolve, reject) => {
      http.put(`/questions/${questionId}/delete_request`)
        .then(value => resolve(value.data))
        .catch(err => reject(err))
    })
  },
  delete (id, questionId) {
    return new Promise((resolve, reject) => {
      http.delete(`/questions/${questionId}/delete_requests/${id}`)
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  }
}
