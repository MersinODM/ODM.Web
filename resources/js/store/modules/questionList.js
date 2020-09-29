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
import { MutationsLO, MutationsQT } from '../../helpers/constants'

const state = () => ({
  questionState: '',
  branch: '',
  classLevel: '',
  searchTerm: ''
})

const getters = {
  questionState: (state) => state.questionState,
  branch: (state) => state.branch,
  classLevel: (state) => state.classLevel,
  searchTerm: (state) => state.searchTerm
}

const mutations = {
  [MutationsQT.QUESTION_STATE] (state, questionState) {
    state.questionState = questionState
  },
  [MutationsQT.BRANCH] (state, branch) {
    state.branch = branch
  },
  [MutationsQT.CLASS_LEVEL] (state, classLevel) {
    state.classLevel = classLevel
  },
  [MutationsQT.SEARCH_TERM] (state, searchTerm) {
    state.searchTerm = searchTerm
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
  setSearchTerm ({ commit }, searchTerm) {
    commit(MutationsQT.SEARCH_TERM, searchTerm)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
