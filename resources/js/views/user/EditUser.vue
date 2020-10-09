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
  <page>
    <template v-slot:header>
      <div class="row">
        <div class="col-md-9">
          <h4>Bilgi Güncelleme</h4>
        </div>
        <div class="col-md-3">
          <button
            type="button"
            class="btn btn-warning btn-block"
            @click="resendForgetPassword"
          >
            Şifremi Yenile
          </button>
        </div>
      </div>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form @submit.prevent>
                    <div class="form-group has-feedback">
                      <label>Ad Soyad</label>
                      <input
                        v-model="user.full_name"
                        type="text"
                        class="form-control"
                        placeholder="Ad Soyad Giriniz"
                      >
                    </div>
                    <div class="form-group has-feedback">
                      <label>E-Posta</label>
                      <input
                        v-model="user.email"
                        class="form-control"
                        type="email"
                        placeholder="E-Posta adresi"
                      >
                    </div>
                    <div class="form-group has-feedback">
                      <label>Telefon</label>
                      <input
                        v-model="user.phone"
                        class="form-control"
                        placeholder="Kullanıcı Cep telefonu No"
                      >
                    </div>
                    <div class="form-group has-feedback">
                      <label>Kurum Seçimi</label>
                      <v-select
                        v-model="selectedInst"
                        :value="selectedInst.id"
                        :options="institutions"
                        append-to-body
                        :calculate-position="withPopper"
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
                        append-to-body
                        :calculate-position="withPopper"
                        label="name"
                        placeholder="Alan/Ders seçiniz"
                      >
                        <div slot="no-options">
                          Burada bişey bulamadık :-(
                        </div>
                      </v-select>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row justify-content-md-center">
                <div class="col-md-4">
                  <button
                    class="btn btn-primary btn-large btn-block"
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
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import BranchService from '../../services/BranchService'
import UserService from '../../services/UserService'
import debounce from 'lodash/debounce'
import InstitutionService from '../../services/InstitutionService'
import Messenger from '../../helpers/messenger'
import AuthService from '../../services/AuthService'
import { MessengerConstants } from '../../helpers/constants'
import vSelect from 'vue-select/dist/vue-select'
import { calculateWithPopper } from '../../helpers/utils'

export default {
  name: 'EditUser',
  components: { Page, vSelect },
  data: () => ({
    user: {},
    branches: [],
    selectedBranch: { },
    branchId: null,
    institutions: [],
    selectedInst: { },
    instId: null
  }),
  async beforeRouteEnter  (to, from, next) {
    const [branches, user] = await Promise.all([
      BranchService.getBranches(),
      UserService.findById(AuthService.getUserId())
    ])
    next(vm => {
      vm.user = user
      vm.branches = branches
      vm.selectedBranch = user.branch
      vm.selectedInst = user.institution
      vm.selectedRole = user.role
    })
  },
  methods: {
    searchInstitutions: debounce(async function (search, loading) {
      if (search) {
        loading(true)
        try {
          this.institutions = await InstitutionService.findByName(search)
          loading(false)
        } catch (err) {
          await Messenger.showError(err)
          loading(false)
        }
      }
    }, 1000),
    async resendForgetPassword () {
      const data = { email: this.user.email }
      const promptRes = await Messenger.showPrompt('Şifre yenileme e-postası ile şifrenizi güncellemek istediğinizden emin misiniz?')
      if (promptRes.isConfirmed) {
        const loader = this.$loading.show()
        try {
          const response = await AuthService.forgetPassword(data)
          loader.hide()
          await Messenger.showInfo(response.message)
        } catch (error) {
          loader.hide()
          await Messenger.showError(MessengerConstants.errorMessage)
        }
      }
    },
    async save () {
      const promptRes = await Messenger.showPrompt('Bilgilerinizi güncellemek istediğinize emin misiniz?')
      if (promptRes.isConfirmed) {
        const data = {
          branch_id: this.selectedBranch.id,
          inst_id: this.selectedInst.id,
          full_name: this.user.full_name,
          phone: this.user.phone,
          email: this.user.email,
          role: this.selectedRole
        }
        try {
          const response = await UserService.update(this.user.id, data)
          await Messenger.showSuccess(response.message)
        } catch (error) { await Messenger.showError('Güncelleme işlemi başarısız!') }
      }
    },
    withPopper: calculateWithPopper
  }
}
</script>

<style>
</style>
