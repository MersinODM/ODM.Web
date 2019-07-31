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
                  action="post"
                  @submit.prevent
                >
                  <div class="form-group has-feedback">
                    <label>Kurum Seçimi</label>
                    <v-select
                      :value="selectedInst"
                      :options="institutions"
                      :reduce="inst => inst.id"
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
                      :reduce="branch => branch.id"
                      label="name"
                      placeholder="Alan/Ders adını en az 3 harf girin"
                      @search="searchBranches"
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
                        >
                          Sil/Pasifleştir
                        </button>
                        <button
                          type="button"
                          class="btn btn-warning"
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
              <div class="col-md-3 col-md-offset-5 col-xs-offset-4">
                <button class="btn btn-info btn-large">
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
      instId: null
    }
  },
  beforeRouteEnter  (to, from, next) {
    UserService.findById(to.params.id)
               .then(user => {
                 next(vm => {
                   vm.user = user
                   vm.branches = [user.branch]
                   vm.selectedBranch = user.branch
                   vm.selectedInst = user.institution
                 })
               })
  },
  beforeRouteUpdate (to, from, next) {
    UserService.findById(to.params.id)
               .then(user => {
                 next(vm => {
                   vm.user = user
                   vm.selectedBranch = user.branch
                   vm.selectedInst = user.institution
                 })
               })
  },
  methods: {
    searchBranches (search, loading) {
      BranchService.findByName(search, data => {
        this.branches = data
      })
    },
    searchInstitutions (search, loading) {
      InstitutionService.findByName(search, data => {
        this.institutions = data
      })
    },
    save () {
      let data = {
        branch_id: this.selectedBranch,
        inst_id: this.selectedInst,
        full_name: this.user.full_name,
        phone: this.user.phone,
        email: this.user.email
      }
      UserService.update(this.user.id, data)
                 .then(() => Messenger.showSuccess('Kayıt başarılı'))
                 .catch(() => Messenger.showError('Kayıt işlemi başarısız!'))
    }
  }
}
</script>

<style lang="sass">
  @import '~vue-select/dist/vue-select.css'
</style>
