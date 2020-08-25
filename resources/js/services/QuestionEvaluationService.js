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

const QuestionEvaluationService = {
  saveElectors (id, electors) {
    return new Promise((resolve, reject) => {
      http.post(`questions/${id}/evaluations`, { electors: electors })
        .then(value => { resolve(value.data) })
        .catch(reason => reject(reason.data))
    })
  },
  save (id, data) {
    return new Promise((resolve, reject) => {
      http.put(`/questions/${id}/evaluations`, data)
        .then(response => { resolve(response.data) })
        .catch(error => reject(error))
    })
  },
  deleteById (id) {
    return new Promise((resolve, reject) => {
      http.delete(`/evaluations/${id}/`)
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  },
  deleteByCode (questionId, code) {
    return new Promise((resolve, reject) => {
      http.delete(`/questions/${questionId}/evaluations/${code}`)
        .then(value => resolve(value.data))
        .catch(reason => reject(reason.data))
    })
  },
  findByQuestionId (id) {
    return new Promise((resolve, reject) => {
      http.get(`/questions/${id}/evaluations`)
        .then(response => { resolve(response.data) })
        .catch(error => reject(error))
    })
  },
  addElectors (questionId, code, electors) {
    return new Promise((resolve, reject) => {
      http.put(`/questions/${questionId}/evaluations/${code}/add_electors`, { electors })
        .then(response => { resolve(response.data) })
        .catch(error => reject(error))
    })
  },
  manuallyCalculate (questionId, code) {
    return new Promise((resolve, reject) => {
      http.put(`/questions/${questionId}/evaluations/${code}`)
        .then(response => { resolve(response.data) })
        .catch(error => reject(error))
    })
  }
}

export default QuestionEvaluationService
