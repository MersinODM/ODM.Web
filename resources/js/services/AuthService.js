/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import swal from 'sweetalert'
import router from '../router'
import http from '../helpers/axios'
import Constants from '../helpers/constants'
import jwt from 'jwt-decode'

const AuthService = {
  login: (credentials) => {
    return new Promise((resolve, reject) => {
      http.post('/auth/login', credentials, {
        headers: {
          'Content-Type': 'application/json'
        }
      }).then(response => {
        localStorage.setItem(Constants.accessToken, response.data.access_token)
        localStorage.setItem(Constants.expires_in, response.data.expires_in)
        router.push({ 'name': 'main' })
        resolve(response.data)
      }).catch((error) => {
        reject(error)
      })
    })
  },
  logout: () => {
    localStorage.removeItem(Constants.accessToken)
    localStorage.removeItem(Constants.expires_in)
    localStorage.removeItem(Constants.permissions)
    localStorage.removeItem(Constants.roles)
    router.push({ 'name': 'login' })
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
      }).catch(error => {
        console.log(error)
        reject(error)
      })
    })

    // http.get('/users/current/permissions')
    //   .then(resp => {
    //     // console.log(resp.data)
    //     localStorage.setItem(Constants.permissions, JSON.stringify(resp.data))
    //     next()
    //   })
    //   .catch(error => {
    //     console.log(error)
    //     next('/login')
    //   })
  },
  getUser: (callback) => {
    let user = null
    let id = jwt(localStorage.getItem(Constants.accessToken)).sub
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
  }
}

export default AuthService
