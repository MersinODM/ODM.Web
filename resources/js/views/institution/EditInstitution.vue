<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>Okul/Kurum Düzenleme</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <form
                  @submit.prevent
                >
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('unit')}"
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
                      placeholder="Birim seçiniz"
                    >
                      <div slot="no-options">
                        Burada birşey bulamadık
                      </div>
                    </v-select>
                    <span
                      v-if="errors.has('unit')"
                      class="help-block"
                    >{{ errors.first('unit') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('instName')}"
                  >
                    <label>Okul/Kurum Adı</label>
                    <input
                      v-model="name"
                      v-validate="'required'"
                      name="instName"
                      class="form-control"
                      type="text"
                      placeholder="Okul Adı"
                    >
                    <span class="mdi mdi-school form-control-feedback" />
                    <span
                      v-if="errors.has('instName')"
                      class="help-block"
                    >{{ errors.first('instName') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('phone')}"
                  >
                    <label>Telefon</label>
                    <input
                      v-model="phone"
                      v-mask="'### ### ####'"
                      v-validate="{ required: true, regex:/[0-9]{1,3}[ ][0-9]{1,3}[ ][0-9]{4}$/ }"
                      name="phone"
                      class="form-control"
                      type="text"
                      placeholder="Tel. num. başında 0(sıfır) olmadan giriniz"
                    >
                    <span class="mdi mdi-phone form-control-feedback" />
                    <span
                      v-if="errors.has('phone')"
                      class="help-block"
                    >{{ errors.first('phone') }}</span>
                  </div>
                  <div class="row">
                    <!--<div class="col-xs-8">-->
                    <!--<p-check v-model="isChecked" class="p-icon p-smooth" color="primary">-->
                    <!--<i slot="extra" class="icon fa fa-check"></i>-->
                    <!--fa-check-->
                    <!--</p-check>-->
                    <!--</div>-->
                    <!-- /.col -->
                    <div class="col-xs-offset-4 col-xs-4">
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
  </section>
</template>

<script>
import vSelect from 'vue-select'
import InstitutionService from '../../services/InstitutionService'
import UnitService from '../../services/UnitService'
import Messenger from '../../helpers/messenger'
import {MessengerConstants, ResponseCodes} from '../../helpers/constants'

export default {
  name: 'EditInstitution',
  components: { vSelect },
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
                  Messenger.showInfo(value.message, () => {
                    this.$router.go(-1)
                  })
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
