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
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-10 col-sm-12">
              Değerlendirici Düzenleme ve Elle Puan Hesaplama
            </div>
            <div class="col-md-2 col-sm-12">
              <button
                class="btn btn-danger btn-block float-right"
                @click="deleteAllEvaluations"
              >
                Tüm grubu sil
              </button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h6 v-if="question">
                Manuel hesaplama için gereken puanlama sayısı en az <b>{{ question.min_required_election }}</b> olmalıdır
              </h6>
            </div>
          </div>
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
                              :class="{disabled: !evaluation.canRemove}"
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
          <div
            v-if="hasRequiredMinElections"
            class="row justify-content-md-center"
          >
            <div class="col-md-6">
              <button
                class="btn btn-primary btn-block"
                @click="manuallyCalculate"
              >
                Manuel Hesapla
              </button>
            </div>
          </div>
          <hr>
          <div
            class="row justify-content-md-center mt-3"
          >
            <div class="col-md-8">
              <v-select
                ref="selectedElectorRef"
                v-model="selectedEvaluators"
                multiple
                :class="{'is-invalid': selectionMessage}"
                :options="allElectors"
                label="full_name"
                append-to-body
                :calculate-position="withPopper"
                placeholder="Değerlendirici seçiniz"
                @input="onSelectionChanged"
              >
                <div slot="no-options">
                  Burada birşey bulamadık
                </div>
              </v-select>
              <span
                v-if="selectionMessage"
                class="error invalid-feedback"
              >{{ selectionMessage }}</span>
            </div>
          </div>
          <div class="row justify-content-md-center mt-3">
            <div class="col-md-6">
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
import { SettingService } from '../../services/SettingService'
import { createPopper } from '@popperjs/core/dist/umd/popper-lite.min'

