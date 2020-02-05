<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <!--        <div class="row">-->
        <!--          <div class="text-center">-->
        <!--            <img src="images/Logo.PNG" class="img-circle" alt="...">-->
        <!--          </div>-->
        <!--        </div>-->
        <a :href="sanitizeUrl"><b>{{ settings.city }}</b>ÖDM</a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">
          Kullanmaya başlamak için lütfen oturum açınız.
        </p>

        <form
          method="post"
          @submit.prevent
        >
          <div
            :class="{'has-error': errors.has('email')}"
            class="form-group has-feedback"
          >
            <input
              v-model="email"
              v-validate="'required|email'"
              name="email"
              class="form-control"
              autocomplete="username"
              placeholder="Kullancı Adı/E-Posta giriniz"
            >
            <span class="mdi mdi-email form-control-feedback" />
            <span
              v-if="errors.has('email')"
              class="help-block"
            >{{ errors.first('email') }}</span>
          </div>
          <div
            :class="{'has-error': errors.has('password')}"
            class="form-group has-feedback"
          >
            <input
              v-model="password"
              v-validate="'required|min:6|max:10'"
              name="password"
              type="password"
              class="form-control"
              autocomplete="current-password"
              placeholder="Şifrenizi giriniz"
            >
            <span class="mdi mdi-lock form-control-feedback" />
            <span
              v-if="errors.has('password')"
              class="help-block"
            >{{ errors.first('password') }}</span>
          </div>
          <div
            :class="{'has-error': !recaptchaVerified}"
            class="form-group has-feedback"
          >
            <div
              v-if="siteKey"
              style="text-align: center;"
            >
              <vueRecaptcha
                style="display: inline-block;"
                :sitekey="siteKey"
                @verify="markRecaptchaAsVerified"
              />
              <span
                v-if="!recaptchaVerified"
                class="help-block"
              >Lütfen robot olmadığınızı doğrulayın!</span>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-offset-8 col-xs-4">
              <button
                :class="{ disabled : errors.any() || !recaptchaVerified || isSigningIn }"
                type="submit"
                class="btn btn-primary btn-block btn-flat"
                @click="loginUser"
              >
                Oturum Aç
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- /.social-auth-links -->

        <router-link :to="{ name: 'forgotMyPassword' }">
          Şifremi unuttum
          <span class="mdi mdi-passport-biometric" />
        </router-link>
        <br>
        <router-link
          :to="{ name: 'register' }"
          class="text-center"
        >
          Yeni kayıt talebi oluştur
          <span class="mdi mdi-account-plus" />
        </router-link>
      </div>
      <!-- /.login-box-body -->
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
    </div>
    <!-- /.login-box -->
  </div>
</template>

<script>
// import axios from 'axios';
// import { mapGetters, mapActions } from 'vuex';
// import { createNamespacedHelpers } from 'vuex';
import AuthService from '../../services/AuthService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import vueRecaptcha from 'vue-recaptcha'
import { SettingService } from '../../services/SettingService'
import { sanitizeUrl } from '@braintree/sanitize-url'

// const { mapActions, mapGetters } = createNamespacedHelpers('some/nested/module');
export default {
  name: 'Login',
  components: { vueRecaptcha },
  data () {
    return {
      recaptchaVerified: false,
      captchaToken: '',
      email: '',
      password: '',
      isSigningIn: false,
      settings: {},
      web_address: '',
      siteKey: ''
    }
  },
  beforeRouteEnter (to, from, next) {
    SettingService.getSettings()
      .then(value => {
        next(vm => {
          vm.settings = value
          vm.web_address = value.web_address
          localStorage.setItem('settings', JSON.stringify(value))
          vm.siteKey = value.captcha_public_key
        })
      })
  },
  computed: {
    sanitizeUrl () {
      return sanitizeUrl(this.web_address)
    }
  },
  beforeCreate () {
    document.body.classList.remove('skin-blue-light', 'sidebar-mini', 'wysihtml5-supported', 'register-page')/* , 'fixed' */
    document.body.classList.add('hold-transition', 'login-page')
  },
  methods: {
    loginUser () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            const credentials = {
              email: this.email,
              password: this.password,
              recaptcha: this.captchaToken
            }
            this.isSigningIn = true
            const loader = this.$loading.show()
            AuthService.login(credentials)
              .then(value => {
                if (value.code === 401) {
                  Messenger.showWarning(value.message)
                  this.isSigningIn = false
                  loader.hide()
                } else {
                  this.$router.push({ name: 'stats' })
                  this.isSigningIn = true
                  loader.hide()
                }
              })
              .catch((err) => {
                console.log(err)
                this.isSigningIn = false
                Messenger.showWarning('Oturumunuz açılamadı, e-posta, şifre ve robot doğrulamasını kontrol ediniz.\n' +
                                 'Hatasız giriş yatığınızı düşünüyosanız sistem yöneticinize başvurunuz.')
              })
          }
        })
    },
    markRecaptchaAsVerified (response) {
      // console.log(response)
      this.captchaToken = response
      this.recaptchaVerified = true
    }
  },
  beforeRouteLeave (to, from, next) {
    if (to.name === 'register' || to.name === 'forgotMyPassword') { next() } else {
      AuthService.setRoleAndPermissions()
        .then(value => next())
        .catch(reason => {
          console.log(reason)
          Messenger.showError(MessengerConstants.errorMessage)
          next('/login')
        })
    }
  }
}
</script>

<style>
  @media screen and (max-width: 575px) {
    #rc-imageselect, .g-recaptcha
    {
      transform:scale(0.77);
      -webkit-transform:scale(0.77);transform-origin:0 0;
      -webkit-transform-origin:0 0;
    }
  }
</style>
