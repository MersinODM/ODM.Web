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
      <h4>Soru Listesi</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div
                  v-if="checkPermission"
                  class="col-md-3 col-xs-12"
                >
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Ders/Alan Seçimi</label>
                    <v-select
                      v-model="selectedBranch"
                      :options="branches"
                      :reduce="b => b.id"
                      label="name"
                      placeholder="Alan/Ders seçebilirsiniz"
                      @input="onSelectionChanged"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Sınıf Seviyesi Seçimi</label>
                    <v-select
                      ref="classLevelDD"
                      v-model="selectedClassLevel"
                      :options="classLevels"
                      placeholder="Sınıf seviyesini seçebilirsiniz"
                      @input="onSelectionChanged"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Soru Durumu</label>
                    <v-select
                      ref="qStatusDD"
                      v-model="selectedStatus"
                      :options="statuses"
                      :reduce="b => b.statusCode"
                      label="title"
                      placeholder="Sınıf seviyesini seçebilirsiniz"
                      @input="onSelectionChanged"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Tasarım İhtiyacı</label>
                    <v-select
                      ref="qIsDesignReq"
                      v-model="isDesignRequired"
                      :options="designOptions"
                      :reduce="b => b.key"
                      label="value"
                      placeholder="Tasarım durumu seçebilirsiniz"
                      @input="onSelectionChanged"
                    />
                  </div>
                </div>
              </div>
              <div class="dataTables_wrapper dt-bootstrap4">
                <table
                  id="questionList"
                  style="width:100%"
                  class="table row-border table-hover dataTable"
                  role="grid"
                >
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Oluşturucu Id</th>
                      <th>Kazanım Id</th>
                      <th>Ad Soyad</th>
                      <th>Branş/Ders</th>
                      <th>Kazanım Kodu</th>
                      <th>Durum</th>
                      <th>Kayıt Tarihi</th>
                      <th>Aksiyon</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Auth from '../../services/AuthService'
import Constants, { MessengerConstants } from '../../helpers/constants'
import tr from '../../helpers/dataTablesTurkish'
import Messenger from '../../helpers/messenger'
import range from 'lodash/range'
import LearningOutcomesService from '../../services/LearningOutcomesService'
import vSelect from 'vue-select'
import BranchService from '../../services/BranchService'
import UserService from '../../services/UserService'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
import Page from '../../components/Page'

let qTable = null

