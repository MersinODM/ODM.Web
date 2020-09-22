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

const Constants = {
  CURRENT_USER: 'current_user',
  ACCESS_TOKEN: 'access_token',
  PERMISSIONS: 'permissions',
  ROLES: 'roles',
  EXPIRES_IN: 'expires_in',
  GENERAL_INFO: 'general_info'
}

const ResponseCodes = {
  CODE_SUCCESS: 1000,
  CODE_UNAUTHORIZED: 1001,
  CODE_NOT_FOUND: 1002,
  CODE_INFO: 1003,
  CODE_WARNING: 1004,
  CODE_ERROR: 1005
}

const MessengerConstants = {
  errorMessage: 'Üzgünüz, bir hata ile karşılaştık lütfen sistem yöneticinize başvurunuz!'
}

const MessageKeys = {
  MESSAGE: 'message',
  CODE: 'code'
}

const Mutations = {
  LOGIN_SUCCESSFUL: 'loginSuccessful',
  LOGOUT: 'logout',
  LOGIN_ERROR: 'loginError',
  IS_SIGNING_IN: 'isSigningIn',
  SEARCH_QUESTIONS: 'searchQuestions',
  SET_SEARCH_QUESTIONS_RESULT: 'setSearchQuestionsResult',
  SET_USER: 'setUser',
  SAVE_TOKEN: 'saveToken',
  SET_ROLES: 'setRoles',
  SET_GENERAL_INFO: 'setGeneralInfo'
}

const MutationsLO = {
  CURRENT_PAGE: 'currentPage',
  TOTAL_PAGES: 'totalPages',
  PER_PAGE: 'perPage',
  FROM: 'from',
  TO: 'to',
  LAST_PAGE: 'lastPage',
  CURRENT_BRANCH: 'currentBranch',
  CURRENT_CLASS_LEVEL: 'currentClassLevel',
  SEARCH_TERM: 'searchTerm'
}

export {
  MessengerConstants,
  ResponseCodes,
  Mutations,
  MutationsLO,
  MessageKeys
}

export default Constants
