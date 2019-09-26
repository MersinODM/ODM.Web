<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>Kazanım Listesi</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-4">
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('branch')}"
                  >
                    <label>Ders/Alan Seçiniz</label>
                    <v-select
                      v-model="branch"
                      v-validate="'required'"
                      :options="branches"
                      :reduce="branch => branch.id"
                      label="name"
                      name="branch"
                      placeholder="Alan/Ders adının en az 3 harfini girin"
                      @search="searchBranches"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                    <span
                      v-if="errors.has('branch')"
                      class="help-block"
                    >{{ errors.first('branch') }}</span>
                    <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                    <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                  </div>
                </div>
                <div class="col-md-4">
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('branch')}"
                  >
                    <label>Sınıf Seviyesi Seçiniz</label>
                    <v-select
                      v-model="branch"
                      v-validate="'required'"
                      :options="branches"
                      :reduce="branch => branch.id"
                      label="name"
                      name="branch"
                      placeholder="Sınıf seviyesi seçiniz"
                      @search="searchBranches"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                    <span
                      v-if="errors.has('branch')"
                      class="help-block"
                    >{{ errors.first('branch') }}</span>
                    <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                    <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                  </div>
                </div>
                <div class="col-md-4" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'LearningOutcomeList'
}
</script>

<style scoped>

</style>
