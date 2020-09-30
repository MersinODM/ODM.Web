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
import { MutationsQT } from '../../helpers/constants'

const state = () => ({
  questionState: '',
  branch: '',
  classLevel: '',
  searchTerm: '',
  isDesignRequired: '',
  currentPage: 0
})

const getters = {
  questionState: (state) => {
    if (!state.questionState) {
      state.questionState = JSON.parse(sessionStorage.getItem(MutationsQT.QUESTION_STATE))
    }
    return state.questionState
  },
  branch: (state) => {
    if (!state.branch) {
      state.branch = JSON.parse(sessionStorage.getItem(MutationsQT.BRANCH))
    }
    return state.branch
  },
  classLevel: (state) => {
    if (!state.classLevel) {
      state.classLevel = JSON.parse(sessionStorage.getItem(MutationsQT.CLASS_LEVEL))
    }
    return state.classLevel
  },
  isDesignRequired: (state) => {
    if (!state.isDesignRequired) {
      state.isDesignRequired = JSON.parse(sessionStorage.getItem(MutationsQT.IS_DESIGN_REQUIRED))
    }
    return state.isDesignRequired
  }
}

const mutations = {
  [MutationsQT.QUESTION_STATE] (state, questionState) {
    state.questionState = questionState
    sessionStorage.setItem(MutationsQT.QUESTION_STATE, JSON.stringify(questionState))
  },
  [MutationsQT.BRANCH] (state, branch) {
    state.branch = branch
    sessionStorage.setItem(MutationsQT.BRANCH, JSON.stringify(branch))
  },
  [MutationsQT.CLASS_LEVEL] (state, classLevel) {
    state.classLevel = classLevel
    sessionStorage.setItem(MutationsQT.CLASS_LEVEL, JSON.stringify(classLevel))
  },
  [MutationsQT.IS_DESIGN_REQUIRED] (state, isDesignRequired) {
    state.isDesignRequired = isDesignRequired
    sessionStorage.setItem(MutationsQT.IS_DESIGN_REQUIRED, JSON.stringify(isDesignRequired))
  }
}

const actions = {
  setSelectedQuestionState ({ commit }, questionState) {
    commit(MutationsQT.QUESTION_STATE, questionState)
  },
  setSelectedClassLevel ({ commit }, classLevel) {
    commit(MutationsQT.CLASS_LEVEL, classLevel)
  },
  setSelectedBranch ({ commit }, branch) {
    commit(MutationsQT.BRANCH, branch)
  },
  setIsDesignRequired ({ commit }, isDesignRequired) {
    commit(MutationsQT.IS_DESIGN_REQUIRED, isDesignRequired)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
