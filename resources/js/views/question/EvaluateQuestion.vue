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
      <h4>Soru Değerlendirme</h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="col-md-12">
                    <question
                      :question="question"
                      :question-file="questionFile"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            v-if="hasOpenEval"
            class="row"
          >
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header with-border">
                  <h3 class="card-title">
                    Değerlendirme Kaydet
                  </h3>
                </div>
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="row justify-content-md-center">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Değerlendirme Puanı</label>
                          <v-select
                            v-model="point"
                            v-validate="'required'"
                            :options="points"
                            :reduce="p => p.key"
                            label="title"
                            :class="{'is-invalid': errors.has('evalPoint')}"
                            name="evalPoint"
                            placeholder="Puanınızı seçiniz"
                          >
                            <template
                              slot="option"
                              slot-scope="option"
                            >
                              {{ option.key }} - {{ option.title }}
                            </template>
                            <template
                              slot="selected-option"
                              slot-scope="option"
                            >
                              {{ option.key }} - {{ option.title }}
                            </template>
                          </v-select>
                          <span
                            v-if="errors.has('evalPoint')"
                            class="error invalid-feedback"
                          >{{ errors.first('evalPoint') }}</span>
                        </div>
                        <div class="form-group">
                          <textarea
                            v-model="comment"
                            v-validate="'required'"
                            name="evalComment"
                            class="form-control"
                            style="max-width: 100%; min-width: 100%; min-height: 60px"
                            :class="{'is-invalid': errors.has('evalComment')}"
                            placeholder="Değerlendirmenizi kısaca açıklayınız."
                          />
                          <span
                            v-if="errors.has('evalComment')"
                            class="error invalid-feedback"
                          >{{ errors.first('evalComment') }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="col-md-4">
                        <button
                          class="btn btn-success btn-block"
                          @click="saveEval"
                        >
                          KAYDET
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <timeline :question-id="questionId" />
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import vSelect from 'vue-select'
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import AuthService from '../../services/AuthService'
import Question from '../../components/questions/Question'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
// import RevisionService from '../../services/CommentService'
import Timeline from '../../components/questions/Timeline'
import Page from '../../components/Page'

export default {
  name: 'EvaluateQuestion',
  components: { Timeline, vSelect, Question, Page },
  data () {
    return {
      question: null,
      questionFile: null,
      points: [
        { key: 1, title: 'Kesinlikle Kullanılamaz' },
        { key: 2, title: 'Kullanılamaz' },
        { key: 3, title: 'Düzeltme Gerekir' },
        { key: 4, title: 'Kullanılabilir' },
        { key: 5, title: 'Kesinlikle Kullanılmalı' }
      ],
      point: '',
      comment: '',
      revisions: [],
      evaluationList: [],
      filteredEvalList: [],
      questionId: 0
    }
  },
  beforeRouteEnter (to, from, next) {
    const questionId = to.params.questionId
    QuestionService.findById(questionId)
      .then((res) => {
        next(vm => {
          vm.question = res
          vm.getFile()
          vm.questionId = questionId
          vm.getEvals()
        })
      })
  },
  computed: {
    hasOpenEval () {
      if (this.question) {
        return this.question.status === QuestionStatuses.IN_ELECTION &&
                (this.evaluationList.filter(value => value.elector_id === AuthService.getUserId() &&
                        value.is_open && value.code === this.$route.query.code).length > 0)
      }
      return false
    }
  },
  methods: {
    getFile () {
      const loader = this.$loading.show()
      QuestionService.getFile(this.question.id)
        .then((res) => {
          this.questionFile = res
          loader.hide()
        })
        .catch(() => {
          Messenger.showError(MessengerConstants.errorMessage)
          loader.hide()
        })
    },
    getQuestion () {
      const questionId = this.$route.params.questionId
      QuestionService.findById(questionId)
        .then(value => { this.question = value })
        .catch(reason => Messenger.showError(reason))
    },
    getEvals () {
      QuestionEvaluationService.findByQuestionId(this.question.id)
        .then(qeList => {
          this.evaluationList = qeList
          this.filteredEvalList = qeList.filter(q => q.point !== null && q.point > 0)
        })
        .catch(() => Messenger.showError('Değerlendirme listesi yüklenemedi!'))
    },
    // getRevisions () {
    //   RevisionService.getRevisions(this.$route.params.questionId)
    //     .then((revisions) => {
    //       this.revisions = revisions
    //     })
    //     .catch(() => Messenger.showError('Revizyonlar yüklenemedi!'))
    // },
    async saveEval () {
      const validationResult = await this.$validator.validateAll()
      if (!validationResult) return
      const data = { qer_id: this.$route.params.qerId, point: this.point, comment: this.comment }
      // if (this.point >= 4) data.comment = this.points.filter(p => p.key === this.point)[0].title
      const promptRes = await Messenger.showPrompt('Değerlendirmenizi kaydetmek istediğinizden emin misiniz?')
      if (promptRes.isConfirmed) {
        try {
          const result = await QuestionEvaluationService.save(this.question.id, data)
          await Messenger.showInfo(result.message)
          this.getEvals()
          this.getQuestion()
        } catch (err) {
          await Messenger.showError(err.message)
        }
      }
    }
  }
}
</script>

<style scoped>

</style>
