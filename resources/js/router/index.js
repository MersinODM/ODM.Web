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

import Vue from 'vue'
import Router from 'vue-router'
import Login from '../views/auth/Login'
import MasterView from '../views/master/MasterView'
import RegisterRequest from '../views/auth/RegisterRequest'
import NotFound from '../views/utils/NotFound'
// import NewQuestion from '../views/question/NewQuestion'
import UserList from '../views/user/UserList'
import ForgotMyPassword from '../views/auth/ForgotMyPassword'
import Constants from '../helpers/constants'
import User from '../views/user/User'
import NewBranch from '../views/branch/NewBranch'
import BranchList from '../views/branch/BranchList'
import NewLearningOutcome from '../views/learningOutcome/NewLearningOutcome'
import ShowQuestion from '../views/question/ShowQuestion'
import SimpleNewQuestion from '../views/question/SimpleNewQuestion'
import Stats from '../views/info/Stats'
import LearningOutcomeList from '../views/learningOutcome/LearningOutcomeList'
import NewInstitution from '../views/institution/NewInstitution'
import PassiveUserList from '../views/user/PassiveUserList'
import QuestionDeleteRequests from '../views/question/QuestionDeleteRequests'
import QuestionTableList from '../views/question/QuestionTableList'
import QuestionEvaluationRequestList from '../views/question/QuestionEvaluationRequestList'
import EvaluateQuestion from '../views/question/EvaluateQuestion'
import ReviseQuestion from '../views/question/ReviseQuestion'
import SetEvaluatorsForQuestion from '../views/question/SetEvaluatorsForQuestion'
import UnderConstruction from '../views/utils/UnderConstruction'
import AppSettings from '../views/management/AppSettings'
import InstitutionList from '../views/institution/InstitutionList'
import EditInstitution from '../views/institution/EditInstitution'
import examRoutes from './examRouter'
// import Stats from '../views/info/Stats'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: 'otomasyon',
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterRequest
    },
    {
      path: '/forgot_my_password',
      name: 'forgotMyPassword',
      component: ForgotMyPassword
    },
    {
      path: '/',
      component: MasterView,
      children: [
        ...examRoutes,
        {
          path: '',
          name: 'stats',
          component: Stats
        },
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
        },
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
          path: '/users/list',
          name: 'users',
          component: UserList
        },
        {
          path: '/users/passives/list',
          name: 'passiveUsers',
          component: PassiveUserList
        },
        {
          path: '/users/:id',
          name: 'user',
          component: User
        },
        {
          path: '/branches/new',
          name: 'newBranch',
          component: NewBranch
        },
        {
          path: '/branches/list',
          name: 'branchList',
          component: BranchList
        },
        {
          path: 'institutions/new',
          name: 'newInst',
          component: NewInstitution
        },
        {
          path: 'institutions/:instId/edit',
          name: 'editInst',
          component: EditInstitution
        },
        {
          path: 'institutions',
          name: 'institutions',
          component: InstitutionList
        },
        {
          path: 'under_construction',
          name: 'underConstruction',
          component: UnderConstruction
        },
        {
          path: 'app_settings',
          name: 'appSettings',
          component: AppSettings
        }
      ]
    },
    { path: '*', component: NotFound }
  ]
})

// TODO Burada role denetimi yapılacak
router.beforeEach((to, from, next) => {
  if (to.name === 'login' ||
        to.name === 'register' ||
        to.name === 'forgotMyPassword' ||
        to.name === 'passwordReset'
  ) {
    next()
  } else {
    const token = localStorage.getItem(Constants.ACCESS_TOKEN)
    if (token == null) {
      next('/login')
    } else {
      next()
    }
  }
})

export default router
