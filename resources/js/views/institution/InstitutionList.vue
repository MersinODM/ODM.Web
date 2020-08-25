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
      <h4><span class="mdi mdi-bank" /> Okul/Kurum Listesi</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="dataTables_wrapper dt-bootstrap4">
                <table
                  id="instList"
                  style="width:100%"
                  class="table table-bordered table-hover dataTable dtr-inline"
                  role="grid"
                >
                  <thead>
                    <tr>
                      <th>Kurum Kodu</th>
                      <th>Genel Müdürlük</th>
                      <th>Okul/Kurum Adı</th>
                      <th>Telefon</th>
                      <th>Öğretmen Sayısı</th>
                      <th>Soru Sayısı</th>
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
import Constants from '../../helpers/constants'
import tr from '../../helpers/dataTablesTurkish'
import Page from '../../components/Page'

export default {
  name: 'InstitutionList',
  components: { Page },
  data: () => ({
    instList: []
  }),
  mounted () {
    const vm = this
    const table = $('#instList')
      .DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
          url: `${vm.$getBasePath()}/api/institutions/list`,
          dataType: 'json',
          type: 'POST',
          beforeSend (xhr) {
            Auth.check()
            const token = localStorage.getItem(Constants.ACCESS_TOKEN)
            xhr.setRequestHeader('Authorization',
              `Bearer ${token}`)
          }
          // error: function (jqXHR, textStatus, errorThrown) {
          //   console.log(errorThrown)
          // }
        },
        language: tr,
        columns: [
          {
            data: 'id',
            name: 'i.id',
            width: '10%'
          },
          {
            data: 'unit_name',
            name: 'u.name',
            searchable: true
          },
          {
            data: 'name',
            name: 'i.name',
            searchable: true
          },
          {
            data: 'phone',
            name: 'i.phone',
            searchable: true,
            orderable: false
          },
          {
            data: 'teacher_count',
            name: 'teacher_count',
            searchable: false
          },
          {
            data: 'question_count',
            name: 'question_count',
            searchable: false
          },
          {
            data: '',
            className: 'text-center',
            width: '15%',
            render (data, type, row, meta) {
              return '<div class="btn-group">' +
                '<button class="btn btn-xs btn-info">Göster</button>' +
                '<button class="btn btn-xs btn-warning">Düzenle</button>' +
                '</div>'
            },
            searchable: false,
            orderable: false
          }
        ],
        retrieve: true,
        searching: true,
        paging: true
      })

    table.on('click', '.btn-info', (e) => {
      // const data = table.row($(e.toElement).parents('tr')[0]).data()
      vm.$router.push({ name: 'underConstruction' })
    })

    table.on('click', '.btn-warning', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      vm.$router.push({ name: 'editInst', params: { instId: data.id } })
    })
  }
}
</script>

<style lang="sass">
  /*@import '~datatables.net-bs4/css/dataTables.bootstrap4.min.css'*/
  /*@import '~datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'*/
</style>
