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

import http from '../helpers/axios'
import Messenger from '../helpers/messenger'
import { MessengerConstants } from '../helpers/constants'

const BranchService = {
  getAllForRegisterReq (name) {
    return new Promise((resolve, reject) => {
      http.get('/auth/branches')
        .then(response => { resolve(response.data) })
        .catch(error => { reject(error) })
    })
  },
  getBranchesWithStats () {
    return new Promise((resolve, reject) => {
      http.get('/branches/with_stats').then(response => {
        if (response === undefined) reject(new Error('Tanımsız cevap'))
        resolve(response.data)
      })
        .catch(error => {
          reject(error)
        })
    })
  },
  getBranches () {
    return new Promise((resolve, reject) => {
      http.get('/branches').then(response => {
        if (response === undefined) reject(new Error('Tanımsız cevap'))
        resolve(response.data)
      })
        .catch(error => {
          reject(error)
        })
    })
  },
  save: function (branch, callback) {
    http.post('/branches', branch)
      .then(response => {
        if (response === undefined) return
        callback(response.data)
      })
      .catch(error => {
        Messenger.showError(MessengerConstants.errorMessage)
        console.log(error)
      })
  },
  update (id, branch, callback) {
    http.put(`/branches/${id}`, branch)
      .then(response => {
        if (response === undefined) return
        callback(response.data)
      })
      .catch(error => {
        Messenger.showError(MessengerConstants.errorMessage)
        console.log(error)
      })
  },
  delete (id, callback) {
    http.delete(`/branches/${id}`)
      .then(response => {
        if (response === undefined) return
        callback(response.data)
      })
      .catch(error => {
        Messenger.showError(MessengerConstants.errorMessage)
        console.log(error)
      })
  }
}

export default BranchService
