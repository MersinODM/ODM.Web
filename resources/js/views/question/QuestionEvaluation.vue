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
              <div class="row">
                <div class="col-md-12">
                  <object
                    type="application/pdf"
                    :data="questionFile"
                    height="600pt"
                    style="width: 100%"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h5 style="font-weight: bold">
                    Madde Kökü/Anahtar Kelimeler
                  </h5>
                  <p
                    v-if="question != null"
                    v-html="question.keywords"
                  />
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
                <div class="col-md-offset-4 col-md-4">
                  <div
                    class="form-group has-feedback"
                    :class="{'has-error': errors.has('point')}"
                  >
                    <label>Değerlendirme Puanı</label>
                    <v-select
                      v-model="point"
                      v-validate="'required'"
                      :options="points"
                      :reduce="p => p.key"
                      label="title"
                      name="difficulty"
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
                      v-if="errors.has('point')"
                      class="help-block"
                    >{{ errors.first('point') }}</span>
                    <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                    <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                  </div>
                  <div class="form-group has-feedback">
                    <textarea
                      v-model="comment"
                      class="form-control"
                      style="max-width: 100%; min-width: 100%; min-height: 60px"
                      placeholder="Değerlendirmenizi kısaca açıklayınız."
                    />
                    <span class="glyphicon glyphicon-magnet form-control-feedback" />
                  </div>
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
    <div
      v-show="evaluationList !== null && evaluationList.length > 0"
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
  </section>
</template>

<script>
import vSelect from 'vue-select'
import QuestionService from '../../services/QuestionService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import usersImg from '../../../images/users.png'

export default {
  name: 'QuestionEvaluation',
  components: { vSelect },
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
      evaluationList: [],
      userImage: usersImg
    }
  },
  beforeRouteEnter (to, from, next) {
    let questionId = to.params.questionId
    QuestionService.findById(questionId)
                     .then((res) => {
                       next(vm => {
                         vm.question = res
                         vm.getFile()
                         vm.getEvals()
                       })
                     })
  },
  methods: {
    getFile () {
      QuestionService.getFile(this.question.id)
                     .then((res) => { this.questionFile = res })
                     .catch(error => {
                       Messenger.showError(MessengerConstants.errorMessage)
                       console.log(error)
                     })
    },
    getEvals () {
      QuestionEvaluationService.findByQuestionId(this.question.id)
                               .then(qeList => { this.evaluationList = qeList })
                               .catch(() => Messenger.showError(MessengerConstants.errorMessage))
    },
    saveEval () {
      let data = { point: this.point, comment: this.comment }
      QuestionEvaluationService.save(this.question.id, data)
                               .then(res => {
                                 Messenger.showInfo(res.message)
                                 if (res.eval_count > 0) {
                                   this.getEvals()
                                 }
                               })
                               .catch(() => { Messenger.showError(Messenger.showError(MessengerConstants.errorMessage)) })
    }
  }
}
</script>

<style scoped>

</style>
