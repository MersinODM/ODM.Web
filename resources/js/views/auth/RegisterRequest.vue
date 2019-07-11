<template>
  <div class="register-box">
    <div class="register-logo">
      <a href="https://nevsehir.meb.gov.tr"><b>Nevşehir</b>ÖDM</a>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">
        Yeni kullanıcı açma talep formu
      </p>
      <form @submit.prevent>
        <div
          class="form-group has-feedback"
          :class="{'has-error': errors.has('full_name')}"
        >
          <input
            v-model="full_name"
            v-validate="'required|min:2|alpha_spaces'"
            name="full_name"
            type="text"
            class="form-control"
            placeholder="Ad Soyad"
          >
          <span class="glyphicon glyphicon-user form-control-feedback" />
          <span
            v-if="errors.has('full_name')"
            class="help-block"
          >{{ errors.first('full_name') }}</span>
        </div>
        <!--        <div class="form-group has-feedback">-->
        <!--          <input v-model="tcId" type="text" class="form-control" placeholder="T.C. Kimlik No">-->
        <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
        <!--        </div>-->
        <div
          class="form-group has-feedback"
          :class="{'has-error': errors.has('inst')}"
        >
          <v-select
            v-model="inst"
            v-validate="'required'"
            :options="institutions"
            :reduce="inst => inst.id"
            label="name"
            name="inst"
            placeholder="Kurum adını en az 3 harf girin"
            @search="searchInstitutions"
          >
            <div slot="no-options">
              Burada bişey bulamadık :-(
            </div>
          </v-select>
          <span
            v-if="errors.has('inst')"
            class="help-block"
          >{{ errors.first('inst') }}</span>
        </div>
        <!--        <div class="form-group has-feedback">-->
        <!--          <input v-model="title" class="form-control"-->
        <!--                 placeholder="Görevi/Unvanı(Öğretmen, Okul Müdürü vb.)">-->
        <!--          <span class="fa fa-user-times form-control-feedback"></span>-->
        <!--        </div>-->
        <div
          class="form-group has-feedback"
          :class="{'has-error': errors.has('branch')}"
        >
          <v-select
            v-model="branch"
            v-validate="'required'"
            :options="branches"
            :reduce="branch => branch.id"
            label="name"
            name="branch"
            placeholder="Alan/Ders adını en az 3 harf girin"
            @search="searchBranches"
          >
            <div slot="no-options">
              Burada bişey bulamadık :-(
            </div>
          </v-select>
          <span
            v-if="errors.has('branch')"
            class="help-block"
          >{{ errors.first('branch') }}</span>
          <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
          <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
        </div>
        <div
          class="form-group has-feedback"
          :class="{'has-error': errors.has('email')}"
        >
          <input
            v-model="email"
            v-validate="'required|email'"
            name="email"
            class="form-control"
            type="email"
            placeholder="E-Posta adresi"
          >
          <span class="glyphicon glyphicon-envelope form-control-feedback" />
          <span
            v-if="errors.has('email')"
            class="help-block"
          >{{ errors.first('email') }}</span>
        </div>
        <div
          class="form-group has-feedback"
          :class="{'has-error': errors.has('phone')}"
        >
          <input
            v-model="phone"
            v-mask="'(###)-###-####'"
            v-validate="'required'"
            type="text"
            name="phone"
            class="form-control"
            placeholder="(999)-999-9999"
          >
          <span class="glyphicon glyphicon-phone form-control-feedback" />
          <span
            v-if="errors.has('phone')"
            class="help-block"
          >{{ errors.first('phone') }}</span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-offset-3 col-xs-6">
            <button
              :class="{ disabled: errors.any() || isSending }"
              class="btn btn-primary btn-block btn-flat"
              @click="sendRegisterRequest"
            >
              Kayıt Talebi Oluştur
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <br>
      <router-link
        :to="{name: 'login' }"
        exact
      >
        Halihazırda bir hesabım var
        <span class="fa fa-user-secret" />
      </router-link>
    </div>
  </div>
</template>

<script>

import vSelect from 'vue-select'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'

export default {
  name: 'RegisterRequest',
  components: { vSelect },
  data () {
    return {
      full_name: '',
      branch: null,
      inst: null,
      title: '',
      email: null,
      phone: '',
      institutions: [],
      branches: [],
      isSending: false
    }
  },
  beforeCreate () {
    document.body.classList.remove('skin-blue-light', 'sidebar-mini', 'wysihtml5-supported', 'login-page')/* , 'fixed' */
    document.body.classList.add('hold-transition', 'register-page')
  },
  methods: {
    searchInstitutions (search, loading) {
      // console.log(this.$http)
      if (search.length >= 3) {
        this.$http.get('/auth/institutions', {
          params: {
            searchTerm: search
          }
        })
          .then(result => {
            console.log(result)
            this.institutions = result.data
          })
          .catch(res => console.log(res))
      }
    },
    searchBranches (search, loading) {
      if (search.length >= 3) {
        this.$http.get('/auth/branches', {
          params: {
            searchTerm: search
          }
        })
          .then(result => {
            // console.log(result)
            this.branches = result.data
          })
          .catch(res => console.log(res))
      }
    },
    sendRegisterRequest () {
      this.$validator.validateAll()
        .then(res => {
          if (res) {
            this.isSending = true
            this.$http.post('/auth/register', {
              email: this.email,
              full_name: this.full_name,
              inst_id: this.inst,
              branch_id: this.branch,
              phone: this.phone.replace(/[^0-9]/gi, '')
            })
              .then(response => {
                this.isSending = false
                Messenger.showSuccess(response.data.message)
              })
              .catch(error => {
                console.log(error)
                this.isSending = false
                if (error.response.status === 409) {
                  Messenger.showWarning(error.response.data.message)
                  return
                }
                Messenger.showError(MessengerConstants.errorMessage)
              })
          }
        })
    }
  }
}
</script>

<style lang="sass">
  @import '~vue-select/dist/vue-select.css'
</style>
