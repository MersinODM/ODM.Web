/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

// import ProgressBar from 'progressbar.js/dist/progressbar.min'
import Swal from 'admin-lte/plugins/sweetalert2/sweetalert2.all.min'
import router from '../router'
import Constants from './constants'
import pace from 'pace-progressbar'

const axios = require('axios').default

// var line = new ProgressBar.Line('#loading-bar')

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
}, (error) => {
  if (error.response.status === 422) {
    const validationMessages = Object.entries(error.response.data)
      .map(entry => entry[1])
      .join('<br>')
    const msg = `Aşağıdaki veri doğrulama hataları giderilmelidir.<br><b>${validationMessages}</b>`
    Swal.fire({
      title: 'Veri doğrulama hatası!',
      html: msg,
      icon: 'warning',
      confirmButtonText: 'Tamam'
    }).then(() => {
      pace.stop()
    })
  }
  return Promise.reject(error)
})

// window.axios = http

export default http
