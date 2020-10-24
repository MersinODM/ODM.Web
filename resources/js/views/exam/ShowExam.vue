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
                      <div class="callout callout-info">
                        <h6><b>Kod</b></h6>
                        <p>{{ exam.code }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Başlık</b></h6>
                        <p>{{ exam.title }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Amaç</b></h6>
                        <p>{{ exam.purpose }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Durum</b></h6>
                        <p>{{ exam.status }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Sınıf Seviyesi</b></h6>
                        <p>{{ exam.class_level }}. Sınıf</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Oluşturan</b></h6>
                        <p>{{ exam.creator }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Planlanan Tarih / Saat</b></h6>
                        <p>{{ exam.planned_date | dateTime }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Uygulama Tarihi</b></h6>
                        <p>{{ exam.date_of_occurrence | dateTime }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="callout callout-info">
                        <h6><b>Oluşturma Tarihi</b></h6>
                        <p>{{ exam.created_at | trDate }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="callout callout-info">
                        <h6><b>Açıklamalar</b></h6>
                        <p>{{ exam.description }}</p>
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
