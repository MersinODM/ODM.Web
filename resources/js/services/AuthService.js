/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

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

import router from '../router'
import http from '../helpers/axios'
import Constants from '../helpers/constants'
import jwt from 'jwt-decode'

const AuthService = {
  login: (credentials) => {
    return new Promise((resolve, reject) => {
      http.post('/auth/login', credentials)
        .then(response => {
          localStorage.setItem(Constants.accessToken, response.data.access_token)
          localStorage.setItem(Constants.expires_in, response.data.expires_in)
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  logout: () => {
    localStorage.removeItem(Constants.accessToken)
    localStorage.removeItem(Constants.expires_in)
    localStorage.removeItem(Constants.permissions)
    localStorage.removeItem(Constants.roles)
    localStorage.removeItem(Constants.generalInfo)
    router.push({ name: 'login' })
  },
  check: () => {

  },
  setRoleAndPermissions () {
    return new Promise((resolve, reject) => {
      Promise.all([
        http.get('/users/current/permissions'),
        http.get('/users/current/roles')
      ]).then(([permission, roles]) => {
        // Hem rol hem izin bilgileri sistemden çekiliyor ve localStorage a yazılıyor
        localStorage.setItem(Constants.permissions, JSON.stringify(permission.data))
        localStorage.setItem(Constants.roles, JSON.stringify(roles.data))
        resolve({ roles: roles.data, permissions: permission.data })
      })
        .catch(error => {
          console.log(error)
          reject(error)
        })
    })
  },
  getUser: (callback) => {
    let user = null
    const id = jwt(localStorage.getItem(Constants.accessToken)).sub
    http.get(`/users/${id}`)
      .then(response => {
        user = response.data
        callback(null, user)
        // console.log(user)
      })
      .catch(e => {
        callback(e, null)
        // console.log(e)
      })
  },
  getUserId () {
    const token = localStorage.getItem(Constants.accessToken)
    if (token) {
      return jwt(localStorage.getItem(Constants.accessToken)).sub
    }
    return null
  },
  createRegisterRequest (data) {
    return new Promise((resolve, reject) => {
      http.post('/auth/register', data)
        .then(response => {
          resolve(response.data)
        })
        .catch(reason => {
          reject(reason)
        })
    })
  },
  forgetPassword (data) {
    return new Promise((resolve, reject) => {
      http.post('/auth/password/forget', data)
        .then(response => {
          resolve(response.data)
        })
        .catch(reason => {
          reject(reason)
        })
    })
  }
}

export default AuthService
