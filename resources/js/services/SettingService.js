/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

import http from '../helpers/axios'

export const SettingService = {
  getSettings () {
    return new Promise((resolve, reject) => {
      http.get('auth/settings')
        .then(value => {
          localStorage.setItem('settings', JSON.stringify(value.data))
          resolve(value.data)
        })
        .catch(reason => reject(reason.data))
    })
  }
}
