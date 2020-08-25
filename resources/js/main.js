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

import './bootstrap'
import Vue from 'vue'
import router from './router'
import App from './App'
import store from './store'

import PrettyCheckbox from 'pretty-checkbox-vue/dist/pretty-checkbox-vue.min'
import axios from './helpers/axios'
import VueMask from 'v-mask/dist/v-mask.min'
import ACL from './plugins/ACL'
import VueAxios from 'vue-axios/dist/vue-axios.min'
import PathManPlugin from './plugins/PathManPlugin'
import Loading from 'vue-loading-overlay/dist/vue-loading.min'

Window.Vue = Vue

Vue.use(VueAxios, axios)
Vue.use(ACL)
Vue.use(PathManPlugin)
Vue.use(PrettyCheckbox)
Vue.use(VueMask)
// Vue.use(require('vue-moment'))
Vue.use(Loading, {
  // container: this.$refs.overlayContainer,
  color: '#007bff',
  height: 128,
  width: 128,
  opacity: 0.8
})

// eslint-disable-next-line no-unused-vars
const main = new Vue({
  router,
  store,
  components: { App },
  template: '<App/>'
}).$mount('#app')
