<!--
  - ODM.Web  https://github.com/electropsycho/ODM.Web
  - Copyright (C) 2020 Hakan GÜLEN
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU General Public License as published by
  - the Free Software Foundation, either version 3 of the License, or
  - (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU General Public License for more details.
  -
  - You should have received a copy of the GNU General Public License
  - along with this program.  If not, see http://www.gnu.org/licenses/
  -->

<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a :href="sanitizeUrl"><b>{{ city }}</b>ÖDM</a>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <div
            :class="{disabled : isSending}"
            class="login-box-body"
          >
            <p class="login-box-msg">
              Lütfen e posta adresinizi giriniz.
            </p>

            <form
              method="post"
              @submit.prevent
            >
              <div class="input-group mb-3">
                <input
                  v-model="email"
                  v-validate="'required|email'"
                  type="text"
                  name="email"
                  class="form-control"
                  :class="{'is-invalid': errors.has('email') || isSending}"
                  placeholder="Email adresinizi giriniz"
                >
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="mdi mdi-email  form-control-feedback" />
                  </div>
                </div>
                <span
                  v-if="errors.has('email')"
                  class="error invalid-feedback"
                >{{ errors.first('email') }}</span>
              </div>
              <div
                v-if="captchaToken"
                :class="{'is-invalid': !recaptchaVerified}"
                class="mx-auto"
              >
                <div style="text-align: center;">
                  <vueRecaptcha
                    style="display: inline-block;"
                    :sitekey="captchaToken"
                    @verify="markRecaptchaAsVerified"
                  />
                  <span
                    v-if="!recaptchaVerified"
                    class="error invalid-feedback"
                  >Lütfen robot olmadığınızı doğrulayın!</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 mt-2">
                  <button
                    :class="{ disabled : errors.any() ||!recaptchaVerified || isSending }"
                    type="submit"
                    class="btn btn-primary btn-block"
                    @click="sendEmail"
                  >
                    Gönder
                  </button>
                </div>
                <!-- /.col -->
              </div>
            </form>
            <div class="row mt-2">
              <div class="col-sm-12">
                <router-link
                  :to="{ name: 'login' }"
                >
                  Şifremi hatırladım
                  <span class="mdi mdi-head-lightbulb" />
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <licence-login />
      <spinner
        v-if="isSending"
        spin-style="wave"
      />
    </div>
  </div>
</template>

<script>
import Spinner from '../../components/Spinner'
import Messenger from '../../helpers/messenger'
import vueRecaptcha from 'vue-recaptcha/dist/vue-recaptcha.min'
import AuthService from '../../services/AuthService'
import Constants, { MessengerConstants } from '../../helpers/constants'
import { sanitizeUrl } from '@braintree/sanitize-url'
import LicenceLogin from '../../components/LicenceLogin'
import SkinHelper from '../../helpers/SkinHelper'

export default {
  name: 'ResetPassword',
  components: { LicenceLogin, Spinner, vueRecaptcha },
  data () {
    return {
      email: '',
      isSending: false,
      recaptchaVerified: false,
      captchaToken: '',
      city: ''
    }
  },
  computed: {
    sanitizeUrl () {
      return sanitizeUrl(this.web_address)
    }
  },
  beforeRouteEnter (to, from, next) {
    next(vm => {
      const settings = JSON.parse(localStorage.getItem(Constants.GENERAL_INFO))
      vm.captchaToken = settings.captcha_public_key
      vm.city = settings.city
    })
  },
  beforeCreate () {
    SkinHelper.LoginSkin()
  },
  methods: {
    sendEmail () {
      this.$validator.validateAll()
        .then(res => {
          if (res) {
            this.isSending = true
            const data = { email: this.email, recaptcha: this.captchaToken }
            AuthService.forgetPassword(data)
              .then(value => {
                Messenger.showInfo(value.message)
                  .then(value => { this.$router.push({ name: 'login' }) })
                  .catch(() => { Messenger.showError(MessengerConstants.errorMessage) })
              })
              .catch(() => {
                Messenger.showError(MessengerConstants.errorMessage)
              })
              .finally(() => { this.isSending = false })
          }
        })
    },
    markRecaptchaAsVerified (response) {
      // console.log(response)
      this.captchaToken = response
      this.recaptchaVerified = true
    }
  }
}
</script>

<style lang="sass">
</style>
