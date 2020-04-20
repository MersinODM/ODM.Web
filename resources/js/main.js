// import starter from './app.bootstrap.js'
import './bootstrap'
import Vue from 'vue'
import router from './router'
import App from './App'
import store from './store'

import PrettyCheckbox from 'pretty-checkbox-vue'
import tr from 'vee-validate/dist/locale/tr'
import { dictionary } from './helpers/validator'
import VeeValidate, { Validator } from 'vee-validate'
import axios from './helpers/axios'
import VueMask from 'v-mask'
import ACL from './plugins/ACL'
import VueAxios from 'vue-axios'
import PathManPlugin from './plugins/PathManPlugin'
import Loading from 'vue-loading-overlay'

Window.Vue = Vue

Vue.use(VueAxios, axios)
Vue.use(ACL)
Vue.use(PathManPlugin)
Vue.use(PrettyCheckbox)
Vue.use(VeeValidate)
Vue.use(VueMask)
// Vue.use(require('vue-moment'))
Vue.use(Loading, {
  // container: this.$refs.overlayContainer,
  color: '#007bff',
  height: 128,
  width: 128,
  opacity: 0.8
})

Validator.localize('tr', tr)
Validator.localize(dictionary)

VeeValidate.Validator.extend('verify_password', {
  getMessage: field => 'Şifre en az: 1 büyük harf, 1 küçük harf, 1 rakam, ve bir özel karakter içermelidir(. , @ _ & ? + vs.)',
  validate: value => {
    const strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[#$^+=!*()@%&.]).{8,16}')
    return strongRegex.test(value)
  }
})

// eslint-disable-next-line no-unused-vars
const main = new Vue({
  router,
  store,
  // render: h => h(App),
  components: { App },
  template: '<App/>'
}).$mount('#app')
