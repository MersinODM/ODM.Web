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
            <h4>
              Soru İnceleme
              <div
                v-if="isOwner"
                class="pull-right"
              >
                <button
                  class="btn btn-danger pull-right"
                  style="margin-right: 10px"
                  @click="deleteRequest"
                >
                  Silme Talep Et
                </button>
              </div>
            </h4>
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
      v-show="checkEvals"
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
                v-for="(evaluation, index) in evaluations"
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
    <div
      v-show="revisions !== null && revisions.length > 0"
      class="row"
    >
      <div class="col-md-12">
        <div class="box box-primary direct-chat direct-chat-primary">
          <div class="box-header with-border">
            <h3 class="box-title">
              Gözden geçirmeler
            </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
              <!-- Message. Default to the left -->
              <div
                v-for="rev in revisions"
                :key="rev.id"
                class="direct-chat-msg"
              >
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">{{ rev.title }}</span>
                  <span class="direct-chat-timestamp pull-right">{{ rev.date }}</span>
                </div>
                <img
                  class="direct-chat-img"
                  :src="userImage"
                  alt="Message User Image"
                >
                <div class="direct-chat-text">
                  {{ rev.comment }}
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
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import RevisionService from '../../services/CommentService'
import usersImg from '../../../images/users.png'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import AuthService from '../../services/AuthService'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
import Question from '../../components/Question'

export default {
  name: 'ShowQuestion',
  components: { Question },
  data () {
    return {
      question: null,
      questionFile: null,
      oldQuestionFile: null,
      revisions: [],
      evaluations: [],
      userImage: usersImg
    }
  },
  computed: {
    getStatusClass () {
      return {
        'label-danger': this.question.status === QuestionStatuses.NOT_MUST_ASKED,
        'label-info': this.question.status === QuestionStatuses.IN_ELECTION,
        'label-primary': this.question.status === QuestionStatuses.REVISION_COMPLETED,
        'label-warning': this.question.status === QuestionStatuses.NEED_REVISION,
        'label-success': this.question.status === QuestionStatuses.APPROVED,
        'label-default': this.question.status === QuestionStatuses.WAITING_FOR_ACTION
      }
    },
    checkEvals () {
      return this.evaluations !== null && this.evaluations.length > 0
    },
    isOwner () {
      if (this.question) {
        return ((this.question.creator_id === AuthService.getUserId() && !this.question.has_delete_request) ||
                (this.$isInRole('admin') && !this.question.has_delete_request))
      }
      return false
    }
  },
  created () {
    setTimeout(() => { this.getFile() }, 1500)
    setTimeout(() => { this.findElectorsByBranchId() }, 1000)
  },
  beforeRouteEnter (to, from, next) {
    const questionId = to.params.questionId
    Promise.all([
      QuestionService.findById(questionId),
      RevisionService.getRevisions(questionId),
      QuestionEvaluationService.findByQuestionId(questionId)
    ])
      .then(([question, revisions, evaluations]) => {
        next(vm => {
          vm.question = question
          vm.revisions = revisions
          vm.evaluations = evaluations.filter(e => !e.is_open)
        })
      })
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
    getRevisions () {
      RevisionService.getRevisions(this.$route.params.questionId)
        .then((revisions) => {
          this.revisions = revisions
        })
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
