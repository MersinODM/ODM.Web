/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

const Swal = require('admin-lte/plugins/sweetalert2/sweetalert2.all.min')

const Messenger = {
  showError (message, callback = null) {
    return new Promise((resolve, reject) => {
      Swal.fire({
        title: 'Hata mesajı!',
        text: message,
        icon: 'error',
        confirmButtonText: 'Tamam'
      })
        .then(value => resolve(value))
        .catch(error => reject(error))
    })
  },
  showInfo (message) {
    return new Promise((resolve, reject) => {
      Swal.fire({
        title: 'Bilgi mesajı!',
        text: message,
        icon: 'info',
        confirmButtonText: 'Tamam'
      })
        .then(value => resolve(value))
        .catch(error => reject(error))
    })
  },
  showSuccess (message) {
    return new Promise((resolve, reject) => {
      Swal.fire({
        title: 'Başarı mesajı!',
        text: message,
        icon: 'success',
        confirmButtonText: 'Tamam'
      }).then(value => resolve(value))
        .catch(reason => reject(reason))
    })
  },
  showWarning (message) {
    return new Promise((resolve, reject) => {
      Swal.fire({
        title: 'Uyarı mesajı!',
        text: message,
        icon: 'warning',
        confirmButtonText: 'Tamam'
      })
        .then(value => resolve(value))
        .catch(error => reject(error))
    })
  },
  showPrompt (message, buttons = null) {
    if (!buttons) {
      buttons = {
        confirmText: 'Evet',
        cancelText: 'Hayır'
      }
    }
    return new Promise((resolve, reject) => {
      Swal.fire({
        title: 'Dikkat!',
        html: message,
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        cancelButtonColor: '#d33',
        confirmButtonText: buttons.confirmText,
        cancelButtonText: buttons.cancelText
      }).then(value => resolve(value))
        .catch(reason => reject(reason))
    })
  },
  showInput (message) {
    return new Promise((resolve, reject) => {
      Swal.fire({
        title: 'Dikkat!',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        focusConfirm: false,
        input: 'text',
        confirmButtonText: 'Tamam',
        cancelButtonColor: '#d33',
        cancelButtonText: 'İptal'
      })
        .then((value) => {
          resolve(value)
        })
        .catch(reason => {
          reject(reason)
        })
    })
  }
}

export default Messenger
