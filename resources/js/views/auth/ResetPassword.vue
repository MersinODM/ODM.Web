<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="http://nevsehirodm.meb.gov.tr/"><b>Nevşehir</b>ÖDM</a>
      </div>
      <!-- /.login-logo -->
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
          <!--          <div class="form-group has-feedback">-->
          <!--            <input v-model="email" class="form-control" placeholder="Kullancı Adı/E-Posta giriniz">-->
          <!--            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
          <!--          </div>-->
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
              class="help-block"
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
              class="help-block"
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
            <!-- /.col -->
          </div>
        </form>
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
