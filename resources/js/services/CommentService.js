/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'

const RevisionService = {
  save (id, revision) {
    return new Promise(function (resolve, reject) {
      http.post(`questions/${id}/revisions`, revision, {
        headers: {
          'Content-Type': `multipart/form-data; boundary=${revision._boundary}`
        }
      })
          .then(response => {
            resolve(response.data)
          }).catch(e => {
            reject(e)
          })
    })
  },
  getRevisions (questionId) {
    return new Promise(function (resolve, reject) {
      http.get(`questions/${questionId}/revisions`)
        .then(response => {
          resolve(response.data)
        }).catch(e => {
          reject(e)
        })
    })
  }
}

export default RevisionService
