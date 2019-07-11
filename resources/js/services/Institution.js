/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'

const Institution = {
  findByName (name, callback) {
    if (name.length >= 3) {
      http.get('/auth/institutions', {
        params: {
          searchTerm: name
        }
      }).then(response => {
        callback(response.data)
      }).catch(error => {
        console.log(error)
      })
    }
  },
  findById (id) {

  },
  create (institution) {

  },
  update (institution) {

  },
  delete (id) {
  }
}

export default Institution
