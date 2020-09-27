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
  <div class="register-box mt-4">
    <div class="register-logo">
      <a :href="sanitizeUrl"><b>{{ city }}</b>ÖDM</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">
          Yeni kullanıcı açma talep formu
        </p>
        <form
          method="post"
          @submit.prevent
        >
          <div class="input-group mb-3">
            <input
              v-model="full_name"
              v-validate="'required|min:2|alpha_spaces'"
              name="full_name"
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.has('full_name')}"
              placeholder="Ad Soyad"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="mdi mdi-account" />
              </div>
            </div>
            <span
              v-if="errors.has('full_name')"
              class="error invalid-feedback"
            >{{ errors.first('full_name') }}</span>
          </div>
          <div class="form-group mb-3">
            <v-select
              v-model="inst"
              v-validate="'required'"
              :options="institutions"
              :reduce="inst => inst.id"
              :class="{'is-invalid': errors.has('inst')}"
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
              class="error invalid-feedback"
            >{{ errors.first('inst') }}</span>
          </div>
          <div class="form-group has-feedback">
            <v-select
              v-model="branch"
              v-validate="'required'"
              :options="branches"
              :reduce="branch => branch.id"
              :class="{'is-invalid': errors.has('branch')}"
              label="name"
              name="branch"
              placeholder="Alan/Ders seçiniz"
            >
              <div slot="no-options">
                Burada bişey bulamadık :-(
              </div>
            </v-select>
            <span
              v-if="errors.has('branch')"
              class="error invalid-feedback"
            >{{ errors.first('branch') }}</span>
          </div>
          <div class="input-group mb-3">
            <input
              v-model="email"
              v-validate="'required|email'"
              name="email"
              class="form-control"
              :class="{'is-invalid': errors.has('email')}"
              type="email"
              placeholder="E-Posta adresi"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="mdi mdi-email" />
              </div>
            </div>
            <span
              v-if="errors.has('email')"
              class="error invalid-feedback"
            >{{ errors.first('email') }}</span>
          </div>
          <div class="input-group mb-3">
            <input
              v-model="phone"
              v-mask="'### ### ####'"
              v-validate="{ required: true, regex:/[0-9]{1,3}[ ][0-9]{1,3}[ ][0-9]{4}$/ }"
              type="text"
              name="phone"
              class="form-control"
              :class="{'is-invalid': errors.has('phone')}"
              placeholder="Tel. no başında 0 olmadan giriniz"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="mdi mdi-phone" />
              </div>
            </div>
            <span
              v-if="errors.has('phone')"
              class="error invalid-feedback"
            >{{ errors.first('phone') }}</span>
          </div>
          <div
            :class="{'is-invalid': !recaptchaVerified}"
            class="mx-auto mb-3"
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
                class="error invalid-feedback"
              >Lütfen robot olmadığınızı doğrulayın!</span>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <button
                :class="{ disabled: errors.any() ||!recaptchaVerified || isSending }"
                class="btn btn-primary btn-block"
                @click="sendRegisterRequest"
              >
                Kayıt Talebi Oluştur
              </button>
            </div>
          </div>
        </form>
        <br>
        <router-link
          :to="{name: 'login' }"
          exact
        >
          Halihazırda bir hesabım var
          <span class="mdi mdi-passport" />
        </router-link>
      </div>
    </div>
    <licence-info />
  </div>
</template>

<script>
import debounce from 'lodash/debounce'
import vSelect from 'vue-select'
import Messenger from '../../helpers/messenger'
import Constants, { MessengerConstants } from '../../helpers/constants'
import vueRecaptcha from 'vue-recaptcha/dist/vue-recaptcha.min'
import BranchService from '../../services/BranchService'
import InstitutionService from '../../services/InstitutionService'
import AuthService from '../../services/AuthService'
import { sanitizeUrl } from '@braintree/sanitize-url'
import LicenceInfo from '../../components/LicenceInfo'
import SkinHelper from '../../helpers/SkinHelper'

export default {
  name: 'RegisterRequest',
  components: { LicenceInfo, vSelect, vueRecaptcha },
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
      isSending: false,
      recaptchaVerified: false,
      siteKey: '',
      city: '',
      web_address: ''
    }
  },
  computed: {
    sanitizeUrl () {
      return sanitizeUrl(this.web_address)
    }
  },
  beforeCreate () {
    SkinHelper.LoginSkin()
  },
  beforeRouteEnter (to, from, next) {
    BranchService.getAllForRegisterReq()
      .then((branches) => {
        next(vm => {
          vm.branches = branches
          const settings = JSON.parse(localStorage.getItem(Constants.GENERAL_INFO))
          vm.siteKey = settings.captcha_public_key
          vm.city = settings.city
          vm.web_address = settings.web_address
        })
      })
  },
  methods: {
    searchInstitutions: debounce(function (search, loading) {
      if (search) {
        loading(true)
        InstitutionService.findByName(search)
          .then(value => {
            this.institutions = value
            loading(false)
          })
          .catch(err => {
            loading(false)
            Messenger.showError(err.message)
          })
      }
    }, 1000),
    async sendRegisterRequest () {
      const validationResult = await this.$validator.validateAll()
      if (validationResult) {
        this.isSending = true
        const data = {
          email: this.email,
          full_name: this.full_name,
          inst_id: this.inst,
          branch_id: this.branch,
          phone: this.phone.replace(/[^0-9]/gi, ''),
          recaptcha: this.captchaToken
        }
        try {
          const response = await AuthService.createRegisterRequest(data)
          this.isSending = false
          await Messenger.showSuccess(response.message)
          await this.$router.push({ name: 'login' })
        } catch (error) {
          this.isSending = false
          if (error.response.status === 409) {
            await Messenger.showWarning(error.response.data.message)
            return
          }
          await Messenger.showError(MessengerConstants.errorMessage)
        }
      }
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
  @import '~vue-select/dist/vue-select.css'
</style>
