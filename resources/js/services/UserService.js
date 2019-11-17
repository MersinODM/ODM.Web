/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'
import Messenger from '../helpers/messenger'
import { MessengerConstants } from '../helpers/constants'

const UserService = {
  findById (id) {
    return new Promise((resolve, reject) => {
      http.get(`/users/${id}`)
          .then(response => resolve(response.data))
          .catch(error => reject(error))
    })
  },
  approveUser (id, callback) {
    http.put(`/users/${id}/confirm_req`)
      .then(response => {
        if (response === undefined) return
        callback(response.data)
      })
      .catch(() => Messenger.showError(MessengerConstants.errorMessage))
  },
  update (id, user) {
    return new Promise((resolve, reject) => {
      http.put(`/users/${id}`, user)
        .then(resp => resolve(resp.data))
        .catch(error => reject(error))
    })
  },
  delete (id) {
    return new Promise((resolve, reject) => {
      http.delete(`/users/${id}`)
          .then(resp => resolve(resp.data))
          .catch(error => reject(error))
    })
  }
}

export default UserService
