// import Vue from 'vue'
// // import ApiService from '../services/api.service'
// import router from '../router'
// import { IS_SIGNING_IN, LOGIN_ERROR, LOGIN_SUCCESSFUL, LOGOUT } from './mutation-types'
// // import JwtUser from '../models/User';
// // import defineAbilities from '../services/ability.service';
//
// const auth = {
//   // namespaced: true,
//   state: {
//     currentUser: null,
//     role: null,
//     signedIn: false,
//     jwtToken: '',
//     isSigningIn: false,
//     jwtUser: null,
//     abilities: null
//   },
//   mutations: {
//     [LOGOUT] (state) {
//       state.access_token = null
//       state.jwtUser = null
//       state.signedIn = null
//     },
//     [IS_SIGNING_IN] (state, val) {
//       state.isSigningIn = val
//     },
//     [LOGIN_ERROR] (error) {
//       console.log(error)
//       Vue.swal('Oturum açma hatası')
//     },
//     [LOGIN_SUCCESSFUL] (state, jwtToken) {
//       state.access_token = jwtToken
//       state.jwtUser = new JwtUser(jwtToken)
//       state.signedIn = true
//       // state.abilities = defineAbilities(state.jwtUser);
//     }
//   },
//   actions: {
//     login ({ commit }, userLoginInfo) {
//       console.log(`${userLoginInfo.username} ${userLoginInfo.password}`)
//       commit(IS_SIGNING_IN, true)
//       ApiService.post('/auth/token', {
//         kullanici_adi: userLoginInfo.username,
//         sifre: userLoginInfo.password
//       })
//         .then((resp) => {
//           console.log(resp.data.access_token);
//           commit(LOGIN_SUCCESSFUL, resp.data.access_token)
//           commit(IS_SIGNING_IN, false)
//           router.push('/dashboard/phone_chain/list')
//         })
//         .catch((error) => {
//           commit(IS_SIGNING_IN, false)
//           commit(LOGIN_ERROR, error)
//         })
//     },
//     logout ({ commit }) {
//       commit(LOGOUT)
//       router.push('/login')
//     }
//   },
//   getters: {
//     currentUser (state) {
//       return state.jwtUser
//     },
//     isSignedIn (state) {
//       return state.signedIn
//     },
//     isSigningIn (state) {
//       return state.isSigningIn
//     },
//     jwtToken (state) {
//       return state.jwtToken
//     },
//     instId (state) {
//       return state.instId
//     }
//   }
// }
//
// export default auth
