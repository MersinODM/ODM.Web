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
  <div class="login-page mt-3">
    <div class="login-box">
      <div class="login-logo">
        <a href="http://nevsehirodm.meb.gov.tr/"><b>Nevşehir</b>ÖDM</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <div
            :class="{disabled : isSending}"
            class="login-box-body"
          >
            <p class="login-box-msg">
              Lütfen şifrenizi oluşturunuz.
            </p>

            <form
              method="post"
              @submit.prevent
            >
              <div
                :class="{'has-error': errors.has('password') || isSending}"
                class="form-group has-feedback"
              >
                <input
                  id="password"
                  ref="password"
                  v-model="password"
                  v-validate="'required|min:6|max:10'"
                  type="password"
                  name="password"
                  class="form-control"
                  placeholder="Şifrenizi giriniz"
                >
                <span class="mdi mdi-textbox-password form-control-feedback" />
                <span
                  v-if="errors.has('password')"
                  class="error invalid-feedback"
                >{{ errors.first('password') }}</span>
              </div>
              <div
                :class="{'has-error': errors.has('retypePassword') || isSending }"
                class="form-group has-feedback"
              >
                <input
                  v-model="retypePassword"
                  v-validate="'required|min:6|max:10|confirmed:password'"
                  type="password"
                  name="retypePassword"
                  class="form-control"
                  placeholder="Şifrenizi giriniz"
                >
                <span class="mdi mdi-textbox-password form-control-feedback" />
                <span
                  v-if="errors.has('retypePassword')"
                  class="error invalid-feedback"
                >{{ errors.first('retypePassword') }}</span>
              </div>
              <div class="row">
                <div class="col-xs-offset-4 col-xs-4">
                  <button
                    :class="{ disabled : errors.any() || isSending }"
                    type="submit"
                    class="btn btn-primary btn-block btn-flat"
                    @click="sendPassword"
                  >
                    Oluştur
                  </button>
                </div>
              </div>
            </form>
          </div>
          <spinner
            v-if="isSending"
            spin-style="wave"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Spinner from '../../components/Spinner'
import Messenger from '../../helpers/messenger'

export default {
  name: 'ResetPassword',
  components: { Spinner },
  props: ['email'],
  data () {
    return {
      password: null,
      retypePassword: null,
      isSending: false,
      captchaToken: '',
      recaptchaVerified: false
    }
  },
  beforeCreate () {
    document.body.classList.remove('skin-blue-light', 'sidebar-mini', 'wysihtml5-supported', 'register-page')/* , 'fixed' */
    document.body.classList.add('hold-transition', 'login-page')
  },
  methods: {
    sendPassword () {
      this.$validator.validateAll()
        .then(res => {
          if (res) {
            this.isSending = true
            this.$http.put('/auth/password/reset', {
              token: this.$route.params.token,
              email: this.email,
              password: this.password,
              password_confirmation: this.retypePassword,
              recaptcha: this.captchaToken
            },
            {
              headers: {
                'cache-control': 'no-cache'
              }
            }).then(res => {
              Messenger.showSuccess('Şifre değiştirme/kaydetme işlemi başarılı')
              this.$router.push({ name: 'login' })
              this.isSending = false
            })
          }
        })
    },
    markRecaptchaAsVerified (response) {
      this.captchaToken = response
      this.recaptchaVerified = true
    }
  }
}
</script>

<style lang="sass">
</style>
