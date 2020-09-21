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
      <h4 class="mb-0">
        Kazanım Listesi
      </h4>
    </template>
    <template v-slot:content>
      <div class="col-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group has-feedback">
                      <v-select
                        v-model="branch"
                        v-validate="'required'"
                        :options="branches"
                        :reduce="branch => branch.id"
                        :class="{'is-invalid': errors.has('branch')}"
                        label="name"
                        name="branch"
                        placeholder="Alan/Ders seçebilirsiniz"
                      >
                        <div slot="no-options">
                          Burada bişey bulamadık :-(
                        </div>
                      </v-select>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group has-feedback">
                      <v-select
                        v-model="branch"
                        v-validate="'required'"
                        :options="branches"
                        :reduce="branch => branch.id"
                        :class="{'is-invalid': errors.has('branch')}"
                        label="name"
                        name="branch"
                        placeholder="Sınıf seçebilirsiniz"
                      >
                        <div slot="no-options">
                          Burada bişey bulamadık :-(
                        </div>
                      </v-select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group has-feedback">
                      <v-select
                        v-model="branch"
                        v-validate="'required'"
                        :options="branches"
                        label="name"
                        name="branch"
                        placeholder="Göst. kayıt sayısı"
                      >
                        <div slot="no-options">
                          Burada bişey bulamadık :-(
                        </div>
                      </v-select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group has-feedback">
                      <input
                        v-model="searchedContent"
                        v-validate="'required|min:3'"
                        name="searchedContent"
                        class="form-control"
                        :class="{'is-invalid': errors.has('searchedContent')}"
                        type="text"
                        placeholder="Aranacak içerik"
                      >
                    </div>
                  </div>
                  <div class="col-md-2">
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
        <paginator />
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
import Paginator from '../../components/Paginator'
import { mapActions } from 'vuex'

export default {
  name: 'LearningOutcomeList',
  components: { Page, vSelect, Paginator },
  data: () => ({
    branch: '',
    branches: [],
    searchedContent: '',
    // learningOutComes: []
    loGroup: []
  }),
  beforeRouteEnter (to, from, next) {
    Promise.all([BranchService.getBranches(), LearningOutcomesService.findByCodeOrContentWithPaging({
      per_page: 30,
      page: 1
    })])
      .then(([branches, los]) => {
        next(vm => {
          branches.splice(0, 0, { id: 0, name: 'Hepsi', code: 'ALL' })
          vm.branches = branches
          vm.loGroup = chunk(los.data, 3)
          vm.setTotalPages(los.last_page)
        })
      })
  },
  methods: {
    ...mapActions('learningOutcome', {
      setCurrentPage: 'setCurrentPage',
      setTotalPages: 'setTotalPages',
      setPerPage: 'setPerPage',
      setFrom: 'setFrom',
      setTo: 'setTo'
    }),
    searchLOs () {
      // const loader = this.$loading.show()
      LearningOutcomesService.findByCodeOrContentWithPaging({
        per_page: this.perPage,
        currentPage: this.currentPage,
        branch_id: this.branch_id,
        searched_content: this.searchedContent
      })
        .then(value => { this.loGroup = chunk(value, 3) })
        .catch(reason => Messenger.showError(reason.message))
    }
  }
}
</script>

<style>
  /*@import '~vue-select/dist/vue-select.css';*/
</style>
