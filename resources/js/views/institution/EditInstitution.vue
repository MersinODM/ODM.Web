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
      <h4>Okul/Kurum Düzenleme</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
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
                        name="unit"
                        :class="{'is-invalid': errors.has('unit')}"
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
                    <div
                      class="form-group has-feedback"
                    >
                      <label>Okul/Kurum Adı</label>
                      <input
                        v-model="name"
                        v-validate="'required'"
                        name="instName"
                        class="form-control"
                        :class="{'is-invalid': errors.has('instName')}"
                        type="text"
                        placeholder="Okul Adı"
                      >
                      <span
                        v-if="errors.has('instName')"
                        class="error invalid-feedback"
                      >{{ errors.first('instName') }}</span>
                    </div>
                    <div
                      class="form-group"
                    >
                      <label>Telefon</label>
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
                          class="btn btn-primary btn-block"
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
import { MessengerConstants, ResponseCodes } from '../../helpers/constants'
import Page from '../../components/Page'

export default {
  name: 'EditInstitution',
  components: { Page, vSelect },
  data: () => ({
    instId: '',
    name: '',
    phone: '',
    selectedUnit: '',
    units: []
  }),
  beforeRouteEnter (to, from, next) {
    const instId = to.params.instId
    Promise.all([UnitService.getAllUnits(), InstitutionService.findById(instId)])
      .then(([units, inst]) => {
        next(vm => {
          vm.units = units
          vm.name = inst.name
          vm.phone = inst.phone
          vm.selectedUnit = inst.unit_id
        })
      })
      .catch(err => Messenger.showError(`Düzenleme sayfasını açamıyoruz. Lütfen yöneticinize başvurunuz.${err.message}`))
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            const inst = {
              unit_id: this.selectedUnit,
              name: this.name,
              phone: this.phone
            }
            InstitutionService.update(this.$route.params.instId, inst)
              .then(value => {
                if (value.code === ResponseCodes.CODE_ERROR) {
                  Messenger.showError(value.message)
                  console.log(value.exception)
                } else {
                  Messenger.showInfo(value.message)
                    .then(() => { this.$router.go(-1) })
                }
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

<style scoped>

</style>
