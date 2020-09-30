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
import Vuex from 'vuex'
import app from './modules/app'
import learningOutcome from './modules/learningOutcome'
import questionList from './modules/questionList'
import examList from './modules/examList'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    learningOutcome,
    questionList,
    examList
  }
})

export default store
