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
          <div class="row">
            <div class="col-xs-offset-4 col-xs-4">
              <button
                :class="{ disabled : errors.any() || isSending }"
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
  data () {
    return {
      email: '',
      isSending: false
    }
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
                this.$http.get('/auth/password/forget', {
                  params: {
                    email: btoa(this.email)
                  }
                }).then(res => {
                  Messenger.showInfo(res.data.message, () => {
                    this.$router.push({ name: 'login' })
                  })
                  this.isSending = false
                })
              }
            })
    }
  }
}
</script>

<style lang="sass">
</style>
