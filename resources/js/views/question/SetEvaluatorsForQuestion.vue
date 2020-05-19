<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <header-delete-request-component
              title="Soru Değerlendirme"
              :question="question"
            />
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <question
                :question="question"
                :question-file="questionFile"
              />
            </div>
          </div>
        </div>
        <div class="box box-info">
          <div class="box-header with-border">
            <h4>Değerlendirici Ataması</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div
                  v-if="checkForEvaluationReq"
                  class="row"
                >
                  <div class="col-md-offset-3 col-md-5 col-xs-12">
                    <div
                      class="form-group has-feedback"
                    >
                      <label>Değerlendirici Seçiniz</label>
                      <v-select
                        ref="evaluatorsRef"
                        v-model="selectedEvaluator"
                        label="full_name"
                        :options="evaluators"
                        placeholder="Değerlendirici seçebilirsiniz"
                        @input="addElector"
                      >
                        <div slot="no-options">
                          Maalesef hiç değerlendiricimiz yok
                        </div>
                      </v-select>
                    </div>
                  </div>
                  <div class="col-md-offset-4 col-md-3 col-xs-12">
                    <button
                      class="btn btn-primary btn-block"
                      style="margin-bottom: 10px"
                      @click="setElectors"
                    >
                      Değerlendiricileri Kaydet
                    </button>
                  </div>
                  <div
                    v-if="selectedEvaluators !== null && selectedEvaluators.length>0"
                    class="row"
                  >
                    <div class="col-md-offset-3 col-md-5 col-xs-12">
                      <ul class="list-group">
                        <li
                          v-for="(elector, index) in selectedEvaluators"
                          :key="index"
                          class="list-group-item"
                        >
                          {{ index + 1 }}. {{ elector.full_name }}
                          <a
                            href=""
                            class="label label-danger pull-right"
                            @click.prevent="removeElector(elector.id)"
                          >x</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div
                  v-if="savedEvaluators !== null && savedEvaluators.length>0"
                  class="row"
                >
                  <div class="col-md-12">
                    <div class="table-responsive">
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
                            <th>Aksiyon</th>
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
                            <td>
                              <button
                                class="btn btn-danger btn-xs"
                                @click="deleteEvaluationRequests(elector.code)"
                              >
                                Sil
                              </button>
                            </td>
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
    <div
      v-if="hasOwnEval"
      class="row"
    >
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">
              Değerlendirme Kaydet
            </h3>
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <div
                class="row"
              >
                <div class="col-md-offset-4 col-md-4">
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('evalPoint')}"
                  >
                    <label>Değerlendirme Puanı</label>
                    <v-select
                      v-model="point"
                      v-validate="'required'"
                      :options="points"
                      :reduce="p => p.key"
                      label="title"
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
                      class="help-block"
                    >{{ errors.first('evalPoint') }}</span>
                    <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                    <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                  </div>
                  <div
                    v-if="point <= 3"
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('evalComment')}"
                  >
                    <textarea
                      v-model="comment"
                      v-validate="'required'"
                      name="evalComment"
                      class="form-control"
                      style="max-width: 100%; min-width: 100%; min-height: 60px"
                      placeholder="Değerlendirmenizi kısaca açıklayınız."
                    />
                    <span class="glyphicon glyphicon-magnet form-control-feedback" />
                    <span
                      v-if="errors.has('evalComment')"
                      class="help-block"
                    >{{ errors.first('evalComment') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-offset-5 col-md-2">
                    <div class="text-center">
                      <button
                        class="btn btn-success"
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
      </div>
    </div>
    <div
      v-show="filteredEvalList !== null && filteredEvalList.length > 0"
      class="row"
    >
      <div class="col-md-12">
        <div class="box box-primary direct-chat direct-chat-primary">
          <div class="box-header with-border">
            <h3 class="box-title">
              Değerlendirmeler
            </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="direct-chat-messages">
              <div
                v-for="(evaluation, index) in filteredEvalList"
                :key="evaluation.id"
                class="direct-chat-msg"
              >
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">Değerlendirici {{ index + 1 }}</span>
                  <span class="direct-chat-timestamp pull-right">{{ evaluation.date }}</span>
                </div>
                <img
                  class="direct-chat-img"
                  :src="userImage"
                  alt="Message User Image"
                >
                <div class="direct-chat-text">
                  {{ evaluation.comment }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
import HeaderDeleteRequestComponent from '../../components/HeaderDeleteRequestComponent'

export default {
  name: 'SetEvaluatorsForQuestion',
  components: { HeaderDeleteRequestComponent, vSelect, Question },
  data () {
    return {
      question: null,
      questionFile: null,
      evaluators: [],
      selectedEvaluator: '',
      selectedEvaluators: [],
      savedEvaluators: [],
      evaluationList: [],
      filteredEvalList: [],
      userImage: usersImg
    }
  },
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
          loader.hide()
        })
        .catch(reason => {
          loader.hide()
          Messenger.showError(reason.message)
        })
    },
    getQuestion () {
      const questionId = this.$route.params.questionId
      QuestionService.findById(questionId)
        .then(value => { this.question = value })
        .catch(reason => Messenger.showError(reason))
    },
    findElectorsByBranchId () {
      // TODO burada bir promise çağrısı daha yapılacak ve hali hazırda kabul edilmiş değerlendiricler eklenecek
      UserService.findElectorsByBranchId(this.question.branch_id)
        .then(value => {
          this.evaluators = value
        })
        .catch(reason => Messenger.showError(reason.message))
    },
    removeElector (id) {
      const evaluator = this.selectedEvaluators.filter(value => id === value.id)
      this.selectedEvaluators = this.selectedEvaluators.filter(value => id !== value.id)
      this.evaluators = this.evaluators.concat(evaluator)
      this.$refs.evaluatorsRef.clearSelection()
    },
    addElector () {
      if (this.selectedEvaluator !== null && this.selectedEvaluators.length <= 5) {
        this.selectedEvaluators.push(this.selectedEvaluator)
        this.evaluators = this.evaluators.filter(value => this.selectedEvaluator.id !== value.id)
        this.$refs.evaluatorsRef.clearSelection()
      }
    },
    setElectors () {
      if (this.selectedEvaluators.length >= 2) {
        let electors = ''
        this.selectedEvaluators.forEach(value => { electors += ` ${value.full_name}` })
        Messenger.showPrompt(`Bu soruya değerlendirici olarak${electors} adlı kişileri seçtiniz. Onaylıyor musunuz?`,
          {
            cancel: 'İptal',
            ok: {
              text: 'Evet',
              value: true
            }
          })
          .then(value => {
            if (value) {
              QuestionEvaluationService.saveElectors(this.question.id, this.selectedEvaluators)
                .then(resp => {
                  Messenger.showSuccess(resp.message)
                    .then(() => {
                      this.refreshQuestion()
                    })
                })
                .catch(reason => Messenger.showError(reason.message))
            }
          })
          .catch(reason => {})
      } else {
        Messenger.showWarning('Lütfen en az iki tane değerlendirici seçiniz!')
      }
    },
    deleteEvaluationRequests (code) {
      Messenger.showPrompt(`Bu soru için istenmiş/cevaplamış ${code} koduna sahip tüm istekler silininecektir! Onaylıyor musunuz?`,
        {
          cancel: 'İptal',
          ok: {
            text: 'Evet',
            value: true
          }
        })
        .then(value => {
          if (value) {
            QuestionEvaluationService.deleteByCode(this.question.id, code)
              .then(resp => {
                Messenger.showSuccess(resp.message)
                  .then(() => {
                    this.refreshQuestion()
                  })
              })
              .catch(reason => Messenger.showError(reason.message))
          }
        })
        .catch(reason => {})
    },
    saveEval () {
      this.$validator.validateAll()
        .then(value => {
          if (!value) return
          const data = { qer_id: this.$route.params.qerId, point: this.point, comment: this.comment }
          if (this.point >= 4) data.comment = this.points.reduce(p => p.key === this.point).title
          QuestionEvaluationService.save(this.question.id, data)
            .then(res => {
              Messenger.showInfo(res.message)
              this.getEvals()
              this.getQuestion()
            })
            .catch(() => {
              Messenger.showError(Messenger.showError(MessengerConstants.errorMessage))
            })
        })
    },
    refreshQuestion () {
      Promise.all([QuestionService.findById(this.question.id), QuestionEvaluationService.findByQuestionId(this.question.id)])
        .then(([question, savedEvaluators]) => {
          this.question = question
          this.savedEvaluators = savedEvaluators
        })
        .catch(reason => Messenger.showError(reason.message))
    },
    deleteRequest () {
      Messenger.showInput('Soruyu neden silmek istiyorsunuz? Kısaca yazınız')
        .then(result => {
          if (result) {
            QuestionService.sendDeleteRequest(this.question.id, { reason: result })
              .then(resp => {
                Messenger.showInfoV2(resp.message)
                  .then(() => this.$router.push({ name: 'stats' }))
              })
              .catch(err => Messenger.showError(err.message))
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
