/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'
import Messenger from '../helpers/messenger'
import { MessengerConstants } from '../helpers/constants'

const UserService = {
  findById (id, callback) {
    http.get(`/users/${id}`)
      .then(response => {
        callback(response.data)
      }).catch(error => {
        console.log(error)
      })
  },
  approveUser (id, callback) {
    http.put(`/users/${id}/confirm_req`)
      .then(response => {
        if (response === undefined) return
        callback(response.data)
      })
      .catch(error => {
        console.error(error.response)
        Messenger.showError(MessengerConstants.errorMessage)
      })
  }
}

export default UserService
