/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
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
        html: message,
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
