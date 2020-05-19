<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>Soru Değerlendirme</h4>
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
      </div>
    </div>
    <div
      v-if="hasOpenEval"
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
                v-for="(evaluation) in filteredEvalList"
                :key="evaluation.id"
                class="direct-chat-msg"
              >
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">Değerlendirici {{ evaluation.code }}</span>
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
    <timeline :question-id="questionId" />
  </section>
</template>

<script>
import vSelect from 'vue-select'
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import usersImg from '../../../images/users.png'
import AuthService from '../../services/AuthService'
import Question from '../../components/questions/Question'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
// import RevisionService from '../../services/CommentService'
import Timeline from '../../components/questions/Timeline'

export default {
  name: 'EvaluateQuestion',
  components: { Timeline, vSelect, Question },
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
      userImage: usersImg,
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
          // vm.getEvals()
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
    // getEvals () {
    //   QuestionEvaluationService.findByQuestionId(this.question.id)
    //     .then(qeList => {
    //       this.evaluationList = qeList
    //       this.filteredEvalList = qeList.filter(q => q.point !== null && q.point > 0)
    //     })
    //     .catch(() => Messenger.showError('Değerlendirme listesi yüklenemedi!'))
    // },
    // getRevisions () {
    //   RevisionService.getRevisions(this.$route.params.questionId)
    //     .then((revisions) => {
    //       this.revisions = revisions
    //     })
    //     .catch(() => Messenger.showError('Revizyonlar yüklenemedi!'))
    // },
    saveEval () {
      this.$validator.validateAll()
        .then(value => {
          if (!value) return
          const data = { qer_id: this.$route.params.qerId, point: this.point, comment: this.comment }
          if (this.point >= 4) data.comment = this.points.filter(p => p.key === this.point)[0].title
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
    }
  }
}
</script>

<style scoped>

</style>
