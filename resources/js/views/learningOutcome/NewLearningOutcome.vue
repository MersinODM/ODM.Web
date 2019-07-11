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
            <h4>Yeni Kazanım Kaydı</h4>
          </div>
          <div class="box-body">
            <div class="col-md-offset-3 col-md-6">
              <form
                action="post"
                @submit.prevent
              >
                <div
                  class="form-group has-feedback"
                  :class="{'has-error': errors.has('branch')}"
                >
                  <label>Ders/Alan Seçimi</label>
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
                <div
                  :class="{'has-error': errors.has('code')}"
                  class="form-group has-feedback"
                >
                  <label>Kazanım Kodu</label>
                  <input
                    v-model="code"
                    v-validate="'required|min:3'"
                    name="code"
                    type="text"
                    class="form-control"
                    placeholder="Kazanım kodunu giriniz"
                  >
                  <span class="glyphicon glyphicon-book form-control-feedback" />
                  <span
                    v-if="errors.has('code')"
                    class="help-block"
                  >{{ errors.first('code') }}</span>
                </div>
                <div
                  :class="{'has-error': errors.has('content')}"
                  class="form-group has-feedback"
                >
                  <label>Kazanım</label>
                  <textarea
                    v-model="content"
                    v-validate="'required|min:3'"
                    name="content"
                    class="form-control"
                    rows="2"
                    style="max-width: 100%; min-width: 100%; min-height: 50px"
                    placeholder="Kazanım içeriğini giriniz"></textarea>
                  <span class="glyphicon glyphicon-book form-control-feedback" />
                  <span
                    v-if="errors.has('content')"
                    class="help-block"
                  >{{ errors.first('content') }}</span>
                </div>
                <div class="form-group has-feedback">
                  <label>Açıklama</label>
                  <textarea
                    v-model="description"
                    class="form-control"
                    style="max-width: 100%; min-width: 100%; min-height: 50px"
                    placeholder="İsteğe bağlı"></textarea>
                  <span class="glyphicon glyphicon-magnet form-control-feedback" />
                </div>
                <div class="row">
                  <div class="col-xs-offset-4 col-xs-4">
                    <button
                      :class="{ disabled : errors.any() || isSending }"
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
  </section>
</template>

<script>

import vSelect from 'vue-select'
import LearningOutcomesService from '../../services/LearningOutcomesService'
import Messenger from '../../helpers/messenger'

export default {
  name: 'NewLearningOutcome',
  components: { vSelect },
  data () {
    return {
      isSending: false,
      code: null,
      content: null,
      description: null,
      branches: [],
      branch: null
    }
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            this.isSending = true
            LearningOutcomesService.save({
              branch_id: this.branch,
              code: this.code,
              content: this.content,
              description: this.description
            }, (res) => {
              this.isSending = false
              Messenger.showSuccess(res.message)
            })
          }
        })
    },
    searchBranches (search, loading) {
      if (search.length >= 3) {
        this.$http.get('/auth/branches', {
          params: {
            searchTerm: search
          }
        })
          .then(result => {
            // console.log(result)
            this.branches = result.data
          })
          .catch(res => console.log(res))
      }
    }
  }
}
</script>

<style lang="sass">
  @import '~vue-select/dist/vue-select.css'
</style>
