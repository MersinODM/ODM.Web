/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */
import Constants, { Mutations } from '../../helpers/constants'
import AuthService from '../../services/AuthService'
import { SettingService } from '../../services/SettingService'

const state = () => ({
  user: null,
  role: null,
  accessToken: null,
  isSigningIn: false,
  generalInfo: null
})

const getters = {
  currentUser: (state, getters, rootState) => {
    return state.user
  },
  token: (state, getters, rootState) => {
    if (!state.accessToken) {
      state.accessToken = JSON.parse(localStorage.getItem(Constants.accessToken))
    }
    return state.accessToken
  },
  generalInfo: (state, getters, rootState) => {
    if (!state.generalInfo) {
      state.generalInfo = JSON.parse(localStorage.getItem(Constants.generalInfo))
    }
    return state.generalInfo
  }
}

const mutations = {
  [Mutations.SET_USER] (state, { user }) {
    state.user = user
  },
  [Mutations.SAVE_TOKEN] (state, { token }) {
    state.accessToken = token
    localStorage.setItem(Constants.accessToken, JSON.stringify(token))
    localStorage.setItem(Constants.expires_in, token.expires_in)
  },
  [Mutations.SET_ROLES] (state, { rolesAndPermissions }) {
    state.roles = rolesAndPermissions.roles
    // Hem rol hem izin bilgileri sistemden çekiliyor ve localStorage a yazılıyor
    localStorage.setItem(Constants.permissions, JSON.stringify(rolesAndPermissions.roles))
    localStorage.setItem(Constants.roles, JSON.stringify(rolesAndPermissions.permissions))
  },
  [Mutations.SET_GENERAL_INFO] (state, { info }) {
    state.generalInfo = info
    localStorage.setItem(Constants.generalInfo, JSON.stringify(info))
  }
}

const actions = {
  login ({ commit }, credentials) {
    return new Promise((resolve, reject) => {
      let accessToken = null
      AuthService.login(credentials)
        .then((result) => {
          accessToken = result
        })
        .catch((err) => reject(err))
      if (accessToken) {
        commit(Mutations.SAVE_TOKEN, accessToken)
        Promise.all([
          AuthService.setRoleAndPermissions(),
          AuthService.getUser(),
          SettingService.getGeneralInfo()
        ])
          .then(([rolesAndPermissions, user, info]) => {
            commit(Mutations.SET_USER, user)
            commit(Mutations.SET_ROLES, rolesAndPermissions)
            commit(Mutations.SET_GENERAL_INFO, info)
          })
          .catch((error) => reject(error))
      } else {
        reject(new Error('Jeton alınamadı'))
      }
    })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