export default {
  name: 'QuestionTableList',
  components: { Page, vSelect },
  data () {
    return {
      statuses: [
        { statusCode: '', title: 'Hepsi' },
        { statusCode: QuestionStatuses.WAITING_FOR_ACTION, title: 'İşleme alınmamışlar' },
        { statusCode: QuestionStatuses.IN_ELECTION, title: 'Değerlendirme aşamasında' },
        { statusCode: QuestionStatuses.NEED_REVISION, title: 'Revizyon alması gerekenler' },
        { statusCode: QuestionStatuses.NOT_MUST_ASKED, title: 'Sorulamayacak sorular' },
        { statusCode: QuestionStatuses.REVISION_COMPLETED, title: 'Revizyonu tamamlananlar' },
        { statusCode: QuestionStatuses.APPROVED, title: 'Havuza girenler' }
      ],
      selectedStatus: '',

      branches: [],
      selectedBranch: '',

      classLevels: [],
      selectedClassLevel: '',

      designOptions: [
        { key: '', value: 'Belirsiz' },
        { key: true, value: 'İhtiyaç Var' },
        { key: false, value: 'İhtiyaç Yok' }
      ],
      isDesignRequired: '',

      user: ''
    }
  },
  beforeRouteEnter (to, from, next) {
    Promise.all([BranchService.getBranches(), UserService.findById(Auth.getUserId())])
      .then(([branches, user]) => {
        next(vm => {
          vm.user = user
          // Burada kullanıcı sosyal bilgiler öğretmeni ise
          // hem sosyal bilgilere hem de inklap tarihi dersine soru yazabilmeli
          if (!vm.$isInRole('admin') && user.branch.code === 'SB') {
            vm.branches = branches.filter(b => b.code === 'SB' || b.code === 'İTA')
          } else {
            vm.branches = branches
          }
        })
      })
      .catch(() => {
        Messenger.showError(MessengerConstants.errorMessage)
        next(from.path)
      })
  },
  computed: {
    checkPermission () {
      if (this.user) {
        return this.$isInRole('admin') || this.user.branch.code === 'SB'
      }
      return false
    }
  },
  created () {
    // Kullancı eğer yönetici değil ise üzücü olmamak adına
    // Çöp soruları kullanıcı ya da değerlendiriciye göstermiyoruz
    if (!this.$isInRole('admin')) {
      this.statuses = this.statuses.filter(value => value.statusCode !== QuestionStatuses.NOT_MUST_ASKED)
    }
    this.classLevels.push('Hepsi')
    this.classLevels = this.classLevels.concat(range(5, 13))
    // console.log(this.classLevels.length)
  },
  mounted () {
    const vm = this
    const table = $('#questionList')
      .on('preXhr.dt', (e, settings, data) => {
        // Bu event sunucuya datatable üzerinden veri gitmeden önce
        // yeni parametre eklemek için ateşleniyor
        data.question_status = vm.selectedStatus
        data.branch_id = vm.selectedBranch
        data.is_design_required = vm.isDesignRequired
        if (vm.selectedClassLevel !== 'Hepsi') { data.class_level = vm.selectedClassLevel }
      })
      .DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
          url: `${vm.$getBasePath()}/api/questions/list`,
          dataType: 'json',
          type: 'POST',
          beforeSend (xhr) {
            Auth.check()
            const token = localStorage.getItem(Constants.ACCESS_TOKEN)
            xhr.setRequestHeader('Authorization',
              `Bearer ${token}`)
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
            Messenger.showError(MessengerConstants.errorMessage)
          }
        },
        language: tr,
        columns: [
          {
            data: 'id',
            name: 'q.id',
            visible: false
          },
          {
            data: 'creator_id',
            name: 'q.creator_id',
            visible: false
          },
          {
            data: 'lo_id',
            name: 'l.id',
            visible: false
          },
          {
            data: 'full_name',
            name: 'u.full_name',
            searchable: true,
            render (data, type, row, meta) {
              return data || 'Silinmiş Kullanıcı'
            }
          },
          {
            data: 'branch_name',
            name: 'b.name',
            searchable: true
          },
          {
            data: 'code',
            name: 'l.code',
            className: 'text-center',
            render (data, type, row, meta) {
              return `<button class="btn btn-xs btn-default">${data}</button>`
            },
            searchable: true
          },
          {
            data: 'status',
            name: 'q.status',
            className: 'text-center',
            searchable: false,
            render (data, type, row, meta) {
              switch (Number(data)) {
                case QuestionStatuses.WAITING_FOR_ACTION: return '<span class="label label-default">İşleme alınmamış</span>'
                case QuestionStatuses.NOT_MUST_ASKED: return '<span class="label label-danger">Sorulamaz</span>'
                case QuestionStatuses.NEED_REVISION: return '<span class="label label-warning">Revizyon Gerekiyor</span>'
                case QuestionStatuses.IN_ELECTION: return '<span class="label label-info">Değerlendirme Aşamasında</span>'
                case QuestionStatuses.REVISION_COMPLETED: return '<span class="label label-primary">Revizyon Tamamlanmış</span>'
                case QuestionStatuses.APPROVED: return '<span class="label label-success">Havuza Girmiş</span>'
              }
            }
          },
          {
            data: 'created_at',
            name: 'q.created_at',
            className: 'text-center',
            searchable: true
          },
          {
            data: '',
            className: 'text-center',
            width: '15%',
            render (data, type, row, meta) {
              const number = Number(row.status)
              if (number === QuestionStatuses.NEED_REVISION) {
                return '<button class="btn btn-xs btn-warning">Revize Et</button>'
              } else if (vm.$isInRole('admin') && (number === QuestionStatuses.REVISION_COMPLETED || number === QuestionStatuses.WAITING_FOR_ACTION)) {
                return '<button class="btn btn-xs btn-primary">Değerlendirici Ata</button>'
              } else {
                return '<button class="btn btn-xs btn-info">Göster</button>'
              }
            },
            searchable: false,
            orderable: false
          }
        ],
        retrieve: true,
        searching: true,
        paging: true
      })
    qTable = table

    // Tablo içindeki belli bir css sınıfına sahip bir butona basınca çalışacak event
    table.on('click', '.btn-info', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.$router.push({ name: 'showQuestion', params: { questionId: data.id } })
    })

    table.on('click', '.btn-warning', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.$router.push({ name: 'reviseQuestion', params: { questionId: data.id } })
    })

    table.on('click', '.btn-primary', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.$router.push({ name: 'setEvaluators', params: { questionId: data.id } })
    })

    table.on('click', '.btn-default', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.showLearningOutcome(data.lo_id)
    })
  },
  methods: {
    onSelectionChanged () {
      if (qTable) {
        qTable.ajax.reload()
      }
    },
    async showLearningOutcome (loId) {
      try {
        const result = await LearningOutcomesService.findById(loId)
        await Messenger.showInfo(`<b>${result.branch_name}</b>: ${result.code} ${result.content}`)
      } catch (err) { await Messenger.showError(err.message) }
    }
  }
}
</script>

<style lang="sass">
  /*@import '~datatables.net-bs4/css/dataTables.bootstrap4.min.css'*/
  /*@import '~datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'*/
</style>
