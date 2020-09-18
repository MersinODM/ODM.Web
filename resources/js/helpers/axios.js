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

import Swal from 'admin-lte/plugins/sweetalert2/sweetalert2.all.min'
import router from '../router'
import Constants from './constants'
import pace from 'pace-progressbar'

const axios = require('axios').default

const isHandlerEnabled = (config = {}) => {
  return !(!config?.errorHandler)
}

const handleError = (error) => {
  if (isHandlerEnabled(error.config)) {
    // VanillaToasts.create({
    //   title: `Request failed: ${error.response.status}`,
    //   text: `Unfortunately error happened during request: ${error.config.url}`,
    //   type: 'warning',
    //   timeout: TIMEOUT
    // })
  }
  return Promise.reject({ ...error })
}

const domain = document.querySelector('meta[name="base-url"]').getAttribute('content')
const http = axios.create({
  baseURL: `${domain}/api`
})
// istek interceptor u ekleniyor
http.interceptors.request.use((config) => {
  // Her istekte gönderilercek http başlıkları ayarlanıyor
  // eslint-disable-next-line no-undef
  config.headers['X-CSRF-TOKEN'] = Laravel.csrfToken
  const token = localStorage.getItem(Constants.ACCESS_TOKEN)
  if (token !== null) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
}, (error) => {
  // pace.stop()
  return Promise.reject(error)
})

http.interceptors.response.use((response) => {
  // pace.stop()
  return response
}, (error) => {
  if (error.config?.errorHandle === false) {
    return Promise.reject(error)
  }
  if (error.response.status === 401) {
    Swal.fire({
      title: 'Oturum süreniz dolmuştur',
      text: 'Kullanıcı giriş sayfasına yönlendirileceksiniz',
      icon: 'warning',
      confirmButtonText: 'Tamam'
    }).then((value) => {
      pace.stop()
      router.push({ name: 'login' })
    })
  } else {
    pace.stop()
    return Promise.reject(error)
  }
})

http.interceptors.response.use((response) => {
  // pace.stop()
  return response
}, async (error) => {
  if (error.response.status === 422) {
    const validationMessages = Object.entries(error.response.data)
      .map(entry => entry[1])
      .join('<br>')
    const msg = `Aşağıdaki veri doğrulama hataları giderilmelidir.<br><b>${validationMessages}</b>`
    await Swal.fire({
      title: 'Veri doğrulama hatası!',
      html: msg,
      icon: 'warning',
      confirmButtonText: 'Tamam'
    })
    pace.stop()
  } else if (error.response.status === 500) {
    const msg = 'Maalesef sunucu taraflı bir hata meydana geldi. Lütfen sistem yöneticinize başvurunuz.'
    await Swal.fire({
      title: 'Sistem hatası!',
      html: msg,
      icon: 'error',
      confirmButtonText: 'Tamam'
    })
    pace.stop()
  }
  return Promise.reject(error)
})

// window.axios = http

export default http
