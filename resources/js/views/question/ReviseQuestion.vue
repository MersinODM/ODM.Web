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
              title="Soru Revizyonu"
              :question="question"
            />
          </div>
          <div class="box-body">
            <div class="col-md-12">
              <question
                :question="question"
                :question-file="questionFileURL"
              />
            </div>
            <div
              v-if="checkRevisionRequest"
              class="row"
            >
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-offset-2 col-md-8">
                    <div
                      class="form-group has-feedback"
                      :class="{'has-error': errors.has('comment')}"
                    >
                      <label>Gözden geçirme metni</label>
                      <textarea
                        v-model="comment"
                        v-validate="'required'"
                        name="comment"
                        class="form-control"
                        style="max-width: 100%; min-width: 100%; min-height: 60px"
                        placeholder="Gözden geçirmenizi kısaca yazınız"
                      />
                      <span class="mdi mdi-comment form-control-feedback" />
                      <span
                        v-if="errors.has('comment')"
                        class="help-block"
                      >{{ errors.first('comment') }}</span>
                    </div>
                  </div>
                </div>
                <div
                  v-if="errors.has('questionFile')"
                  class="row"
                >
                  <div class="text-center">
                    <span class="badge alert-error">{{ errors.first('questionFile') }}</span>
                  </div>
                  <br>
                </div>
                <div class="row">
                  <div class="col-md-offset-2 col-md-8">
                    <div class="text-center">
                      <label class="btn btn-success">
                        <input
                          ref="qFile"
                          v-validate="'required|size:1024'"
                          name="questionFile"
                          type="file"
                          style="display: none !important;"
                          accept="application/pdf"
                          @change="selectFile($event)"
                        >Dosya seçiniz
                      </label>
                      <button
                        class="btn btn-primary"
                        @click="save"
                      >
                        Kaydet
                      </button>
                      <button
                        class="btn btn-danger"
                        @click="cancel"
                      >
                        İptal Et
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
    <timeline :question-id="questionId" />
  </section>
</template>

<script>
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import RevisionService from '../../services/CommentService'
import usersImg from '../../../images/users.png'
import moment from 'moment'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'
import Question from '../../components/questions/Question'
import HeaderDeleteRequest from '../../components/HeaderDeleteRequest'
import Timeline from '../../components/questions/Timeline'

export default {
  name: 'ShowQuestion',
  components: { Question, HeaderDeleteRequest, Timeline },
  data: () => ({
    moment: moment,
    question: null,
    questionFile: null,
    oldQuestionFile: null,
    questionFileURL: null,
    comment: null,
    changeCount: 0,
    userImage: usersImg,
    questionId: null
  }),
  computed: {
    checkRevisionRequest () {
      // Sorunun revizyon isteği var mı yok mu kontrol ediliyor
      if (this.question) {
        return this.question.status === QuestionStatuses.NEED_REVISION
      }
      return false
    }
  },
  watch: {
    questionFile: function (val) {
      this.changeCount++
      this.questionFileURL = URL.createObjectURL(val)
    }
  },
  created () {
    setTimeout(() => { this.getFile() }, 1500)
  },
  beforeRouteEnter (to, from, next) {
    const questionId = to.params.questionId
    QuestionService.findById(questionId)
      .then((question) => {
        next(vm => {
          vm.questionId = questionId
          vm.question = question
        })
      })
  },
  methods: {
    getFile () {
      const loader = this.$loading.show()
      QuestionService.getFile(this.$route.params.questionId)
        .then(value => {
          this.questionFileURL = value
          loader.hide()
        })
        .catch(reason => {
          loader.hide()
          Messenger.showError(reason.message)
        })
    },
    refreshQuestion () {
      this.questionId = this.$route.params.questionId
      QuestionService.findById(this.question.id)
        .then((question) => {
          this.question = question
        })
        .catch(reason => Messenger.showError(reason.message))
    },
    save () {
      this.$validator.validateAll()
        .then(value => {
          if (value) {
            const msg = 'Gözden geçrime metniniz ve yeni soru dosyanız kayıt edilecek.\n' +
                'Eski soru dosyanıza ulaşamayacaksınız\n' +
                'Kayıt işlemini onaylıyor musunuz?'
            const promptButtons = {
              cancel: 'İptal',
              ok: {
                text: 'Tamam',
                value: true
              }
            }
            Messenger.showPrompt(msg, promptButtons)
              .then(promptRes => {
                if (promptRes) {
                  const fd = new FormData()
                  fd.append('comment', this.comment)
                  fd.append('question_file', this.questionFile, this.questionFile.name)
                  RevisionService.save(this.$route.params.questionId, fd)
                    .then(res => {
                      Messenger.showSuccess('Gözden geçirme kaydı başarılı')
                      this.getRevisions()
                      this.refreshQuestion()
                    })
                    .catch(e => {
                      Messenger.showError(MessengerConstants.errorMessage)
                    })
                }
              })
          }
        })
    },
    selectFile ($event) {
      if (this.changeCount === 0) {
        this.oldQuestionFile = this.questionFileURL
      }
      URL.revokeObjectURL(this.questionFile)
      this.questionFile = $event.target.files[0]
    },
    cancel () {
      this.comment = null
      URL.revokeObjectURL(this.questionFile)
      this.questionFileURL = this.oldQuestionFile
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
                  .then(() => this.$router.go(-1))
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
