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

const InstitutionService = {
  findByName (name) {
    return new Promise((resolve, reject) => {
      http.get('/auth/institutions', { params: { searchTerm: name } })
        .then(response => { resolve(response.data) })
        .catch(error => { reject(error) })
    })
  },
  findById (id) {
    return new Promise((resolve, reject) => {
      http.get(`institutions/${id}`)
        .then((response) => { resolve(response.data) })
        .catch((error) => reject(error))
    })
  },
  create (institution) {
    return new Promise((resolve, reject) => {
      http.post('/institutions', institution)
        .then(response => { resolve(response.data) })
        .catch(err => { reject(err) })
    })
  },
  update (id, institution) {
    return new Promise((resolve, reject) => {
      http.put(`institutions/${id}`, institution)
        .then(response => { resolve(response.data) })
        .catch(err => { reject(err) })
    })
  },
  delete (id) {
  }
}

export default InstitutionService
