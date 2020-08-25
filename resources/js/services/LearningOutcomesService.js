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

const LearningOutcomesService = {
  findById (loId) {
    return new Promise((resolve, reject) => {
      http.get(`/learning_outcomes/${loId}`)
        .then(value => resolve(value.data))
        .catch(reason => reject(reason.message))
    })
  },
  findByContent (content, callback) {
    if (content.length >= 3) {
      http.get('/learning_outcomes', {
        params: {
          searchTerm: content
        }
      }).then(response => {
        callback(response.data)
      })
        .catch(error => {
          Messenger.showError(MessengerConstants.errorMessage)
          console.log(error)
        })
    }
  },
  findByCode (code, callback) {
    if (code.length >= 3) {
      http.get('/learning_outcomes', {
        params: {
          searchTerm: code
        }
      }).then(response => {
        callback(response.data)
      })
        .catch(error => {
          Messenger.showError(MessengerConstants.errorMessage)
          console.log(error)
        })
    }
  },
  findByCodeOrContent (search) {
    return new Promise((resolve, reject) => {
      http.get('learning_outcomes/find_by', { params: search })
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  },
  findByCodeOrContentWithPaging (search) {
    return new Promise((resolve, reject) => {
      http.get('learning_outcomes/find_by/content', { params: search })
        .then(res => resolve(res.data))
        .catch(error => reject(error))
    })
  },
  getLastSavedLOs (size) {
    return new Promise((resolve, reject) => {
      http.get(`/learning_outcomes/last_saved/${size}`)
        .then(res => resolve(res.data))
        .catch(error => reject(error))
    })
  },
  save (lo) {
    return new Promise((resolve, reject) => {
      http.post('/learning_outcomes', lo)
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  },
  update (id, lo, callback) {
    http.put(`/learning_outcomes/${id}`, lo)
      .then(response => { callback(response.data) })
      .catch(error => {
        Messenger.showError(MessengerConstants.errorMessage)
        console.log(error)
      })
  },
  delete (id, callback) {
    http.delete(`/learning_outcomes/${id}`)
      .then(response => { callback(response.data) })
      .catch(error => {
        Messenger.showError(MessengerConstants.errorMessage)
        console.log(error)
      })
  }
}

export default LearningOutcomesService
