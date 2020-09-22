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
      <h4>Kazanım Kaydı Düzenleme - <b>{{ learningOutcome.branch_name }}</b></h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="mb-1">Sınıf Seviyesi</label>
                    <v-select
                      v-model="learningOutcome.class_level"
                      :options="classLevels"
                      placeholder="Sınıf seviyesini seçiniz"
                    >
                      <div slot="no-options">
                        Burada bişey bulamadık :-(
                      </div>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <label class="mb-1">Kazanım kodu</label>
                    <input
                      v-model="learningOutcome.code"
                      class="form-control"
                      type="text"
                      placeholder="Kazanım kodu"
                    >
                  </div>
                  <div class="form-group">
                    <textarea
                      v-model="learningOutcome.content"
                      v-validate="'required'"
                      name="content"
                      class="form-control"
                      style="max-width: 100%; min-width: 100%; min-height: 60px"
                      :class="{'is-invalid': errors.has('content')}"
                      placeholder="Değerlendirmenizi kısaca açıklayınız."
                    />
                    <span
                      v-if="errors.has('content')"
                      class="error invalid-feedback"
                    >{{ errors.first('content') }}</span>
                  </div>
                  <div class="form-group">
                    <textarea
                      v-model="learningOutcome.description"
                      class="form-control"
                      style="max-width: 100%; min-width: 100%; min-height: 60px"
                      placeholder="Kısa açıklama ya da ek bilgi alanı"
                    />
                  </div>
                </div>
              </div>
              <div class="row justify-content-md-center">
                <div class="col-md-3">
                  <button
                    class="btn btn-danger btn-block"
                    @click="cancel"
                  >
                    İptal
                  </button>
                </div>
                <div class="col-md-3">
                  <button
                    class="btn btn-primary btn-block"
                    :class="{ disabled: isEnabled }"
                    @click="save"
                  >
                    Kaydet
                  </button>
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
import LearningOutcomesService from '../../services/LearningOutcomesService'
import vSelect from 'vue-select'
import Messenger from '../../helpers/messenger'

export default {
  name: 'EditLearningOutcome',
  components: { Page, vSelect },
  async beforeRouteEnter (to, from, next) {
    const lo = await LearningOutcomesService.findById(to.params.id)
    next(vm => {
      vm.learningOutcome = lo
    })
  },
  data: () => ({
    learningOutcome: '',
    classLevels: [...Array(9).keys()].map(i => i + 4)
  }),
  computed: {
    isEnabled () {
      return !this.learningOutcome.code || !this.learningOutcome.content
    }
  },
  methods: {
    async save () {
      const validationResult = await this.$validator.validateAll()
      if (validationResult) {
        const result = await Messenger.showPrompt('Kazanım düzenlemesini kaydetmek istediğinizden emin misiniz?')
        if (result.isConfirmed) {
          try {
            const result = await LearningOutcomesService.update(this.$route.params.id, this.learningOutcome)
            await Messenger.showInfo(result.message)
          } catch (e) {
            await Messenger.showError(e.message)
          }
        }
      }
    },
    async cancel () {
      const result = await Messenger.showPrompt('Düzenlemeyi iptal etme istediğinizden emin misiniz?')
      if (result.isConfirmed) this.$router.go(-1)
    }
  }
}
</script>

<style scoped>

</style>
