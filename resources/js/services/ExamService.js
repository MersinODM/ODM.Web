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

const ExamPurposeService = {
  async getPurposes () {
    try {
      const response = await http.get('/exams/purposes')
      return response.data
    } catch (error) {}
  }
}

const ExamService = {
  async createAutoExam (data) {
    try {
      const response = await http.post('/exams/auto', data)
      return response.data
    } catch (error) {}
  },
  async getExamFile (examId) {
    try {
      const response = await http.get(`exams/${examId}/file`, { responseType: 'blob', errorHandler: true })
      return {
        file: response.data,
        fileName: response.headers['content-disposition']
          .split(';')
          .find(n => n.includes('filename='))
          .replace('filename=', '')
          .trim()
      }
    } catch (error) {}
  },
  async getExam (examId = null, code = null) {
    try {
      const response = await http.get('exams', { params: { id: examId, code: code } })
      return response.data
    } catch (error) {}
  }
}

export {
  ExamPurposeService
}
export default ExamService
