<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
  -  geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

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
            <h4>Kazanım Listesi</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-offset-2 col-md-4 col-xs-12">
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('branch')}"
                  >
                    <!--                    <label>Ders/Alan Seçiniz</label>-->
                    <v-select
                      v-model="branch"
                      v-validate="'required'"
                      :options="branches"
                      :reduce="branch => branch.id"
                      label="name"
                      name="branch"
                      placeholder="Alan/Ders Seçiniz"
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
                </div>
                <div class="col-md-4">
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('searchedContent')}"
                  >
                    <input
                      v-model="searchedContent"
                      v-validate="'required|min:3'"
                      name="searchedContent"
                      class="form-control"
                      type="text"
                      placeholder="Aranacak içerik"
                    >
                    <span
                      v-if="errors.has('searchedContent')"
                      class="help-block"
                    >{{ errors.first('searchedContent') }}</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <button
                    class="btn btn-primary"
                    @click="searchLOs"
                  >
                    Ara
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div
          v-for="los in loGroup"
          class="row"
        >
          <div
            v-for="l in los"
            :key="l.id"
            class="col-md-4"
          >
            <div class="box box-primary">
              <div class="box-header with-border">
                <h4>{{ l.branch_name }}</h4>
              </div>
              <div class="box-body">
                <div class="row col-md-12">
                  <ul class="nav nav-stacked">
                    <li>Sınıf Seviyesi: {{ l.class_level }}</li>
                    <li>Kodu: {{ l.code }}</li>
                    <li>İçerik: {{ l.content }}</li>
                    <li />
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import LearningOutcomesService from '../../services/LearningOutcomesService'
import Messenger from '../../helpers/messenger'
import vSelect from 'vue-select'
import BranchService from '../../services/BranchService'
import chunk from 'lodash/chunk'

export default {
  name: 'LearningOutcomeList',
  components: { vSelect },
  data () {
    return {
      branch: '',
      branches: [],
      searchedContent: '',
      // learningOutComes: []
      loGroup: [],
      colors: ['bg-yellow', 'bg-green', 'bg-yellow', 'bg-red', 'bg-aqua', 'bg-purple', 'bg-blue', 'bg-navy', 'bg-teal', 'bg-gray', 'bg-olive', 'bg-orange']
    }
  },
  beforeRouteEnter (to, from, next) {
    Promise.all([BranchService.getBranches(), LearningOutcomesService.getLastSavedLOs(18)])
      .then(([branches, los]) => {
        next(vm => {
          branches.splice(0, 0, { id: 0, name: 'Hepsi', code: 'ALL' })
          vm.branches = branches
          vm.loGroup = chunk(los, 3)
        })
      })
  },
  methods: {
    searchLOs () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            LearningOutcomesService.findByCodeOrContentWithPaging({ searched_content: this.searchedContent })
              .then(value => { this.loGroup = chunk(value, 3) })
              .catch(reason => Messenger.showError(reason.message))
          }
        })
    }
  }
}
</script>

<style>
  @import '~vue-select/dist/vue-select.css';
</style>
