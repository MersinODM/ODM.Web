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
      <h4>Kullanıcı Listesi</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div
                class="dataTables_wrapper dt-bootstrap4"
                :class="{ disabled : isApproving }"
              >
                <table
                  id="userList"
                  style="width:100%"
                  class="table table-bordered table-hover dataTable"
                  role="grid"
                >
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Ad Soyad</th>
                      <th>Telefon</th>
                      <th>Branş/Ders</th>
                      <th>Kurum</th>
                      <th>Onaylayan</th>
                      <th
                        data-type="date"
                        data-format="DD/MM/YYYY"
                      >
                        Kayıt Tarihi
                      </th>
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
import Constants from '../../helpers/constants'
import Auth from '../../services/AuthService'
import UserService from '../../services/UserService'
import Messenger from '../../helpers/messenger'
import tr from '../../helpers/dataTablesTurkish'
import Page from '../../components/Page'

export default {
  name: 'UserList',
  components: { Page },
  data () {
    return {
      isApproving: false,
      userList: []
    }
  },
  mounted () {
    const vm = this
    const table = $('#userList')
      .DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
          url: `${vm.$getBasePath()}/api/users`,
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
            name: 'users.id',
            visible: false
          },
          {
            data: 'full_name',
            name: 'users.full_name',
            searchable: true
          },
          {
            data: 'phone',
            searchable: true
          },
          {
            data: 'branch_name',
            name: 'branches.name',
            searchable: true
          },
          {
            data: 'inst_name',
            name: 'institutions.name',
            searchable: true
          },
          {
            data: 'activator_name',
            name: 'um.full_name',
            searchable: false
          },
          {
            data: 'created_at',
            name: 'users.created_at',
            searchable: true
          },
          {
            data: '',
            className: 'text-center',
            width: '15%',
            render (data, type, row, meta) {
              if (row.activator_name !== null) {
                return '<div class="btn-group  btn-block">' +
                    '<button class="btn btn-xs btn-default">Göster</button>' +
                    '<button class="btn btn-xs btn-danger">Pasif.</button>' +
                    '</div>'
              }
              return '<div class="btn-group btn-block">' +
                  '<button class="btn btn-xs btn-default">Göster</button>' +
                  '<button class="btn btn-xs btn-warning">Onayla</button>' +
                  '<button class="btn btn-xs btn-danger">Sil</button>' +
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

    // $('.btn, .btn-info').click(() => {
    //   console.log($(this).attr('id'));
    // });

    table.on('click', '.btn-default', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.$router.push({ name: 'user', params: { id: data.id } })
    })

    table.on('click', '.btn-danger', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      Messenger.showPrompt('Kullanıcıyı pasifleştirmek istediğinize emin misiniz?')
        .then(value => {
          if (value.isConfirmed) {
            UserService.delete(data.id)
              .then(res => { Messenger.showSuccess(res) })
              .catch(err => { Messenger.showError(err) })
              .finally(() => {
                table.ajax.reload()
              })
          }
        })
    })

    table.on('click', '.btn-warning', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.isApproving = true
      UserService.approveUser(data.id)
        .then(resp => {
          Messenger.showSuccess(resp.message)
          table.ajax.reload()
        })
        .finally(() => { vm.isApproving = false })
    })
  }
}
</script>

<style lang="sass">
</style>
