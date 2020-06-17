<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <page>
    <template v-slot:header>
      <h4>Kazanım Listesi</h4>
    </template>
    <template v-slot:content>
      <div class="col-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group has-feedback">
                      <!--                    <label>Ders/Alan Seçiniz</label>-->
                      <v-select
                        v-model="branch"
                        v-validate="'required'"
                        :options="branches"
                        :reduce="branch => branch.id"
                        :class="{'is-invalid': errors.has('branch')}"
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
                        class="error invalid-feedback"
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
                        class="error invalid-feedback"
                      >{{ errors.first('searchedContent') }}</span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button
                      class="btn btn-block btn-primary"
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
        <div class="row">
          <div class="col-12">
            <div
              v-for="los in loGroup"
              class="row"
            >
              <div
                v-for="l in los"
                :key="l.id"
                class="col-md-4"
              >
                <div class="card card-warning">
                  <div class="card-header with-border">
                    <h4>{{ l.branch_name }}</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <span class="text-bold">Sınıf Seviyesi:</span> {{ l.class_level }}. Sınıf Düzeyi
                      </li>
                      <li class="nav-item">
                        <span class="text-bold">Kodu:</span> {{ l.code }}
                      </li>
                      <li class="nav-item">
                        <span class="text-bold">
                          İçerik:
                        </span> {{ l.content }}
                      </li>
                      <li />
                    </ul>
                  </div>
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
import LearningOutcomesService from '../../services/LearningOutcomesService'
import Messenger from '../../helpers/messenger'
import vSelect from 'vue-select'
import BranchService from '../../services/BranchService'
import chunk from 'lodash/chunk'
import Page from '../../components/Page'

export default {
  name: 'LearningOutcomeList',
  components: { Page, vSelect },
  data: () => ({
    branch: '',
    branches: [],
    searchedContent: '',
    // learningOutComes: []
    loGroup: []
  }),
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
            // const loader = this.$loading.show()
            LearningOutcomesService.findByCodeOrContentWithPaging({ searched_content: this.searchedContent })
              .then(value => { this.loGroup = chunk(value, 3) })
              .catch(reason => Messenger.showError(reason.message))
              // .finally(() => loader.hide())
          }
        })
    }
  }
}
</script>

<style>
  /*@import '~vue-select/dist/vue-select.css';*/
</style>
