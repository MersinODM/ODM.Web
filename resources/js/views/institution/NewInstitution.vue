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

<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
  -  geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <page>
    <template v-slot:header>
      <h4> <span class="mdi mdi-bank-plus" /> Yeni Okul/Kurum Ekleme</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form
                    @submit.prevent
                  >
                    <div
                      class="form-group has-feedback"
                    >
                      <label>Birim/Şube Seçimi</label>
                      <v-select
                        ref="unitRef"
                        v-model="selectedUnit"
                        v-validate="'required'"
                        :options="units"
                        :reduce="selectedUnit => selectedUnit.id"
                        label="name"
                        :class="{'is-invalid': errors.has('unit')}"
                        name="unit"
                        placeholder="Birim seçiniz"
                      >
                        <div slot="no-options">
                          Burada birşey bulamadık
                        </div>
                      </v-select>
                      <span
                        v-if="errors.has('unit')"
                        class="error invalid-feedback"
                      >{{ errors.first('unit') }}</span>
                    </div>
                    <label>Okul/Kurum Kodu</label>
                    <div class="input-group mb-3">
                      <input
                        v-model="instId"
                        v-validate="'required|numeric|min:6|max:8'"
                        name="instId"
                        type="text"
                        class="form-control"
                        :class="{'is-invalid': errors.has('instId')}"
                        placeholder="Okul kodunu giriniz"
                      >
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="mdi mdi-barcode form-control-feedback" />
                        </div>
                      </div>
                      <span
                        v-if="errors.has('instId')"
                        class="error invalid-feedback"
                      >{{ errors.first('instId') }}</span>
                    </div>
                    <label>Okul/Kurum Adı</label>
                    <div class="input-group mb-3">
                      <input
                        v-model="name"
                        v-validate="'required'"
                        name="instName"
                        class="form-control"
                        :class="{'is-invalid': errors.has('instName')}"
                        type="text"
                        placeholder="Okul Adı"
                      >
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="mdi mdi-school form-control-feedback" />
                        </div>
                      </div>
                      <span
                        v-if="errors.has('instName')"
                        class="error invalid-feedback"
                      >{{ errors.first('instName') }}</span>
                    </div>
                    <label>Telefon</label>
                    <div class="input-group mb-3">
                      <input
                        v-model="phone"
                        v-mask="'### ### ####'"
                        v-validate="{ required: true, regex:/[0-9]{1,3}[ ][0-9]{1,3}[ ][0-9]{4}$/ }"
                        name="phone"
                        class="form-control"
                        :class="{'is-invalid': errors.has('phone')}"
                        type="text"
                        placeholder="Tel. num. başında 0(sıfır) olmadan giriniz"
                      >
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="mdi mdi-phone form-control-feedback" />
                        </div>
                      </div>
                      <span
                        v-if="errors.has('phone')"
                        class="error invalid-feedback"
                      >{{ errors.first('phone') }}</span>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="col-md-6">
                        <button
                          :class="{ disabled : errors.any() }"
                          type="submit"
                          class="btn btn-primary btn-block btn-flat"
                          @click="save"
                        >
                          Kaydet
                        </button>
                      </div>
                    </div>
                  </form>
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
import vSelect from 'vue-select'
import InstitutionService from '../../services/InstitutionService'
import UnitService from '../../services/UnitService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import Page from '../../components/Page'

export default {
  name: 'NewInstitution',
  components: { Page, vSelect },
  data () {
    return {
      instId: '',
      name: '',
      phone: '',
      selectedUnit: '',
      units: []
    }
  },
  beforeRouteEnter (to, from, next) {
    UnitService.getAllUnits()
      .then((units) => {
        next(vm => {
          vm.units = units
        })
      })
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            const inst = {
              id: this.instId,
              unit_id: this.selectedUnit,
              name: this.name,
              phone: this.phone.replace(/[^0-9]/gi, '')
            }
            InstitutionService.create(inst)
              .then(value => {
                Messenger.showInfo(value.message)
                  .then(() => { this.$router.push({ name: 'stats' }) })
              })
              .catch(() => {
                Messenger.showError(MessengerConstants.errorMessage)
              })
          }
        })
    }
  }
}
</script>

<style lang="sass">
</style>
