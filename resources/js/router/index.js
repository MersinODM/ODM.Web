/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import Vue from 'vue'
import Router from 'vue-router'
import Login from '../views/auth/Login'
import MasterView from '../views/master/MasterView'
import RegisterRequest from '../views/auth/RegisterRequest'
import NotFound from '../views/utils/NotFound'
import ResetPassword from '../views/auth/ResetPassword'
// import NewQuestion from '../views/question/NewQuestion'
import UserList from '../views/user/UserList'
import ForgotMyPassword from '../views/auth/ForgotMyPassword'
import Constants from '../helpers/constants'
import User from '../views/user/User'
import NewBranch from '../views/branch/NewBranch'
import BranchList from '../views/branch/BranchList'
import NewLearningOutcome from '../views/learningOutcome/NewLearningOutcome'
import QuestionList from '../views/question/QuestionList'
import ShowQuestion from '../views/question/ShowQuestion'
import SimpleNewQuestion from '../views/question/SimpleNewQuestion'
import QuestionEvaluation from '../views/question/QuestionEvaluation'
import Stats from '../views/info/Stats'
import LearningOutcomeList from '../views/learningOutcome/LearningOutcomeList'
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
      path: '/password/:token',
      name: 'passwordReset',
      component: ResetPassword,
      props: (route) => ({ email: route.query.email }),
      beforeEnter: (to, from, next) => {
        if (to.query.email != null && to.params.token != null) {
          next()
          // console.log('To Query: ' + to.query.email)
          // console.log('To Token: ' + to.params.token)
          // console.log('From: ' + from.query.email)
        } else {
          next('/login')
        }
      }
    },
    {
      path: '/',
      component: MasterView,
      children: [
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
          name: 'questionList',
          component: QuestionList
        },
        {
          path: '/questions/:questionId',
          name: 'showQuestion',
          component: ShowQuestion
        },
        {
          path: '/questions/:questionId/evaluate',
          name: 'questionEvaluation',
          component: QuestionEvaluation
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
        }
      ]
    },
    { path: '*', component: NotFound }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.name === 'login' ||
        to.name === 'register' ||
        to.name === 'forgotMyPassword' ||
        to.name === 'passwordReset'
  ) {
    next()
  } else {
    let token = localStorage.getItem(Constants.accessToken)
    if (token == null) {
      next('/login')
    } else {
      next()
    }
  }
})

export default router
