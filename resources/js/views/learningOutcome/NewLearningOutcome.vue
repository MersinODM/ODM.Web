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
      <h4>Yeni Kazanım Kaydı</h4>
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
                    <div class="form-group">
                      <label>Ders/Alan Seçimi</label>
                      <v-select
                        ref="branchRef"
                        v-model="selectedBranch"
                        v-validate="'required'"
                        :options="branches"
                        :class="{'is-invalid': errors.has('branch')}"
                        label="name"
                        name="branch"
                        placeholder="Alan/Ders seçimini yapınız"
                        @input="setClassLevels"
                      >
                        <div slot="no-options">
                          Burada bişey bulamadık
                        </div>
                      </v-select>
                      <span
                        v-if="errors.has('branch')"
                        class="error invalid-feedback"
                      >{{ errors.first('branch') }}</span>
                      <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                      <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                    </div>
                    <div class="form-group has-feedback">
                      <label>Sınıf Seviyesi Seçimi</label>
                      <v-select
                        ref="classLevelRef"
                        v-model="selectedClassLevel"
                        v-validate="'required'"
                        :options="classLevels"
                        :class="{'is-invalid': errors.has('selectedClassLevel')}"
                        name="selectedClassLevel"
                        placeholder="Sınıf seviyesini seçiniz"
                      >
                        <div slot="no-options">
                          Burada bişey bulamadık
                        </div>
                      </v-select>
                      <span
                        v-if="errors.has('selectedClassLevel')"
                        class="error invalid-feedback"
                      >{{ errors.first('selectedClassLevel') }}</span>
                      <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                      <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                    </div>
                    <div class="form-group">
                      <label>Kazanım Kodu</label>
                      <div class="input-group mb-3">
                        <input
                          v-model="code"
                          v-validate="'required|min:3'"
                          name="code"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': errors.has('code')}"
                          placeholder="Kazanım kodunu giriniz"
                        >
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="mdi mdi-barcode form-control-feedback" />
                          </div>
                        </div>
                        <span
                          v-if="errors.has('code')"
                          class="error invalid-feedback"
                        >{{ errors.first('code') }}</span>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label>Kazanım</label>
                      <textarea
                        v-model="content"
                        v-validate="'required|min:3'"
                        name="content"
                        class="form-control"
                        :class="{'is-invalid': errors.has('content')}"
                        rows="2"
                        style="max-width: 100%; min-width: 100%; min-height: 50px"
                        placeholder="Kazanım içeriğini giriniz"
                      />
                      <span
                        v-if="errors.has('content')"
                        class="error invalid-feedback"
                      >{{ errors.first('content') }}</span>
                    </div>
                    <div class="form-group mb-3">
                      <label>Açıklama</label>
                      <textarea
                        v-model="description"
                        class="form-control"
                        style="max-width: 100%; min-width: 100%; min-height: 50px"
                        placeholder="İsteğe bağlı"
                      />
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <button
                          :class="{ disabled : errors.any() || isSending }"
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
import LearningOutcomesService from '../../services/LearningOutcomesService'
import Messenger from '../../helpers/messenger'
import BranchService from '../../services/BranchService'
import Page from '../../components/Page'

export default {
  name: 'NewLearningOutcome',
  components: { Page, vSelect },
  data () {
    return {
      isSending: false,
      code: '',
      content: '',
      description: '',
      branches: [],
      selectedBranch: '',
      selectedClassLevel: '',
      classLevels: []
    }
  },
  beforeRouteEnter (to, from, next) {
    BranchService.getBranches()
      .then((branches) => {
        next(vm => {
          vm.branches = branches
        })
      })
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            this.isSending = true
            LearningOutcomesService.save({
              branch_id: this.selectedBranch?.id,
              code: this.code,
              class_level: this.selectedClassLevel,
              content: this.content,
              description: this.description
            }).then((res) => {
              this.isSending = false
              Messenger.showSuccess(res.message)
              this.clear()
            })
          }
        })
    },
    setClassLevels () {
      this.classLevels = this.selectedBranch
          ?.class_levels
      ?.split(',')
      ?.map(Number)
    },
    clear () {
      this.$refs.branchRef.clearSelection()
      this.$refs.classLevelRef.clearSelection()
      this.selectedClassLevel = ''
      this.selectedBranch = this.code = this.content = this.description = ''
    }
  }
}
</script>

<style>
  /*.validateVueSelect .vs__border {*/
  /*  color: red;*/
  /*}*/
</style>
