/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import http from '../helpers/axios'

const InstitutionService = {
  findByName (name) {
    return new Promise((resolve, reject) => {
      http.get('/auth/institutions', { params: { searchTerm: name } })
          .then(response => { resolve(response.data) })
          .catch(error => { reject(error) })
    })
  },
  findById (id) {

  },
  create (institution) {
    return new Promise((resolve, reject) => {
      http.post('/institutions', institution)
        .then(response => { resolve(response.data) })
        .catch(err => { reject(err) })
    })
  },
  update (institution) {

  },
  delete (id) {
  }
}

export default InstitutionService
