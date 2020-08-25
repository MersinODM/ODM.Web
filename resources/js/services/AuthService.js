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

import router from '../router'
import http from '../helpers/axios'
import Constants from '../helpers/constants'
import jwt from 'jwt-decode'

const AuthService = {
  login: (credentials) => {
    return new Promise((resolve, reject) => {
      http.post('/auth/login', credentials)
        .then(response => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  logout: () => {
    localStorage.removeItem(Constants.ACCESS_TOKEN)
    localStorage.removeItem(Constants.EXPIRES_IN)
    localStorage.removeItem(Constants.PERMISSIONS)
    localStorage.removeItem(Constants.ROLES)
    localStorage.removeItem(Constants.GENERAL_INFO)
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
        resolve({ roles: roles.data, permissions: permission.data })
      })
        .catch(error => {
          // console.log(error)
          reject(error)
        })
    })
  },
  getUser () {
    return new Promise((resolve, reject) => {
      const id = this.getUserId()
      http.get(`/users/${id}`)
        .then(response => resolve(response.data))
        .catch(e => { reject(e) })
    })
  },
  getUserId () {
    const token = localStorage.getItem(Constants.ACCESS_TOKEN)
    if (token) {
      return jwt(localStorage.getItem(Constants.ACCESS_TOKEN)).sub
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
