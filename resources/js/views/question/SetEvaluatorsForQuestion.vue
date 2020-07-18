<template>
  <page>
    <template v-slot:header>
      <header-delete-request
        :question="question"
      >
        <h4>Soru Değerlendirme</h4>
      </header-delete-request>
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
              <div class="card">
                <div class="card-header with-border">
                  <h4>Değerlendirici Ataması</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div
                        v-if="checkForEvaluationReq"
                        class="row justify-content-md-center"
                      >
                        <div class="col-md-5 col-xs-12">
                          <div
                            class="form-group has-feedback"
                          >
                            <label>Değerlendirici Seçiniz</label>
                            <v-select
                              ref="evaluatorsRef"
                              v-model="selectedEvaluators"
                              multiple
                              label="full_name"
                              :options="evaluators"
                              placeholder="Değerlendirici/leri seçebilirsiniz"
                            >
                              <div slot="no-options">
                                Maalesef hiç değerlendiricimiz yok
                              </div>
                            </v-select>
                          </div>
                          <div class="col-md-12 col-xs-12">
                            <button
                              class="btn btn-primary btn-block"
                              style="margin-bottom: 10px"
                              @click="setElectors"
                            >
                              Değerlendiricileri Kaydet
                            </button>
                          </div>
                        </div>
                      </div>
                      <div
                        v-if="savedEvaluators !== null && savedEvaluators.length>0"
                        class="row"
                      >
                        <div class="col-md-12">
                          <div class="dataTables_wrapper dt-bootstrap4">
                            <table
                              class="table"
                              style="width: 100%"
                            >
                              <thead>
                                <tr>
                                  <th>Sıra</th>
                                  <th>Ad Soyad</th>
                                  <th>Kod</th>
                                  <th>Yorum</th>
                                  <th>Puan</th>
                                  <th>Tarih</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr
                                  v-for="(elector, index) in savedEvaluators"
                                  :key="index"
                                >
                                  <td>{{ index + 1 }}</td>
                                  <td>{{ elector.full_name }}</td>
                                  <td>{{ elector.code }}</td>
                                  <td>{{ elector.comment }}</td>
                                  <td>{{ elector.point }}</td>
                                  <td>{{ elector.updated_at | trDate }}</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <timeline :question-id="$route.params.questionId" />
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
import usersImg from '../../../images/users.png'
import Question from '../../components/questions/Question'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
import UserService from '../../services/UserService'
import HeaderDeleteRequest from '../../components/HeaderDeleteRequest'
import Timeline from '../../components/questions/Timeline'
import Page from '../../components/Page'

export default {
  name: 'SetEvaluatorsForQuestion',
  components: { Page, Timeline, HeaderDeleteRequest, vSelect, Question },
  data: () => ({
    question: null,
    questionFile: null,
    evaluators: [],
    selectedEvaluator: '',
    selectedEvaluators: [],
    savedEvaluators: [],
    userImage: usersImg
  }),
  beforeRouteEnter (to, from, next) {
    const questionId = to.params.questionId
    Promise.all([
      QuestionService.findById(questionId),
      QuestionEvaluationService.findByQuestionId(questionId)])
      .then(([question, savedEvaluations]) => {
        next(vm => {
          vm.question = question
          vm.savedEvaluators = savedEvaluations
        })
      })
  },
  computed: {
    checkForEvaluationReq () {
      if (this.question) {
        return (this.$isInRole('admin') && this.question.status === QuestionStatuses.WAITING_FOR_ACTION) ||
                (this.$isInRole('admin') && this.question.status === QuestionStatuses.REVISION_COMPLETED &&
                (this.savedEvaluators !== null &&
                this.savedEvaluators.filter(se => se.point !== null || se.point > 0).length > 0))
      }
      return false
    }
  },
  created () {
    setTimeout(() => this.getFile(), 1500)
    setTimeout(() => { this.findElectorsByBranchId() }, 1000)
  },
  methods: {
    getFile () {
      const loader = this.$loading.show()
      QuestionService.getFile(this.$route.params.questionId)
        .then(value => {
          this.questionFile = value
        })
        .catch(reason => {
          Messenger.showError(reason.message)
        })
        .finally(() => { loader.hide() })
    },
    getQuestion () {
      const questionId = this.$route.params.questionId
      QuestionService.findById(questionId)
        .then(value => {
          this.question = value
        })
        .catch(reason => Messenger.showError(reason))
    },
    findElectorsByBranchId () {
      UserService.findElectorsByBranchId(this.question.branch_id)
        .then(electors => {
          this.evaluators = electors
        })
        .catch(reason => Messenger.showError(reason.message))
    },
    setElectors () {
      const res = this.selectedEvaluators
        .filter(elector => elector.branch_id === this.question.branch_id)
        .length >= 2
      if (res) {
        const electors = this.selectedEvaluators.map(value => value.full_name).join(', ')
        Messenger.showPrompt(`Bu soruya değerlendirici olarak <b>${electors}</b> adlı kişileri seçtiniz. Onaylıyor musunuz?`,
          {
            cancelText: 'Hayır',
            confirmText: 'Evet'
          })
          .then(value => {
            if (value.isConfirmed) {
              const loader = this.$loading.show()
              QuestionEvaluationService.saveElectors(this.question.id, this.selectedEvaluators)
                .then(resp => {
                  loader.hide()
                  Messenger.showSuccess(resp.message)
                    .then(() => {
                      this.refreshQuestion()
                    })
                })
                .catch(reason => Messenger.showError(reason.message))
                .finally(() => {
                  loader.hide()
                  this.$refs.evaluatorsRef.clearSelection()
                })
            }
          })
          .catch(reason => {})
      } else {
        Messenger.showWarning('Aynı alandan olmak üzere lütfen en az iki tane değerlendirici seçiniz!')
      }
    },
    refreshQuestion () {
      Promise.all([QuestionService.findById(this.question.id), QuestionEvaluationService.findByQuestionId(this.question.id)])
        .then(([question, savedEvaluators]) => {
          this.question = question
          this.savedEvaluators = savedEvaluators
        })
        .catch(reason => Messenger.showError(reason.message))
    }
  }
}
</script>

<style scoped>

</style>
