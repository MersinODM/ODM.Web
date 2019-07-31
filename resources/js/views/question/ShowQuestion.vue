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
              Soru İnceleme<button class="btn btn-danger pull-right">
                Silme Talep Et
              </button>
            </h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <img
                  :src="image"
                  class="img-responsive"
                  style="width: 100%"
                >
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h5 style="font-weight: bold">
                  Madde Kökü/Anahtar Kelimeler
                </h5>
                <p
                  v-if="question != null"
                  v-html="question.item_root"
                />
                <h5 style="font-weight: bold">
                  Soru yazarı
                </h5>
                <p v-if="question != null">
                  {{ question.creator }}
                </p>
                <h5 style="font-weight: bold">
                  Kazanım
                </h5>
                <p v-if="question != null">
                  {{ question.learning_outcome }}
                </p>
                <h5 style="font-weight: bold">
                  Sınıf seviyesi
                </h5>
                <p v-if="question != null">
                  {{ question.class_level }}
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-offset-5 col-md-2">
                <button
                  v-if="!hasCommentRequest"
                  class="btn btn-warning btn-block"
                  @click="comment = ''"
                >
                  Düzeltme Öner
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
                  <label>Düzeltme metni</label>
                  <div class="row">
                    <div class="col-md-10">
                      <div class="form-group has-feedback">
                        <textarea
                          v-model="comment"
                          class="form-control"
                          style="max-width: 100%; min-width: 100%; min-height: 60px"
                          placeholder="Önerinizi yazınız"
                        />
                        <span class="glyphicon glyphicon-magnet form-control-feedback" />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button
                        class="btn btn-primary btn-block btn-sm"
                        @click="saveComment"
                      >
                        Kaydet
                      </button>
                      <button
                        class="btn btn-danger btn-block btn-sm"
                        @click="comment = null"
                      >
                        İptal Et
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import CommentService from '../../services/CommentService'

export default {
  name: 'ShowQuestion',
  data () {
    return {
      question: null,
      image: null,
      comment: null
    }
  },
  computed: {
    hasCommentRequest () {
      return this.comment !== null
    }
  },
  beforeRouteEnter (to, from, next) {
    let questionId = to.params.questionId
    QuestionService.findById(questionId)
      .then((res) => {
        next(vm => {
          vm.question = res
          vm.getFile()
        })
      })
  },
  methods: {
    saveComment () {
      let suggestion = {
        questionId: this.$route.params.questionId,
        comment: this.comment
      }
      CommentService.save(suggestion)
        .then(res => {
          Messenger.showSuccess('Yorum kaydı başarılı')
          this.getComments()
          console.log(res)
        })
        .catch(e => {
          Messenger.showError(MessengerConstants.errorMessage)
        })
    },
    getComments () {
      CommentService.getComments(this.$route.params.questionId)
    },
    getFile () {
      QuestionService.getFile(this.question.id)
        .then((res) => {
          this.image = res
        }).catch(error => {
          Messenger.showError(MessengerConstants.errorMessage)
          console.log(error)
        })
    }
  }
}
</script>

<style scoped>

</style>
