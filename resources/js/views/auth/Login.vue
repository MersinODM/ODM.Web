<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <!--        <div class="row">-->
        <!--          <div class="text-center">-->
        <!--            <img src="images/Logo.PNG" class="img-circle" alt="...">-->
        <!--          </div>-->
        <!--        </div>-->
        <a href="http://nevsehirodm.meb.gov.tr/"><b>Nevşehir</b>ÖDM</a>
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
            <span class="glyphicon glyphicon-envelope form-control-feedback" />
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
            <span class="glyphicon glyphicon-lock form-control-feedback" />
            <span
              v-if="errors.has('password')"
              class="help-block"
            >{{ errors.first('password') }}</span>
          </div>
          <div class="row">
            <!--<div class="col-xs-8">-->
            <!--<p-check v-model="isChecked" class="p-icon p-smooth" color="primary">-->
            <!--<i slot="extra" class="icon fa fa-check"></i>-->
            <!--fa-check-->
            <!--</p-check>-->
            <!--</div>-->
            <!-- /.col -->
            <div class="col-xs-offset-8 col-xs-4">
              <button
                :class="{ disabled : errors.any() || isSigningIn }"
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

        <a href="#">Şifremi unuttum</a><br>
        <router-link
          :to="{ name: 'register' }"
          class="text-center"
        >
          Yeni kayıt talebi oluştur
          <span class="fa fa-user-secret" />
        </router-link>
      </div>
      <spinner
        v-if="isSigningIn"
        spin-style="wave"
      />
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
  </div>
</template>

<script>
// import axios from 'axios';
// import { mapGetters, mapActions } from 'vuex';
// import { createNamespacedHelpers } from 'vuex';
import Spinner from '../../components/Spinner'
import Auth from '../../services/AuthService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'

// const { mapActions, mapGetters } = createNamespacedHelpers('some/nested/module');
export default {
  name: 'Login',
  components: { Spinner },
  data () {
    return {
      email: '',
      password: '',
      isSigningIn: false
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
            let credentials = {
              email: this.email,
              password: this.password
            }
            Auth.login(credentials, () => {
              this.isSigningIn = !this.isSigningIn
            })
          }
        })
      this.isSigningIn = !this.isSigningIn
    }
  },
  beforeRouteLeave (to, from, next) {
    if (to.name === 'register' || to.name === 'forgotMyPassword') { next() } else {
      Auth.setRoleAndPermissions()
        .then(value => next())
        .catch(reason => {
          console.log(reason)
          this.isSigningIn = false
          Messenger.showError(MessengerConstants.errorMessage)
          next('/login')
        })
    }
  }
}
</script>

<style>

</style>
