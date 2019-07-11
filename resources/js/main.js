// import starter from './app.bootstrap.js'
import './bootstrap'
import Vue from 'vue'
import router from './router'
import App from './App'
import store from './store'

import 'bootstrap/dist/js/bootstrap.min'
import 'jquery-ui'
import 'jquery-slimscroll/jquery.slimscroll.min'
import 'fastclick/lib/fastclick'
import 'admin-lte/dist/js/adminlte.min'
import 'pace-js/pace.min'

import PrettyCheckbox from 'pretty-checkbox-vue'
import tr from 'vee-validate/dist/locale/tr'
import { dictionary } from './helpers/validator'
import VeeValidate, { Validator } from 'vee-validate'
import axios from './helpers/axios'
import VueMask from 'v-mask'
import ACL from './plugins/ACL'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
Vue.use(ACL)
Vue.use(PrettyCheckbox)
Vue.use(VeeValidate)
Vue.use(VueMask)

Validator.localize('tr', tr)
Validator.localize(dictionary)

const main = new Vue({
  router,
  store,
  // render: h => h(App),
  components: { App },
  template: '<App/>'
}).$mount('#app')

window.Vue = main
