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
import { integer } from 'vee-validate/dist/rules.esm'

const ExamPurposeService = {
  getPurposes () {
    return new Promise((resolve, reject) => {
      http.get('/exams/purposes')
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  }
}

const ExamService = {
  createAutoExam (data) {
    return new Promise((resolve, reject) => {
      http.post('/exams/auto', data)
        .then(response => resolve(response.data))
        .catch(error => reject(error))
    })
  },
  getExamFile (examId) {
    return new Promise((resolve, reject) => {
      http.get(`exams/${examId}/file`, { responseType: 'blob' })
        .then(response => resolve({
          file: response.data,
          fileName: response.headers['content-disposition']
            .split(';')
            .find(n => n.includes('filename='))
            .replace('filename=', '')
            .trim()
        }))
        .catch(error => reject(error))
    })
  }
}

export {
  ExamPurposeService
}
export default ExamService
