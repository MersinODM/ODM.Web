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
      <h4>{{ exam.code }} Kodlu Sınav Bilgileri</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Kod</label>
                        <h6>{{ exam.code }}</h6>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Başlık</label>
                        <h6>{{ exam.title }}</h6>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Amaç</label>
                        <h6>{{ exam.purpose }}</h6>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Durum</label>
                        <h6>{{ exam.status }}</h6>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Sınıf Seviyesi</label>
                        <h6>{{ exam.class_level }}. Sınıf</h6>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Oluşturan</label>
                        <h6>{{ exam.creator }}</h6>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Planlanan Tarih</label>
                        <h6>{{ exam.planned_date | dateTime }}</h6>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Uygulama Tarihi</label>
                        <h6>{{ exam.date_of_occurrence | dateTime }}</h6>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Oluşturma Tarihi</label>
                        <h6>{{ exam.created_at | trDate }}</h6>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Açıklamalar</label>
                        <h6>{{ exam.description }}</h6>
                      </div>
                    </div>
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
import ExamService from '../../services/ExamService'

export default {
  name: 'ShowExam',
  components: { Page },
  data: () => ({
    exam: ''
  }),
  async beforeRouteEnter (to, from, next) {
    const exam = await ExamService.getExam(to.params.examId)
    next(vm => {
      vm.exam = exam
    })
  },
  methods: {}
}
</script>

<style scoped>

</style>
