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
            <h4><span class="mdi mdi-bank" /> Okul/Kurum Listesi</h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table
                id="instList"
                style="width:100%"
                class="table table-bordered table-hover dataTable"
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
  </section>
</template>

<script>
import Auth from '../../services/AuthService'
import Constants from '../../helpers/constants'
import tr from '../../helpers/dataTablesTurkish'

export default {
  name: 'InstitutionList',
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
            name: 'i.id'
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
      const data = table.row($(e.toElement).parents('tr')[0]).data()
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
  @import '~datatables.net-bs4/css/dataTables.bootstrap4.min.css'
  @import '~datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'
</style>
