import Vue from 'vue'
import Vuex from 'vuex'
// import createPersistedState from 'vuex-persistedstate';
// import authModule from './auth.store'
import questionModule from './question.vuex'
// import { abilityPlugin } from './ability.store';

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    // auth: authModule,
    questionModule: questionModule
  },
  plugins: [
    // createPersistedState(),
    // abilityPlugin,
  ]
})

export default store
