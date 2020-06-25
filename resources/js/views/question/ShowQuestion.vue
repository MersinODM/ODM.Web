<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <page>
    <template v-slot:header>
      <header-delete-request
        :question="question"
      >
        <h3>Soru İnceleme</h3>
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
            </div>
          </div>
          <timeline :question-id="questionId" />
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import Question from '../../components/questions/Question'
import Timeline from '../../components/questions/Timeline'
import HeaderDeleteRequest from '../../components/HeaderDeleteRequest'
import Page from '../../components/Page'

export default {
  name: 'ShowQuestion',
  components: { Page, Timeline, Question, HeaderDeleteRequest },
  data: () => ({
    question: null,
    questionFile: null,
    oldQuestionFile: null,
    revisions: [],
    evaluations: [],
    questionId: null
  }),
  created () {
    setTimeout(() => { this.getFile() }, 1500)
  },
  beforeRouteEnter (to, from, next) {
    const questionId = to.params.questionId
    QuestionService.findById(questionId)
      .then((question) => {
        next(vm => {
          vm.question = question
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
        })
        .catch(reason => {
          Messenger.showError(reason.message)
        })
        .finally(() => loader.hide())
    }
  }
}
</script>

<style scoped>

</style>
