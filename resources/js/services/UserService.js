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

const UserService = {
  findById (id) {
    return new Promise((resolve, reject) => {
      http.get(`/users/${id}`)
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  },
  findElectorsByBranchId (branchId) {
    return new Promise((resolve, reject) => {
      http.get(`/branches/${branchId}/electors`)
        .then(value => resolve(value.data))
        .catch(reason => reject(reason.data))
    })
  },
  approveUser (id) {
    return new Promise((resolve, reject) => {
      http.put(`/users/${id}/confirm_req`)
        .then(response => resolve(response.data))
        .catch(reason => reject(reason))
    })
  },
  reactivate (id) {
    return new Promise((resolve, reject) => {
      http.put(`/users/${id}/reactivate`)
        .then(response => resolve(response.data))
        .catch(err => reject(err.data))
    })
  },
  update (id, user) {
    return new Promise((resolve, reject) => {
      http.put(`/users/${id}`, user)
        .then(resp => resolve(resp.data))
        .catch(error => reject(error))
    })
  },
  updateMyInfo (id, user) {
    return new Promise((resolve, reject) => {
      http.put(`/users/${id}/my_info`, user)
        .then(resp => resolve(resp.data))
        .catch(error => reject(error))
    })
  },
  delete (id) {
    return new Promise((resolve, reject) => {
      http.delete(`/users/${id}`)
        .then(resp => resolve(resp.data))
        .catch(error => reject(error))
    })
  }
}

export default UserService
