<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          Değerlendirici Düzenleme ve Elle Puan Hesaplama
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap table-sm">
                    <thead>
                      <tr>
                        <th style="width: 10px">
                          #
                        </th>
                        <th>Değerlendirici</th>
                        <th>Kod</th>
                        <th>Tarih</th>
                        <th style="width: 40px">
                          Puan
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(evaluation, index) in questionEvaluations"
                        :key="evaluation.elector_id"
                      >
                        <td>{{ index + 1 }}.</td>
                        <td>{{ evaluation.full_name }}</td>
                        <td>{{ evaluation.code }}</td>
                        <td>{{ evaluation.date | trDate }}</td>
                        <td>
                          <div class="row justify-content-md-center">
                            <a
                              v-if="!evaluation.point"
                              class="btn btn-xs btn-danger"
                              @click="removeEvalRequest(evaluation.id)"
                            >
                              <strong style="color: white">X</strong>
                            </a>
                            <a
                              v-else
                              class="btn btn-xs btn-warning"
                            ><strong>{{ evaluation.point }}</strong></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-md-center">
            <div class="col-md-4">
              <button
                class="btn btn-primary btn-block"
                @click="manuallyCalculate"
              >
                Manuel Hesapla
              </button>
            </div>
          </div>
          <hr>
          <div class="row justify-content-md-center mt-3">
            <div class="col-md-8">
              <v-select
                ref="selectedElectorRef"
                v-model="selectedEvaluators"
                multiple
                :options="allElectors"
                label="full_name"
                placeholder="Değerlendirici seçiniz"
              >
                <div slot="no-options">
                  Burada birşey bulamadık
                </div>
              </v-select>
            </div>
          </div>
          <div class="row justify-content-md-center mt-3">
            <div class="col-md-4">
              <button
                :class="{disabled : selectedEvaluators.length === 0}"
                class="btn btn-success btn-block"
                @click="addElectors"
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

<script>
import vSelect from 'vue-select'
import UserService from '../../services/UserService'
import Messenger from '../../helpers/messenger'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import { ResponseCodes } from '../../helpers/constants'

export default {
  name: 'EvaluationCalculation',
  components: { vSelect },
  props: ['question'],
  data: () => ({
    selectedEvaluators: [],
    allElectors: [],
    questionEvaluations: [],
    code: null
  }),
  computed: {
    hasPoint (currentElection) {
      return !!currentElection.point
    }
  },
  created () {
    setTimeout(() => { this.loadData() }, 1000)
  },
  methods: {
    removeEvalRequest (id) {
      Messenger.showPrompt('Bu değerlendiriciye atanmış isteği silmek istiyor munuz?')
        .then((result) => {
          if (result.isConfirmed) {
            QuestionEvaluationService.deleteById(id)
              .then((response) => {
                if (response.code === ResponseCodes.CODE_SUCCESS) {
                  Messenger.showSuccess('Seçili istek başarıyla silindi.')
                }
              })
              .finally(() => this.loadData())
          }
        })
    },
    addElectors () {
      if (!this.selectedEvaluators && this.selectedEvaluators.length === 0) return
      const electors = this.selectedEvaluators.map(value => value.full_name).join(', ')
      // this.selectedEvaluators.forEach(se => {
      //   electors += ` ${se.full_name}`
      // })
      Messenger.showPrompt(`Bu soruya <b>${electors}</b> ad ve branşlı değerlendirici(yi/leri) eklemek isdeğinizden emin misiniz?`)
        .then(value => {
          if (value.isConfirmed) {
            QuestionEvaluationService
              .addElectors(this.question.id, this.code, this.selectedEvaluators.map(e => e.id))
              .then((response) => {
                switch (response.code) {
                  case ResponseCodes.CODE_SUCCESS: {
                    Messenger.showSuccess(response.message)
                    break
                  }
                  case ResponseCodes.CODE_ERROR: {
                    Messenger.showError(response.message)
                    break
                  }
                }
              })
              .finally(() => {
                this.loadData()
                this.$refs.selectedElectorRef.clearSelection()
              })
          }
        })
    },
    manuallyCalculate () {
      Messenger.showPrompt('Bu soruya ait değerlendirme puanını elle hesaplamak istediğinizden emin misiniz?')
        .then((result) => {
          if (result.isConfirmed) {
            QuestionEvaluationService.manuallyCalculate(this.question.id, this.questionEvaluations[0].code)
              .then((result) => {
                switch (result.code) {
                  case ResponseCodes.CODE_SUCCESS: {
                    Messenger.showSuccess(result.message)
                    break
                  }
                  case ResponseCodes.CODE_WARNING: {
                    Messenger.showWarning(result.message)
                    break
                  }
                }
              })
              .catch((e) => { Messenger.showError('Hesaplama sırasında bir hata meydana geldi!') })
          }
        })
    },
    loadData () {
      Promise.all([
        QuestionEvaluationService.findByQuestionId(this.question.id),
        UserService.findElectorsByBranchId(this.question.branch_id)
      ])
        .then(([questionEvaluations, electors]) => {
          this.questionEvaluations = questionEvaluations
          this.allElectors = electors.filter(elector => !questionEvaluations.find(e => e.elector_id === elector.id))
          this.code = questionEvaluations[0].code
        })
        .catch(reason => Messenger.showError('Üzgünüz bu soruyla ilgili gerekli yüklememleri yapamadık!'))
    }
  }
}
</script>

<style scoped>

</style>
