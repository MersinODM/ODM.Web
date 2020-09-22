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

import NewLearningOutcome from '../views/learningOutcome/NewLearningOutcome'
import LearningOutcomeList from '../views/learningOutcome/LearningOutcomeList'
import EditLearningOutcome from '../views/learningOutcome/EditLearningOutcome'

const loRoutes = [
  {
    path: '/learning_outcomes/new',
    name: 'newLO',
    component: NewLearningOutcome
  },
  {
    path: '/learning_outcomes/list',
    name: 'loList',
    component: LearningOutcomeList
  },
  {
    path: '/learning_outcomes/:id/edit',
    name: 'editLO',
    component: EditLearningOutcome
  }
]

export default loRoutes
