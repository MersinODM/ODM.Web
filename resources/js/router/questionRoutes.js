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

import SimpleNewQuestion from '../views/question/SimpleNewQuestion'
import QuestionTableList from '../views/question/QuestionTableList'
import QuestionDeleteRequests from '../views/question/QuestionDeleteRequests'
import QuestionEvaluationRequestList from '../views/question/QuestionEvaluationRequestList'
import ShowQuestion from '../views/question/ShowQuestion'
import ReviseQuestion from '../views/question/ReviseQuestion'
import SetEvaluatorsForQuestion from '../views/question/SetEvaluatorsForQuestion'
import EvaluateQuestion from '../views/question/EvaluateQuestion'

const questionRoutes = [
  {
    path: '/questions/new',
    name: 'newQuestion',
    component: SimpleNewQuestion
  },
  {
    path: '/questions/list',
    name: 'questionTableList',
    component: QuestionTableList
  },
  {
    path: '/questions/delete_requests',
    name: 'questionDeleteRequests',
    component: QuestionDeleteRequests
  },
  {
    path: '/questions/eval_requests',
    name: 'questionEvaluationRequests',
    component: QuestionEvaluationRequestList
  },
  {
    path: '/questions/:questionId',
    name: 'showQuestion',
    component: ShowQuestion
  },
  {
    path: '/questions/:questionId/revise',
    name: 'reviseQuestion',
    component: ReviseQuestion
  },
  {
    path: '/questions/:questionId/set_evaluators',
    name: 'setEvaluators',
    component: SetEvaluatorsForQuestion
  },
  {
    path: '/questions/:questionId/evaluate/:qerId',
    name: 'questionEvaluation',
    component: EvaluateQuestion
  }
]

export default questionRoutes
