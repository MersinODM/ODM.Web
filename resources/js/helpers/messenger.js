/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import swal from 'sweetalert'

const Messenger = {
  showError (message, callback = null) {
    swal({
      title: 'Hata mesajı!',
      text: message,
      icon: 'error',
      button: 'Tamam'
    }).then(value => {
      if (callback !== null) callback(value)
    })
  },
  showInfo (message, callback = null) {
    swal({
      title: 'Bilgi mesajı!',
      text: message,
      icon: 'info',
      button: 'Tamam'
    }).then(value => {
      if (callback !== null) callback(value)
    })
  },
  showSuccess (message, callback = null) {
    swal({
      title: 'Başarı mesajı!',
      text: message,
      icon: 'success',
      button: 'Tamam'
    }).then(value => {
      if (callback !== null) callback(value)
    })
  },
  showWarning (message, callback = null) {
    swal({
      title: 'Uyarı mesajı!',
      text: message,
      icon: 'info',
      button: 'Tamam'
    }).then(value => {
      if (callback !== null) callback(value)
    })
  },
  showPrompt (message, buttons, callback = null) {
    swal({
      title: 'Dikkat!',
      text: message,
      icon: 'warning',
      buttons: buttons
    }).then(value => {
      if (callback !== null) callback(value)
    })
  }
}

export default Messenger
