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

import { MutationsLO } from '../../helpers/constants'

const state = () => ({
  currentPage: 1,
  totalPages: 0,
  perPage: 0,
  lastPage: 0,
  from: 0,
  to: 0
})

const getters = {
  currentPage: (state) => state.currentPage,
  totalPages: (state) => state.totalPages,
  perPage: (state) => state.perPage,
  lastPage: (state) => state.lastPage,
  from: (state) => state.from,
  to: (state) => state.to
}

const mutations = {
  [MutationsLO.CURRENT_PAGE] (state, currentPage) {
    state.currentPage = currentPage
  },
  [MutationsLO.TOTAL_PAGES] (state, totalPages) {
    state.totalPages = totalPages
  },
  [MutationsLO.PER_PAGE] (state, perPage) {
    state.perPage = perPage
  },
  [MutationsLO.LAST_PAGE] (state, lastPage) {
    state.lastPage = lastPage
  },
  [MutationsLO.FROM] (state, from) {
    state.from = from
  },
  [MutationsLO.TO] (state, to) {
    state.to = to
  }
}

const actions = {
  setCurrentPage ({ commit }, currentPage) {
    commit(MutationsLO.CURRENT_PAGE, currentPage)
  },
  setTotalPages ({ commit }, totalPages) {
    commit(MutationsLO.TOTAL_PAGES, totalPages)
  },
  setPerPage ({ commit }, perPage) {
    commit(MutationsLO.PER_PAGE, perPage)
  },
  setLastPage ({ commit }, lastPage) {
    commit(MutationsLO.LAST_PAGE, lastPage)
  },
  setFrom ({ commit }, from) {
    commit(MutationsLO.FROM, from)
  },
  setTo ({ commit }, to) {
    commit(MutationsLO.TO, to)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
