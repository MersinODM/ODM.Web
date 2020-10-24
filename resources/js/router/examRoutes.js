
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

import ExamList from '../views/exam/ExamList'
import NewExam from '../views/exam/NewExam'
import NewAutoExam from '../views/exam/NewAutoExam'
import UnderConstruction from '../views/utils/UnderConstruction'
import ShowExam from '../views/exam/ShowExam'

const examRoutes = [
  {
    path: '/exams/list',
    name: 'examList',
    component: ExamList
  },
  {
    path: '/exams/wizard',
    name: 'newExam',
    component: NewExam
  },
  {
    path: '/exams/create/auto',
    name: 'newAutoExam',
    component: NewAutoExam
  },
  {
    path: '/exams/create/manual',
    name: 'newManualExam',
    component: UnderConstruction
  },
  {
    path: '/exams/:examId',
    name: 'showExam',
    component: ShowExam
  }
]

export default examRoutes
