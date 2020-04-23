<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a :href="sanitizeUrl"><b>{{ city }}</b>ÖDM</a>
      </div>
      <!-- /.login-logo -->
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
          <!--          <div class="form-group has-feedback">-->
          <!--            <input v-model="email" class="form-control" placeholder="Kullancı Adı/E-Posta giriniz">-->
          <!--            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
          <!--          </div>-->
          <div
            :class="{'has-error': errors.has('email') || isSending}"
            class="form-group has-feedback"
          >
            <input
              v-model="email"
              v-validate="'required|email'"
              type="text"
              name="email"
              class="form-control"
              placeholder="Email adresinizi giriniz"
            >
            <span class="mdi mdi-textbox-password form-control-feedback" />
            <span
              v-if="errors.has('email')"
              class="help-block"
            >{{ errors.first('email') }}</span>
          </div>
          <div
            v-if="captchaToken"
            :class="{'has-error': !recaptchaVerified}"
            class="form-group has-feedback"
          >
            <div style="text-align: center;">
              <vueRecaptcha
                style="display: inline-block;"
                :sitekey="captchaToken"
                @verify="markRecaptchaAsVerified"
              />
              <span
                v-if="!recaptchaVerified"
                class="help-block"
              >Lütfen robot olmadığınızı doğrulayın!</span>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-offset-4 col-xs-4">
              <button
                :class="{ disabled : errors.any() ||!recaptchaVerified || isSending }"
                type="submit"
                class="btn btn-primary btn-block btn-flat"
                @click="sendEmail"
              >
                Oluştur
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <div class="alert alert-success text-justify">
        <a
          rel="license"
          href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.tr"
        >
          <img
            alt="Creative Commons Lisansı"
            style="border-width:0"
            src="https://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png"
          >
        </a> Bu eser <a
          rel="license"
          href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.tr"
        > Creative Commons Atıf-GayriTicari-AynıLisanslaPaylaş 4.0 Uluslararası Lisansı</a> ile lisanslanmıştır.
        <a
          class="btn btn-block btn-social btn-github"
          href="https://github.com/electropsycho/ODM.Web"
        >
          <i class="fa fa-github" /> GitHub (Kaynak Kodlar)
        </a>
      </div>
      <spinner
        v-if="isSending"
        spin-style="wave"
      />
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
  </div>
</template>

<script>
import Spinner from '../../components/Spinner'
import Messenger from '../../helpers/messenger'
import vueRecaptcha from 'vue-recaptcha'
import AuthService from '../../services/AuthService'
import Constants, { MessengerConstants } from '../../helpers/constants'
import { sanitizeUrl } from '@braintree/sanitize-url'

export default {
  name: 'ResetPassword',
  components: { Spinner, vueRecaptcha },
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
      const settings = JSON.parse(localStorage.getItem(Constants.generalInfo))
      vm.captchaToken = settings.captcha_public_key
      vm.city = settings.city
    })
  },
  beforeCreate () {
    document.body.classList.remove('skin-blue-light', 'sidebar-mini', 'wysihtml5-supported', 'register-page')/* , 'fixed' */
    document.body.classList.add('hold-transition', 'login-page')
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
                Messenger.showInfo(value.message, () => {
                  this.$router.push({ name: 'login' })
                })
                this.isSending = false
              })
              .catch(() => {
                Messenger.showError(MessengerConstants.errorMessage)
                this.isSending = false
              })
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
