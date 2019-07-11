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
            <h4>Yeni Branş</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <form
                  action="post"
                  @submit.prevent
                >
                  <div
                    :class="{'has-error': errors.has('branchName')}"
                    class="form-group has-feedback"
                  >
                    <label>Branş/Ders Adı</label>
                    <input
                      v-model="branchName"
                      v-validate="'required|min:3'"
                      name="branchName"
                      type="text"
                      class="form-control"
                      placeholder="Branş/Ders adı giriniz"
                    >
                    <span class="glyphicon glyphicon-book form-control-feedback" />
                    <span
                      v-if="errors.has('branchName')"
                      class="help-block"
                    >{{ errors.first('branchName') }}</span>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Kod (İsteğe Bağlı)</label>
                    <input
                      v-model="code"
                      class="form-control"
                      type="text"
                      placeholder="Branş Kodu (İsteğe Bağlı) giriniz"
                    >
                    <span class="glyphicon glyphicon-magnet form-control-feedback" />
                  </div>
                  <div class="row">
                    <!--<div class="col-xs-8">-->
                    <!--<p-check v-model="isChecked" class="p-icon p-smooth" color="primary">-->
                    <!--<i slot="extra" class="icon fa fa-check"></i>-->
                    <!--fa-check-->
                    <!--</p-check>-->
                    <!--</div>-->
                    <!-- /.col -->
                    <div class="col-xs-offset-4 col-xs-4">
                      <button
                        :class="{ disabled : errors.any() }"
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
  </section>
</template>

<script>
import Branch from '../../services/Branch'
import Messenger from '../../helpers/messenger'

export default {
  name: 'NewBranch',
  data () {
    return {
      branchName: '',
      code: ''
    }
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            Branch.save({ name: this.branchName, code: this.code }, (resp) => {
              Messenger.showSuccess(resp.message)
            })
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
