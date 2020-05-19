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
            <header-delete-request
              title="Soru İnceleme"
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
      </div>
    </div>
    <timeline :question-id="questionId" />
  </section>
</template>

<script>
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import RevisionService from '../../services/CommentService'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
import Question from '../../components/questions/Question'
import usersImg from '../../../images/users.png'
import Timeline from '../../components/questions/Timeline'
import HeaderDeleteRequest from '../../components/HeaderDeleteRequest'

export default {
  name: 'ShowQuestion',
  components: { Timeline, Question, HeaderDeleteRequest },
  data () {
    return {
      question: null,
      questionFile: null,
      oldQuestionFile: null,
      revisions: [],
      evaluations: [],
      userImage: usersImg,
      questionId: null
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
    }
  },
  created () {
    setTimeout(() => { this.getFile() }, 1500)
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
          vm.questionId = questionId
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
