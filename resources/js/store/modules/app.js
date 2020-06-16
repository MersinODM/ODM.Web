/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */
import Constants, { Mutations, MessageKeys, ResponseCodes } from '../../helpers/constants'
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
    if (!state.user) {
      state.user = JSON.parse(localStorage.getItem(Constants.CURRENT_USER))
    }
    return state.user
  },
  token: (state, getters, rootState) => {
    if (!state.accessToken) {
      state.accessToken = JSON.parse(localStorage.getItem(Constants.ACCESS_TOKEN))
    }
    return state.accessToken
  },
  expires_in: (state, getters, rootState) => {
    if (!state.expires_in) {
      state.expires_in = JSON.parse(localStorage.getItem(Constants.EXPIRES_IN))
    }
    return state.expires_in
  },
  generalInfo: (state, getters, rootState) => {
    if (!state.generalInfo) {
      state.generalInfo = JSON.parse(localStorage.getItem(Constants.GENERAL_INFO))
    }
    return state.generalInfo
  },
  roles: (state, getters, rootState) => {
    if (!state.roles) {
      state.roles = JSON.parse(localStorage.getItem(Constants.ROLES))
    }
    return state.roles
  }
}

const mutations = {
  [Mutations.SET_USER] (state, user) {
    state.user = user
    localStorage.setItem(Constants.CURRENT_USER, JSON.stringify(user))
  },
  [Mutations.SET_GENERAL_INFO] (state, info) {
    state.generalInfo = info
    localStorage.setItem(Constants.GENERAL_INFO, JSON.stringify(info))
  },
  [Mutations.SAVE_TOKEN] (state, token) {
    state.accessToken = token
    localStorage.setItem(Constants.ACCESS_TOKEN, token.access_token)
    localStorage.setItem(Constants.EXPIRES_IN, token.expires_in)
  },
  [Mutations.SET_ROLES] (state, rolesAndPermissions) {
    state.roles = rolesAndPermissions.roles
    // Hem rol hem izin bilgileri sistemden çekiliyor ve localStorage a yazılıyor
    localStorage.setItem(Constants.ROLES, JSON.stringify(rolesAndPermissions.roles))
    localStorage.setItem(Constants.PERMISSIONS, JSON.stringify(rolesAndPermissions.permissions))
  },
  [Mutations.LOGOUT] (state) {
    Object.keys(state).forEach(k => { state[k] = null })
    localStorage.removeItem(Constants.GENERAL_INFO)
    localStorage.removeItem(Constants.ACCESS_TOKEN)
    localStorage.removeItem(Constants.EXPIRES_IN)
    localStorage.removeItem(Constants.ROLES)
    localStorage.removeItem(Constants.PERMISSIONS)
  }
}

const actions = {
  getGeneralInfo ({ commit }) {
    return new Promise((resolve, reject) => {
      SettingService.getGeneralInfo()
        .then(value => {
          commit(Mutations.SET_GENERAL_INFO, value)
          resolve(value)
        })
        .catch(error => reject(error))
    })
  },
  login ({ commit }, credentials) {
    return new Promise((resolve, reject) => {
      AuthService.login(credentials)
        .then((result) => {
          if (!result.code && result.code === ResponseCodes.CODE_UNAUTHORIZED) {
            reject(result)
          } else {
            commit(Mutations.SAVE_TOKEN, result)
            Promise.all([
              AuthService.setRoleAndPermissions(),
              AuthService.getUser()
            ])
              .then(([rolesAndPermissions, user]) => {
                commit(Mutations.SET_USER, user)
                commit(Mutations.SET_ROLES, rolesAndPermissions)
                resolve({
                  [MessageKeys.MESSAGE]: 'Kullanıcı girişi yapıldı ve tüm ayarlamalar yapıldı',
                  [MessageKeys.CODE]: ResponseCodes.CODE_SUCCESS
                })
              })
              .catch((error) => reject(error))
          }
        })
        .catch((err) => reject(err))
    })
  },
  logout ({ commit }) {
    return new Promise((resolve) => {
      commit(Mutations.LOGOUT)
      resolve({ [ResponseCodes.CODE_SUCCESS]: 'Çıkış başarılı' })
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
