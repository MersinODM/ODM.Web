<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>Kullanıcı Bilgileri</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <form
                  action="post"
                  @submit.prevent
                >
                  <div class="form-group has-feedback">
                    <label>Ad Soyad</label>
                    <input
                      v-model="user.full_name"
                      type="text"
                      class="form-control"
                      placeholder="Ad Soyad Giriniz"
                    >
                    <span class="glyphicon glyphicon-user form-control-feedback" />
                  </div>
                  <div class="form-group has-feedback">
                    <label>E-Posta</label>
                    <input
                      v-model="user.email"
                      class="form-control"
                      type="email"
                      placeholder="E-Posta adresi"
                    >
                    <span class="glyphicon glyphicon-envelope form-control-feedback" />
                  </div>
                  <div class="form-group has-feedback">
                    <label>Telefon</label>
                    <input
                      v-model="user.phone"
                      class="form-control"
                      placeholder="Kullanıcı Cep telefonu No"
                    >
                    <span class="glyphicon glyphicon-phone form-control-feedback" />
                  </div>
                </form>
              </div>
              <div class="col-md-6">
                <form
                  @submit.prevent
                >
                  <div class="form-group has-feedback">
                    <label>Kurum Seçimi</label>
                    <v-select
                      v-model="selectedInst"
                      :value="selectedInst.id"
                      :options="institutions"
                      label="name"
                      placeholder="Kurum adını en az 3 harf girin"
                      @search="searchInstitutions"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Branş/Ders Seçimi</label>
                    <v-select
                      v-model="selectedBranch"
                      :options="branches"
                      :value="selectedBranch.id"
                      label="name"
                      placeholder="Alan/Ders seçiniz"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Role Seçimi</label>
                    <v-select
                      v-model="selectedRole"
                      :options="roles"
                      :value="selectedRole"
                      :reduce="role => role.name"
                      label="title"
                      placeholder="Rol seçiniz"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="row">
                      <div class="col-md-offset-4 col-xs-offset-3 btn-group">
                        <button
                          type="button"
                          class="btn btn-danger"
                          @click="deleteUser"
                        >
                          Sil/Pasifleştir
                        </button>
                        <button
                          type="button"
                          class="btn btn-warning"
                          @click="resendForgetPassword"
                        >
                          Şifre Yenile
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-4 col-xs-12">
                <button
                  class="btn btn-info btn-large btn-block"
                  @click="save"
                >
                  Kaydet
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import BranchService from '../../services/BranchService'
import InstitutionService from '../../services/InstitutionService'
import UserService from '../../services/UserService'
import vSelect from 'vue-select'
import Messenger from '../../helpers/messenger'
import RoleService from '../../services/RoleService'
import debounce from 'lodash/debounce'
import AuthService from '../../services/AuthService'
import { MessengerConstants } from '../../helpers/constants'

export default {
  name: 'User',
  components: { vSelect },
  // props: ['selectedBranch', 'selectedInst'],
  data () {
    return {
      user: {},
      branches: [],
      selectedBranch: { },
      branchId: null,
      institutions: [],
      selectedInst: { },
      instId: null,
      selectedRole: '',
      roles: []
    }
  },
  beforeRouteEnter  (to, from, next) {
    Promise.all([
      BranchService.getBranches(),
      UserService.findById(to.params.id),
      RoleService.getRoles()
    ]).then(([branches, user, roles]) => {
      next(vm => {
        vm.user = user
        vm.branches = branches
        vm.selectedBranch = user.branch
        vm.selectedInst = user.institution
        vm.roles = roles
        vm.selectedRole = user.role
      })
    })
  },
  beforeRouteUpdate (to, from, next) {
    Promise.all([
      BranchService.getBranches(),
      UserService.findById(to.params.id),
      RoleService.getRoles()
    ]).then(([branches, user, roles]) => {
      next(vm => {
        vm.user = user
        vm.branches = branches
        vm.selectedBranch = user.branch
        vm.selectedInst = user.institution
        vm.roles = roles
        vm.selectedRole = user.role
      })
    })
  },
  methods: {
    searchInstitutions: debounce(function (search, loading) {
      if (search) {
        loading(true)
        InstitutionService.findByName(search)
                          .then(data => {
                            this.institutions = data
                            loading(false)
                          })
                          .catch(err => {
                            Messenger.showError(err)
                            loading(false)
                          })
      }
    }, 1000),
    resendForgetPassword () {
      // let data = { email: this.email, recaptcha: this.captchaToken }
      let data = { email: this.user.email }
      Messenger.showPrompt('Kullanıcıya şifre yenileme e-postası göndermek istediğinize emin misiniz?',
        {
          cancel: 'İptal',
          ok: {
            text: 'Evet',
            value: true
          }
        }).then(value => {
        if (value) {
          AuthService.forgetPassword(data)
                       .then(value => {
                         Messenger.showInfo(value.message, () => {
                           this.$router.push({ name: 'users' })
                         })
                       })
                       .catch(() => {
                         Messenger.showError(MessengerConstants.errorMessage)
                       })
        }
      })
    },
    deleteUser () {
      Messenger.showPrompt('Kullanıcıyı pasifleştirmek istediğinize emin misiniz?',
        {
          cancel: 'İptal',
          ok: {
            text: 'Evet',
            value: true
          }
        }).then(value => {
        if (value) {
          UserService.delete(this.$route.params.id)
                  .then(res => { Messenger.showSuccess(res) })
                  .catch(err => { Messenger.showError(err) })
        }
      })
    },
    save () {
      Messenger.showPrompt('Kullanıcıyı pasifleştirmek istediğinize emin misiniz?',
        {
          cancel: 'İptal',
          ok: {
            text: 'Evet',
            value: true
          }
        }).then(value => {
        if (value) {
          let data = {
            branch_id: this.selectedBranch.id,
            inst_id: this.selectedInst.id,
            full_name: this.user.full_name,
            phone: this.user.phone,
            email: this.user.email,
            role: this.selectedRole
          }
          UserService.update(this.user.id, data)
                     .then(() => Messenger.showSuccess('Kayıt başarılı'))
                     .catch(() => Messenger.showError('Kayıt işlemi başarısız!'))
        }
      })
    }
  }
}
</script>

<style lang="sass">
  @import '~vue-select/dist/vue-select.css'
</style>
