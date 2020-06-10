<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>Kullanıcı Listesi</h4>
          </div>
          <div class="box-body">
            <div
              class="table-responsive"
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
  </section>
</template>

<script>
import Constants from '../../helpers/constants'
import Auth from '../../services/AuthService'
import UserService from '../../services/UserService'
import Messenger from '../../helpers/messenger'
import tr from '../../helpers/dataTablesTurkish'

export default {
  name: 'UserList',
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
            const token = localStorage.getItem(Constants.accessToken)
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
                return '<div class="btn-group">' +
                    '<button class="btn btn-xs btn-info">Göster</button>' +
                    '<button class="btn btn-xs btn-danger">Pasif.</button>' +
                    '</div>'
              }
              return '<div class="btn-group">' +
                  '<button class="btn btn-xs btn-info">Göster</button>' +
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

    table.on('click', '.btn-info', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.$router.push({ name: 'user', params: { id: data.id } })
    })

    table.on('click', '.btn-danger', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      Messenger.showPrompt('Kullanıcıyı pasifleştirmek istediğinize emin misiniz?',
        {
          cancel: 'İptal',
          ok: {
            text: 'Evet',
            value: true
          }
        }).then(value => {
        if (value) {
          UserService.delete(data.id)
            .then(res => {
              Messenger.showSuccess(res)
              table.ajax.reload()
            })
            .catch(err => {
              Messenger.showError(err)
              table.ajax.reload()
            })
        }
      })
    })

    table.on('click', '.btn-warning', (e) => {
      const data = table.row($(e.toElement).parents('tr')[0]).data()
      // console.log(data);
      vm.isApproving = true
      UserService.approveUser(data.id, (resp) => {
        Messenger.showSuccess(resp.message)
        table.ajax.reload()
        vm.isApproving = false
      })
    })
  }
}
</script>

<style lang="sass">
  @import '~datatables.net-bs4/css/dataTables.bootstrap4.min.css'
  @import '~datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'
</style>
