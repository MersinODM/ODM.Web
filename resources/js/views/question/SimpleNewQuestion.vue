<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4 class="pull-left">
              Yeni Hızlı Soru Oluşturma
            </h4>
            <div class="pull-right">
              <label class="btn btn-success pull-right ">
                <input
                  ref="qFile"
                  v-validate="'required|size:1024'"
                  name="questionFile"
                  type="file"
                  style="display: none !important;"
                  accept="application/pdf"
                  @change="selectQuestionGraphic($event)"
                >Dosya seçiniz
              </label>
              <button
                class="btn btn-warning pull-right"
                style="margin-right: 10px"
                @click="clearSelection"
              >
                Temizle
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div
                  v-if="checkBranches"
                  class="form-group has-feedback"
                  :class="{'has-error': errors.has('branch')}"
                >
                  <label>Ders/Alan Seçimi</label>
                  <v-select
                    v-model="selectedBranch"
                    v-validate="'required'"
                    :options="branches"
                    :reduce="b => b.id"
                    label="name"
                    name="branch"
                    placeholder="Alan/Ders adının en az 3 harfini girin"
                    @input="clearClasses"
                  >
                    <div slot="no-options">
                      Burada bişey bulamadık :-(
                    </div>
                  </v-select>
                  <span
                    v-if="errors.has('branch')"
                    class="error invalid-feedback"
                  >{{ errors.first('branch') }}</span>
                  <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                  <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                </div>
                <div
                  class="form-group has-feedback"
                  :class="{'has-error': errors.has('selectedClassLevel')}"
                >
                  <label>Sınıf Seviyesi Seçimi</label>
                  <v-select
                    ref="classLevelDD"
                    v-model="selectedClassLevel"
                    v-validate="'required'"
                    :options="classLevels"
                    name="selectedClassLevel"
                    placeholder="Sınıf seviyesini seçiniz"
                    @input="clearLearningOutCome"
                  />
                  <span
                    v-if="errors.has('selectedClassLevel')"
                    class="error invalid-feedback"
                  >{{ errors.first('selectedClassLevel') }}</span>
                  <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                  <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                </div>
                <div
                  v-if="selectedClassLevel !== null"
                  class="form-group has-feedback"
                  :class="{'has-error': errors.has('learningOutCome')}"
                >
                  <label>Kazanım Seçimi</label>
                  <v-select
                    ref="loDD"
                    v-model="selectedLearningOutCome"
                    v-validate="'required'"
                    :options="learningOutComes"
                    :reduce="lo => lo.id"
                    label="content"
                    name="learningOutCome"
                    placeholder="Ara"
                    @search="searchLearningOutcomes"
                  >
                    <div slot="no-options">
                      Burada bişey bulamadık :-(
                    </div>
                    <template
                      slot="option"
                      slot-scope="option"
                    >
                      {{ option.code }} - {{ option.content }}
                    </template>
                    <template
                      slot="selected-option"
                      slot-scope="option"
                    >
                      {{ option.code }} - {{ option.content }}
                    </template>
                  </v-select>
                  <span
                    v-if="errors.has('learningOutCome')"
                    class="error invalid-feedback"
                  >{{ errors.first('learningOutCome') }}</span>
                  <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                  <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                </div>
                <div
                  v-if="selectedLearningOutCome !== null"
                  class="form-group has-feedback"
                  :class="{'has-error': errors.has('difficulty')}"
                >
                  <label>Zorluk Seviyesi Seçimi</label>
                  <v-select
                    v-model="selectedDifficulty"
                    v-validate="'required'"
                    :options="difficultyLevels"
                    :reduce="d => d.degree"
                    label="content"
                    name="difficulty"
                    placeholder="Zorluk seviyesini seçiniz"
                  />
                  <span
                    v-if="errors.has('difficulty')"
                    class="error invalid-feedback"
                  >{{ errors.first('difficulty') }}</span>
                  <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                  <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                </div>
                <div
                  v-if="selectedDifficulty !== null"
                  class="form-group has-feedback"
                  :class="{'has-error': errors.has('correctAnswer')}"
                >
                  <label>Doğru Cevap</label>
                  <v-select
                    v-model="selectedCorrectAnswer"
                    v-validate="'required'"
                    :options="answers"
                    name="correctAnswer"
                    placeholder="Doğru cevabı seçiniz"
                  />
                  <span
                    v-if="errors.has('correctAnswer')"
                    class="error invalid-feedback"
                  >{{ errors.first('correctAnswer') }}</span>
                  <!--          <input v-model="branch_id" type="text" class="form-control" placeholder="Branş Seçimi">-->
                  <!--          <span class="glyphicon glyphicon-barcode form-control-feedback"></span>-->
                </div>
                <div
                  v-if="selectedCorrectAnswer !== ''"
                  class="form-group"
                >
                  <label>Soru Kökü/Anahtar Kelimeler</label>
                  <textarea
                    class="form-control"
                    rows="3"
                    placeholder="Boşluk bırakarak anahtar kelimeler girebilirsiniz."
                    @model="keywords"
                  />
                </div>
                <div
                  v-if="selectedDifficulty !== null"
                  class="form-group has-feedback"
                >
                  <button
                    :class="{ disabled : errors.any() || isSending }"
                    class="btn btn-primary btn-block"
                    @click="save"
                  >
                    Kaydet
                  </button>
                </div>
              </div>
              <div class="col-md-9">
                <div
                  v-if="questionFile !== null && !errors.has('questionFile')"
                  class="row"
                >
                  <object
                    id="pdf"
                    height="600pt"
                    width="100%"
                    type="application/pdf"
                    :data="questionFileURL"
                  >
                    <span>PDF eklentisi bulunamadı.</span>
                  </object>
                </div>
                <div
                  v-if="errors.has('questionFile')"
                  class="row"
                >
                  <div class="text-center">
                    <span class="badge alert-error">{{ errors.first('questionFile') }}</span>
                  </div>
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

import debounce from 'lodash/debounce'
import range from 'lodash/range'
import vSelect from 'vue-select'
import QuestionService from '../../services/QuestionService'
import BranchService from '../../services/BranchService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import LearningOutcomesService from '../../services/LearningOutcomesService'
import UserService from '../../services/UserService'
import AuthService from '../../services/AuthService'

export default {
  name: 'SimpleNewQuestion',
  components: { vSelect },
  data () {
    return {
      selectedDifficulty: null,
      difficultyLevels: [
        { degree: 1, content: 'Çok Kolay' },
        { degree: 2, content: 'Kolay' },
        { degree: 3, content: 'Normal' },
        { degree: 4, content: 'Zor' },
        { degree: 5, content: 'Çok Zor' }
      ],

      selectedBranch: '',
      branches: [],

      questionFile: null,
      keywords: '',
      answers: ['A', 'B', 'C', 'D', 'E'],
      selectedCorrectAnswer: '',

      questionFileURL: null,
      selectedClassLevel: null,

      classLevels: range(4, 13),
      selectedLearningOutCome: null,
      learningOutComes: [],
      isSending: false,
      user: ''
    }
  },
  computed: {
    checkBranches () {
      if (this.user) {
        return this.$isInRole('admin') || this.user.branch.code === 'SB'
      }
      return false
    }
  },
  beforeRouteEnter (to, from, next) {
    Promise.all([BranchService.getBranches(), UserService.findById(AuthService.getUserId())])
      .then(([branches, user]) => {
        next(vm => {
          vm.user = user
          // Burada kullanıcı sosyal bilgiler öğretmeni ise
          // hem sosyal bilgilere hem de inklap tarihi dersine soru yazabilmeli
          if (!vm.$isInRole('admin') && user.branch.code === 'SB') {
            vm.branches = branches.filter(b => b.code === 'SB' || b.code === 'İTA')
          } else {
            vm.branches = branches
          }
        })
      })
      .catch(() => {
        Messenger.showError(MessengerConstants.errorMessage)
      })
  },
  methods: {
    clearClasses () {
      if (this.selectedClassLevel !== null) {
        this.selectedClassLevel = null
        this.$refs.classLevelDD.clearSelection()
      }
    },
    clearLearningOutCome () {
      if (this.selectedLearningOutCome !== null) {
        this.learningOutComes = []
        this.selectedLearningOutCome = null
        this.$refs.loDD.clearSelection()
      }
    },
    searchLearningOutcomes: debounce(function (search, loading) {
      if (search.length < 3) return
      loading(true)
      const data = {
        class_level: this.selectedClassLevel,
        content: search,
        lesson_id: this.selectedBranch
      }
      LearningOutcomesService.findByCodeOrContent(data)
        .then(value => {
          this.learningOutComes = value
          loading(false)
        })
        .catch(reason => {
          Messenger.showError(MessengerConstants.errorMessage)
          loading(false)
        })
        .finally(() => loading(false))
    }, 800),
    selectQuestionGraphic (event) {
      URL.revokeObjectURL(this.questionFileURL)
      this.questionFile = event.target.files[0]
      this.questionFileURL = URL.createObjectURL(event.target.files[0])
    },
    clearSelection () {
      this.questionFile = null
      URL.revokeObjectURL(this.questionFileURL)
      this.$validator.errors.remove('questionFile')
      this.$refs.qFile.value = null
    },
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            this.isSending = true
            const fd = new FormData()
            fd.append('lesson_id', this.selectedBranch)
            fd.append('learning_outcome_id', this.selectedLearningOutCome)
            fd.append('difficulty', this.selectedDifficulty)
            fd.append('keywords', this.keywords)
            fd.append('correct_answer', this.selectedCorrectAnswer)
            fd.append('question_file', this.questionFile, this.questionFile.name)
            QuestionService.save(fd, progress => {})
              .then(value => {
                this.isSending = false
                Messenger.showInfoV2('Soru kaydı başarılı')
                  .then(() => this.$router.push({ name: 'questionTableList' }))
              })
              .catch(reason => {
                this.isSending = false
                Messenger.showError()
              })
          }
        })
    }
  }
}
</script>

<style>

</style>
