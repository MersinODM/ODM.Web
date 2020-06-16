<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <page>
    <template v-slot:header>
      <h4>Yeni Branş</h4>
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
                      <label>Branş/Ders Adı</label>
                      <input
                        v-model="branchName"
                        v-validate="'required|min:3'"
                        name="branchName"
                        type="text"
                        class="form-control"
                        :class="{'is-invalid': errors.has('branchName')}"
                        placeholder="Branş/Ders adı giriniz"
                      >
                      <span
                        v-if="errors.has('branchName')"
                        class="error invalid-feedback"
                      >{{ errors.first('branchName') }}</span>
                    </div>
                    <div class="form-group has-feedback">
                      <label>Kod (İsteğe Bağlı)</label>
                      <input
                        v-model="code"
                        class="form-control"
                        type="text"
                        placeholder="Branş Kodu (İsteğe Bağlı) giriniz"
                      >
                    </div>
                    <div class="row justify-content-md-center">
                      <!--<div class="col-xs-8">-->
                      <!--<p-check v-model="isChecked" class="p-icon p-smooth" color="primary">-->
                      <!--<i slot="extra" class="icon fa fa-check"></i>-->
                      <!--fa-check-->
                      <!--</p-check>-->
                      <!--</div>-->
                      <!-- /.col -->
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
import BranchService from '../../services/BranchService'
import Messenger from '../../helpers/messenger'
import Page from '../../components/Page'

export default {
  name: 'NewBranch',
  components: { Page },
  data () {
    return {
      branchName: '',
      code: ''
    }
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            BranchService.save({ name: this.branchName, code: this.code }, (resp) => {
              Messenger.showSuccess(resp.message)
            })
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
