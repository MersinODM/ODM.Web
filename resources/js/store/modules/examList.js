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

import { MutationsEL } from '../../helpers/constants'

const state = {
  examPurpose: '',
  classLevel: ''
}

const getters = {
  examPurpose: (state) => {
    if (!state.examPurpose) {
      state.examPurpose = JSON.parse(sessionStorage.getItem(MutationsEL.EXAM_PURPOSE))
    }
    return state.examPurpose
  },
  classLevel: (state) => {
    if (!state.classLevel) {
      state.classLevel = JSON.parse(sessionStorage.getItem(MutationsEL.CLASS_LEVEL))
    }
    return state.classLevel
  }
}

const mutations = {
  [MutationsEL.EXAM_PURPOSE] (state, examPurpose) {
    state.examPurpose = examPurpose
    sessionStorage.setItem(MutationsEL.EXAM_PURPOSE, JSON.stringify(examPurpose))
  },
  [MutationsEL.CLASS_LEVEL] (state, classLevel) {
    state.classLevel = classLevel
    sessionStorage.setItem(MutationsEL.CLASS_LEVEL, JSON.stringify(classLevel))
  }
}

const actions = {
  setExamPurpose ({ commit }, examPurpose) {
    commit(MutationsEL.EXAM_PURPOSE, examPurpose)
  },
  setClassLevel ({ commit }, classLevel) {
    commit(MutationsEL.CLASS_LEVEL, classLevel)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
