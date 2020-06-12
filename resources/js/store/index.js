import Vue from 'vue'
import Vuex from 'vuex'
// import createPersistedState from 'store-persistedstate';
// import authModule from './auth.store'
// import questionModule from './question.store'
// import { abilityPlugin } from './ability.store';
import app from './modules/app'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app
  }
})

export default store