export default {
  name: 'EvaluationCalculation',
  components: { vSelect },
  props: {
    question: {
      type: Object,
      default: Object,
      required: true
    }
  },
  data: () => ({
    selectedEvaluators: [],
    allElectors: [],
    questionEvaluations: [],
    code: '',
    constraints: '',
    selectionMessage: '',
    placement: 'top'
  }),
  computed: {
    hasPoint (currentElection) {
      return !!currentElection.point
    },
    hasMaxNumberOfElectors () {
      const res = this.questionEvaluations.length + this.selectedEvaluators.length < this.constraints.max_elector_count
      // eslint-disable-next-line no-unused-expressions
      return res
    },
    hasRequiredMinElections () {
      return this.questionEvaluations.filter(value => !!value.point).length >= this.question.min_required_election
    }
  },
  watch: {
    questionEvaluations: {
      deep: true,
      handler () {
        this.calculate()
      }
    }
  },
  async created () {
    await this.loadData()
    this.constraints = await SettingService.getQuestionConstraints()
  },
  methods: {
    calculate () {
      const sameBranches = this.questionEvaluations.filter(elector => elector.branch_id === this.question.branch_id)
      // const others = this.questionEvaluations.length - sameBranches.length
      const rule1 = sameBranches.length <= Math.round(this.question.min_required_election / 2)
      const rule2 = this.questionEvaluations.length <= this.question.min_required_election
      if (rule1) {
        this.questionEvaluations.forEach((q) => {
          if (sameBranches.find(a => a.id === q.id)) { q.canRemove = false }
        })
      }
      if (rule2) {
        this.questionEvaluations.forEach((q) => { q.canRemove = false })
      }
    },
    async removeEvalRequest (id) {
      const result = await Messenger.showPrompt('Bu değerlendiriciye atanmış isteği silmek istiyor munuz?')
      if (result.isConfirmed) {
        try {
          const response = await QuestionEvaluationService.deleteById(id)
          if (response.code === ResponseCodes.CODE_SUCCESS) {
            await Messenger.showSuccess('Seçili istek başarıyla silindi.')
            this.allElectors.push(this.questionEvaluations.find(e => e.id === id))
            this.questionEvaluations.splice(this.questionEvaluations.findIndex(e => e.id === id), 1)
            if (this.questionEvaluations.length <= 0) {
              await Messenger.showWarning('Mevcut gruptan tüm değerlendirciler silinmiş yeni değerlendirme grubu ataması yapmanız gerekiyor! Sizi bir önceki menüye yönlendiriyoruz')
              await this.$router.push({ name: 'questionTableList' })
            }
          }
        } catch (err) {
          await Messenger.showError(err?.message)
        }
      }
    },
    async addElectors () {
      if (!this.selectedEvaluators && this.selectedEvaluators.length === 0) return
      const electors = this.selectedEvaluators.map(value => value.full_name).join(', ')
      const promptRes = await Messenger.showPrompt(`Bu soruya <b>${electors}</b> ad ve branşlı değerlendirici(yi/leri) eklemek isdeğinizden emin misiniz?`)
      if (promptRes.isConfirmed) {
        try {
          const response = await QuestionEvaluationService
            .addElectors(this.question.id, this.code, this.selectedEvaluators.map(e => e.id))
          switch (response.code) {
            case ResponseCodes.CODE_SUCCESS: {
              await Messenger.showSuccess(response.message)
              break
            }
            case ResponseCodes.CODE_ERROR: {
              await Messenger.showError(response.message)
              break
            }
          }
        } catch (error) {
          await Messenger.showError(error?.message)
        } finally {
          await this.loadData()
          // eslint-disable-next-line no-unused-expressions
          this.$refs?.selectedElectorRef?.clearSelection()
        }
      }
    },
    async manuallyCalculate () {
      const promptRes = await Messenger.showPrompt('Bu soruya ait değerlendirme puanını elle hesaplamak istediğinizden emin misiniz?')
      if (promptRes.isConfirmed) {
        try {
          const result = await QuestionEvaluationService.manuallyCalculate(this.question.id, this.questionEvaluations[0]?.code)
          switch (result.code) {
            case ResponseCodes.CODE_SUCCESS: {
              await Messenger.showSuccess(result.message)
              break
            }
            case ResponseCodes.CODE_WARNING: {
              await Messenger.showWarning(result.message)
              break
            }
          }
        } catch (e) {
          await Messenger.showError('Hesaplama sırasında bir hata meydana geldi!')
        }
      }
    },
    async loadData () {
      try {
        const [questionEvaluations, electors] = await Promise.all([
          QuestionEvaluationService.findByQuestionId(this.question.id, 1),
          UserService.findElectorsByBranchId(this.question.branch_id)
        ])
        this.questionEvaluations = questionEvaluations.map(question => ({ ...question, canRemove: true }))
        this.allElectors = electors
          .filter(elector => !this.questionEvaluations.find(e => e.elector_id === elector.id))
          .filter(elector => elector.id !== this.question.creator_id)
        this.code = questionEvaluations[0]?.code
      } catch (reason) {
        await Messenger.showError('Üzgünüz bu soruyla ilgili gerekli yüklememleri yapamadık!')
      }
    },
    onSelectionChanged (value) {
      if (this.questionEvaluations.length + this.selectedEvaluators.length > this.constraints.max_elector_count) {
        this.selectionMessage = `Seçilebilecek azami değerlendirici/puanlayıcı sayısı ${this.constraints.max_elector_count} olmaldır`
        this.selectedEvaluators.splice(this.selectedEvaluators.findIndex(e => e.id === value.id), 1)

        setTimeout(() => { this.selectionMessage = '' }, 2500)
      }
    },
    async deleteAllEvaluations () {
      const promptRes = await Messenger.showPrompt('Bu soruya atanmış tüm değerlendiriciler puan bile vermiş olasalar silincektir ve bu soru tekrar <b>İşleme Alınmamış</b> olarak işraretlenecektir. Kabul ediyor musunuz?')
      if (promptRes.isConfirmed) {
        try {
          const response = await QuestionEvaluationService.deleteByCode(this.question.id, this.code)
          await Messenger.showSuccess(response.message)
          await Messenger.showWarning('Mevcut gruptan tüm değerlendirciler silinmiş yeni değerlendirme grubu ataması yapmanız gerekiyor! Sizi bir önceki menüye yönlendiriyoruz')
          await this.$router.push({ name: 'questionTableList' })
        } catch (error) {
          await Messenger.showError(error.message)
        }
      }
    },
    withPopper (dropdownList, component, { width }) {
      /**
       * We need to explicitly define the dropdown width since
       * it is usually inherited from the parent with CSS.
       */
      dropdownList.style.width = width

      /**
       * Here we position the dropdownList relative to the $refs.toggle Element.
       *
       * The 'offset' modifier aligns the dropdown so that the $refs.toggle and
       * the dropdownList overlap by 1 pixel.
       *
       * The 'toggleClass' modifier adds a 'drop-up' class to the Vue Select
       * wrapper so that we can set some styles for when the dropdown is placed
       * above.
       */
      const popper = createPopper(component.$refs.toggle, dropdownList, {
        placement: this.placement,
        modifiers: [
          {
            name: 'offset',
            options: {
              offset: [0, -1]
            }
          },
          {
            name: 'toggleClass',
            enabled: true,
            phase: 'write',
            fn ({ state }) {
              component.$el.classList.toggle('drop-up', state.placement === 'top')
            }
          }]
      })

      /**
       * To prevent memory leaks Popper needs to be destroyed.
       * If you return function, it will be called just before dropdown is removed from DOM.
       */
      return () => popper.destroy()
    }
  }
}
</script>

<style>
.v-select.drop-up.vs--open .vs__dropdown-toggle {
  border-radius: 0 0 4px 4px;
  border-top-color: transparent;
  border-bottom-color: rgba(60, 60, 60, 0.26);
}

[data-popper-placement='top'] {
  border-radius: 4px 4px 0 0;
  border-top-style: solid;
  border-bottom-style: none;
  box-shadow: 0 -3px 6px rgba(0, 0, 0, 0.15)
}
</style>
