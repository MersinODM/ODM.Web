/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

import http from '../helpers/axios'
import Constants from '../helpers/constants'

export const SettingService = {
  getGeneralInfo () {
    return new Promise((resolve, reject) => {
      http.get('auth/general_info')
        .then(value => {
          localStorage.setItem(Constants.generalInfo, JSON.stringify(value.data))
          resolve(value.data)
        })
        .catch(reason => reject(reason.data))
    })
  },
  getSettings () {
    return new Promise((resolve, reject) => {
      http.get('settings')
        .then(response => resolve(response.data))
        .catch(reason => reject(reason))
    })
  },
  update (settings) {
    return new Promise((resolve, reject) => {
      http.put('settings', settings)
        .then((response) => {
          resolve(response.data)
        })
        .catch((reason) => reject(reason))
    })
  },
  mailSync () {
    return new Promise((resolve, reject) => {
      http.get('mails/sync')
        .then((response) => resolve(response.data))
        .catch((reason) => reject(reason))
    })
  }
}
