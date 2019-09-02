/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import pace from 'pace-js'
import swal from 'sweetalert'
import router from '../router'

const axios = require('axios').default

let domain = document.querySelector('meta[name="base-url"]').getAttribute('content')
const http = axios.create({
  baseURL: `${domain}/api`
})
// istek interceptor u ekleniyor
http.interceptors.request.use(function (config) {
  // Her istekte gönderilercek http başlıkları ayarlanıyor
  // config.baseURL = document.querySelector('meta[name="base-url"]').value
  // eslint-disable-next-line no-undef
  pace.start()
  config.headers['X-CSRF-TOKEN'] = Laravel.csrfToken
  const token = localStorage.getItem('access_token')
  if (token !== null) {
    config.headers['Authorization'] = `Bearer ${token}`
  }
  return config
}, function (error) {
  pace.stop()
  return Promise.reject(error)
})

http.interceptors.response.use(function (response) {
  pace.stop()
  return response
}, function (error) {
  if (error.response.status === 401) {
    console.log(error)
    swal({
      title: 'Oturum süreniz dolmuştur',
      text: 'Kullanıcı giriş sayfasına yönlendirileceksiniz',
      icon: 'warning',
      buttons: {
        confirm: {
          text: 'Tamam',
          color: '#DD6B55'
        }
      }
    }).then((value) => {
      pace.stop()
      router.push({ 'name': 'login' })
    })
  } else {
    pace.stop()
    return Promise.reject(error)
  }
})

http.interceptors.response.use(function (response) {
  pace.stop()
  return response
}, function (error) {
  if (error.response.status === 422) {
    console.log(error)
    let msg = 'Aşağıdaki doğrulama hataları giderilmelidir.'
    Object.keys(error.response.data)
          .forEach((value, index) => msg + `\n${index + 1} - ${value}`)
    swal({
      title: 'Veri doğrulama hatası!',
      text: msg,
      icon: 'warning',
      buttons: {
        confirm: {
          text: 'Tamam',
          color: '#DD6B55'
        }
      }
    }).then(() => {
      pace.stop()
    })
  } else {
    pace.stop()
    return Promise.reject(error)
  }
})

// window.axios = http

export default http
