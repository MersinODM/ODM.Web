/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *   Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

import { SEARCH_QUESTIONS, SET_SEARCH_QUESTIONS_RESULT } from './mutation-types'
import QuestionService from '../services/QuestionService'
import Messenger from '../helpers/messenger'

const questionModule = {
// namespaced: true,
  state: {
    classLevel: null,
    isPassed: false,
    branchId: null,
    searchedText: null,
    questions: []
  },
  mutations: {
    [SEARCH_QUESTIONS] (state, searchParams) {
      state.classLevel = searchParams.classLevel
      state.isPassed = searchParams.isPassed
      state.branchId = searchParams.branchId
      state.searchedContent = searchParams.searchedContent
    },
    [SET_SEARCH_QUESTIONS_RESULT] (state, result) {
      state.questions = result
    }
  },
  actions: {
    searchQuestions ({ commit }, searchParams) {
      commit(SEARCH_QUESTIONS, searchParams)
      QuestionService.searchQuestion(searchParams)
        .then(response => commit(SET_SEARCH_QUESTIONS_RESULT, response))
        .catch(err => Messenger.showError(err.message))
    }
  },
  getters: {
    classLevel (state) {
      return state.classLevel
    },
    isPassed (state) {
      return state.isPassed
    },
    branchId (state) {
      return state.branchId
    },
    searchedContent (state) {
      return state.searchedContent
    },
    questions (state) {
      return state.questions
    }
  }
}
//
export default questionModule
