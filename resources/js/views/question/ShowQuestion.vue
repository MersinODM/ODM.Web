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
              <div class="pull-right">
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
            <div class="row">
              <div class="col-md-12">
                <object
                  type="application/pdf"
                  :data="questionFileURL"
                  height="600pt"
                  style="width: 100%"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4 v-if="question != null">
                  <span style="font-weight: bold">Madde Kökü/Anahtar Kelimeler: </span>{{ question.keywords == null ?
                    'Girilmemiş' : question.keywords }}
                </h4>
                <h4 v-if="question !== null && $isInRole('admin')">
                  <span style="font-weight: bold">Soru yazarı: </span>{{ question.creator }}
                </h4>
                <h4 v-if="question != null">
                  <span style="font-weight: bold">Kazanım: </span>{{ question.learning_outcome }}
                </h4>
                <h4 v-if="question != null">
                  <span style="font-weight: bold">Sınıf seviyesi: </span>{{ question.class_level }} .Sınıf
                </h4>
                <h4 v-if="question != null">
                  <span style="font-weight: bold">Doğru Cevap: </span>{{ question.correct_answer }}
                </h4>
                <h4 v-if="question != null">
                  <span style="font-weight: bold">Zorluk Seviyesi: </span>{{ getDifficulty() }}
                </h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-offset-5 col-md-2">
                <button
                  v-if="!question.is_passed && !hasCommentRequest"
                  class="btn btn-warning btn-block"
                  @click="comment = ''"
                >
                  Revizyon Ekle
                </button>
              </div>
            </div>
            <transition
              enter-active-class="animated fadeIn"
              leave-active-class="animated fadeOut"
              mode="out-in"
            >
              <div
                v-if="hasCommentRequest"
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
                          :class="{'disabled': changeCount === 0}"
                          @click="cancel"
                        >
                          İptal Et
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </transition>
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
                v-for="(evaluation, index) in evaluationList"
                :key="evaluation.id"
                class="direct-chat-msg"
              >
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">Değerlendirici {{ index + 1 }}</span>
                  <span class="direct-chat-timestamp pull-right">{{ evaluation.date }}</span>
                </div>
                <img
                  class="direct-chat-img"
                  src="/otomasyon/images/users.png"
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
                  src="/otomasyon/images/users.png"
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
  import {MessengerConstants} from '../../helpers/constants'
  import RevisionService from '../../services/CommentService'
  import usersImg from '../../../images/users.png'
  import QuestionEvaluationService from '../../services/QuestionEvaluationService'

  export default {
  name: 'ShowQuestion',
  data () {
    return {
      question: null,
      questionFile: null,
      oldQuestionFile: null,
      questionFileURL: null,
      comment: null,
      changeCount: 0,
      revisions: [],
      evaluationList: [],
      userImage: usersImg,
      difficultyLevels: [
        { degree: 1, content: 'Çok Kolay' },
        { degree: 2, content: 'Kolay' },
        { degree: 3, content: 'Normal' },
        { degree: 4, content: 'Zor' },
        { degree: 5, content: 'Çok Zor' }
      ]
    }
  },
  computed: {
    hasCommentRequest () {
      return this.comment !== null
    },
    checkEvals () {
      return this.evaluationList !== null && this.evaluationList.length > 0
    }
  },
  beforeRouteEnter (to, from, next) {
    let questionId = to.params.questionId
    Promise.all([
      QuestionService.findById(questionId),
      QuestionService.getFile(questionId),
      RevisionService.getRevisions(questionId),
      QuestionEvaluationService.findByQuestionId(questionId)
    ]).then(([question, file, revisions, evalutaions]) => {
      next(vm => {
        vm.question = question
        vm.questionFileURL = file
        vm.revisions = revisions
        vm.evaluationList = evalutaions
      })
    })
  },
  watch: {
    questionFile: function (val) {
      this.changeCount++
      this.questionFileURL = URL.createObjectURL(val)
    }
  },
  methods: {
    getDifficulty () {
      return this.difficultyLevels.filter(diff => diff.degree === this.question.difficulty)[0].content
    },
    save () {
      this.$validator.validateAll()
              .then(value => {
                if (value) {
                  let msg = 'Gözden geçrimeniz ve yeni soru dosyanız kayıt edilecek.\n' +
                          'Eski soru dosyanıza ulaşamayacaksınız\n' +
                          'Kayıt işlemini onaylıyor musunuz?'
                  let promptButtons = {
                    cancel: 'İptal',
                    ok: {
                      text: 'Tamam',
                      value: true
                    }
                  }
                  Messenger.showPrompt(msg, promptButtons)
                           .then(promptRes => {
                             if (promptRes) {
                               let fd = new FormData()
                               fd.append('comment', this.comment)
                               fd.append('question_file', this.questionFile, this.questionFile.name)
                               RevisionService.save(this.$route.params.questionId, fd)
                                              .then(res => {
                                                Messenger.showSuccess('Gözden geçirme kaydı başarılı')
                                                this.getRevisions()
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
      if (this.changeCount !== 0) {
        this.comment = null
        URL.revokeObjectURL(this.questionFile)
        this.questionFileURL = this.oldQuestionFile
      }
    },
    getRevisions () {
      RevisionService.getRevisions(this.$route.params.questionId)
              .then((revisions) => { this.revisions = revisions })
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
