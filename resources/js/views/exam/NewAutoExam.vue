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
    <template slot="header">
      <h4>Otomatik Sınav Oluşturma</h4>
    </template>
    <template slot="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label>Sınav Adı/Başlığı</label>
                    <input
                      v-model="title"
                      v-validate="'required'"
                      name="title"
                      class="form-control"
                      :class="{'is-invalid': errors.has('title')}"
                      type="text"
                      placeholder="Sınav adı/Başlığı"
                    >
                    <span
                      v-if="errors.has('title')"
                      class="error invalid-feedback"
                    >{{ errors.first('title') }}</span>
                  </div>
                  <div class="form-group mb-3">
                    <label>
                      Sınavın Genel Amacı
                    </label>
                    <v-select
                      v-model="selectedPurpose"
                      v-validate="'required'"
                      :options="purposes"
                      :reduce="b => b.id"
                      label="purpose"
                      :class="{'is-invalid': errors.has('purpose')}"
                      name="purpose"
                      placeholder="Ders seçimi yapınız"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                    <span
                      v-if="errors.has('purpose')"
                      class="error invalid-feedback"
                    >{{ errors.first('purpose') }}</span>
                  </div>
                  <div class="form-group mb-3">
                    <label>Sınıf Seviyesi Seçimi</label>
                    <v-select
                      ref="classLevelDD"
                      v-model="selectedClassLevel"
                      v-validate="'required'"
                      :options="classLevels"
                      name="selectedClassLevel"
                      :class="{'is-invalid': errors.has('selectedClassLevel')}"
                      placeholder="Sınıf seviyesini seçiniz"
                      @input="onClassLevelChanged"
                    />
                    <span
                      v-if="errors.has('selectedClassLevel')"
                      class="error invalid-feedback"
                    >{{ errors.first('selectedClassLevel') }}</span>
                  </div>
                  <div
                    v-if="this.selectedClassLevel"
                    class="row mb-3"
                  >
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                          <label>Ders ve soru sayısı seçimi</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 justify-content-center">
                          <div class="form-group">
                            <v-select
                              ref="branchesRef"
                              v-model="selectedBranch"
                              v-validate="'required'"
                              :options="branches"
                              label="name"
                              :class="{'is-invalid': errors.has('branch')}"
                              name="branch"
                              placeholder="Ders seçimi yapınız"
                            >
                              <div slot="no-options">
                                Burada bişey bulamadık :-(
                              </div>
                            </v-select>
                            <span
                              v-if="errors.has('branch')"
                              class="error invalid-feedback"
                            >{{ errors.first('branch') }}</span>
                          </div>
                        </div>
                        <div class="col-md-4 justify-content-center">
                          <div class="form-group">
                            <v-select
                              v-model="selectedQuestionCount"
                              v-validate="'required'"
                              :options="questionCounts"
                              :class="{'is-invalid': errors.has('questionCount')}"
                              name="questionCount"
                              placeholder="Soru sayısı giriniz/seçiniz"
                            >
                              <div slot="no-options">
                                Burada bişey bulamadık :-(
                              </div>
                            </v-select>
                            <span
                              v-if="errors.has('questionCount')"
                              class="error invalid-feedback"
                            >{{ errors.first('questionCount') }}</span>
                          </div>
                        </div>
                        <div class="col-md-2 justify-content-center">
                          <button
                            type="button"
                            class="btn btn-primary btn-block btn-sm"
                            @click="addLesson"
                          >
                            Ekle
                          </button>
                        </div>
                      </div>
                      <div
                        v-if="hasLessons"
                        class="row mb-3"
                      >
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-body">
                              <ul class="nav flex-column">
                                <li
                                  v-for="lesson in lessons"
                                  :key="lesson.id"
                                  class="nav-item"
                                >
                                  {{ lesson.name }} - {{ lesson.question_count }}
                                  <button
                                    class="btn btn-danger btn-xs float-right"
                                    @click="removeLesson(lesson.id)"
                                  >
                                    Sil
                                  </button>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Açıklamalar</label>
                    <textarea
                      v-model="description"
                      v-validate="'required|min:3|max:1000'"
                      name="description"
                      class="form-control"
                      rows="2"
                      style="max-width: 100%; min-width: 100%; min-height: 50px"
                      placeholder="Açıklama girebilirsiniz"
                    />
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
import Page from '../../components/Page'
import vSelect from 'vue-select'
import BranchService from '../../services/BranchService'
import { ExamPurposeService } from '../../services/ExamServices'

export default {
  name: 'NewAutoExam',
  components: { Page, vSelect },
  data: () => ({
    title: '',
    description: '',
    selectedPurpose: '',
    purposes: [],
    selectedClassLevel: '',
    classLevels: [...Array(9).keys()].map(i => i + 4),
    selectedQuestionCount: 0,
    questionCounts: [...Array(50).keys()].map(i => i + 1),
    lessons: [],
    selectedBranch: '',
    branches: [],
    tempBranches: [],
    tempBranchesClassLevels: []
  }),
  computed: {
    hasLessons () {
      return this.lessons !== null && this.lessons.length > 0
    }
  },
  beforeRouteEnter (to, from, next) {
    Promise.all([
      BranchService.getBranches(),
      ExamPurposeService.getPurposes()])
      .then(([branches, purposes]) => {
        next(vm => {
          vm.branches = branches
          vm.purposes = purposes
          // vm.classLevels.splice(0, 3) // Sınıf seviyesi 4-12 arası olmalı
          vm.branches.sort((a, b) => a.name.localeCompare(b.name))
          vm.tempBranchesClassLevels = vm.branches
        })
      })
      .catch(reason => console.log(reason))
  },
  methods: {
    addLesson () {
      if (this.selectedBranch && this.selectedQuestionCount) {
        this.lessons.push({ /**/
          id: this.selectedBranch.id,
          name: this.selectedBranch.name,
          question_count: this.selectedQuestionCount
        })
        this.tempBranches.push(this.branches.filter((value) => value.id === this.selectedBranch.id)[0])
        this.branches = this.branches.filter((value) => value.id !== this.selectedBranch.id)
        this.$refs.branchesRef.clearSelection()
      }
    },
    removeLesson (id) {
      this.branches.push(...this.tempBranches.filter((value) => value.id === id))
      this.lessons.splice(this.lessons.findIndex(value => value.id === id), 1)
      this.branches.sort((a, b) => a.name.localeCompare(b.name))
    },
    onClassLevelChanged () {
      this.branches = this.tempBranchesClassLevels
        .filter(value => {
          return value.class_levels.split(',')
            .map(Number)
            .includes(this.selectedClassLevel)
        })
      this.$refs.branchesRef.clearSelection()
    }
  }
}
</script>

<style scoped>

</style>
