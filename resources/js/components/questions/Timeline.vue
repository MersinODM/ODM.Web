<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <div class="row">
    <spinner
      v-if="isLoading"
      spin-style="double_bounce"
    />
    <div
      v-if="questionId !== '' && Number(questionId) > 0"
      class="col-md-12"
    >
      <ul class="timeline">
        <li v-for="event in questionEvents">
          <i
            v-if="event.elector_id"
            class="fa fa-commenting-o bg-blue"
          />
          <i
            v-else
            class="fa fa-recycle bg-orange"
          />

          <div
            v-if="event.elector_id"
            class="timeline-item"
          >
            <span class="time"><i class="fa fa-clock-o" /> {{ formatDate(event.date) }}</span>

            <h3 class="timeline-header">
              <a href="javascript:">Değerlendirici Grup Kodu: {{ event.code }}</a>
            </h3>

            <div class="timeline-body">
              {{ event.comment }}
            </div>
            <div class="timeline-footer">
              Değerlendirme Tarihi <span class="label label-primary">{{ event.date | trDate }}</span>
            </div>
          </div>
          <div
            v-else
            class="timeline-item"
          >
            <span class="time"><i class="fa fa-clock-o" /> {{ formatDate(event.date) }}</span>

            <h3 class="timeline-header">
              <a href="javascript:">Revizyon</a>
            </h3>

            <div class="timeline-body">
              {{ event.comment }}
            </div>
            <div class="timeline-footer">
              Revizyon Tarihi <span class="label label-warning">{{ event.date | trDate }}</span>
            </div>
          </div>
        </li>
        <li v-if="questionEvents.length > 0">
          <i class="fa fa-clock-o bg-gray" />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import userImage from '../../../images/users.png'
import moment from 'moment'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import Messenger from '../../helpers/messenger'
import RevisionService from '../../services/CommentService'
import Spinner from '../Spinner'

export default {
  name: 'Timeline',
  components: { Spinner },
  props: ['questionId'],
  data: () => ({
    userImage: userImage,
    questionEvents: [],
    isLoading: false
  }),
  watch: {
    questionId () {
      this.getAllQuestionEvents()
    }
  },
  methods: {
    getAllQuestionEvents () {
      this.isLoading = true
      Promise.all([
        QuestionEvaluationService.findByQuestionId(this.questionId),
        RevisionService.getRevisions(this.questionId)
      ])
        .then(([evaluationList, revisions]) => {
          // const eventList = []
          this.questionEvents = revisions.concat(evaluationList.filter(q => q.point !== null && q.point > 0))
          this.sortByDate()
          // this.filteredEvalList = evaluationList.filter(q => q.point !== null && q.point > 0)
          // this.revisions = revisions
          this.isLoading = false
        })
        .catch((e) => {
          Messenger.showError('Revizyonlar/Değerlendirme listesi yüklenemedi!')
          this.isLoading = false
          console.log(e)
        })
    },
    sortByDate () {
      this.questionEvents = this.questionEvents
        .sort(function (a, b) {
          return new Date(b.date) - new Date(a.date)
        })
    },
    formatDate (date) {
      return moment(date).fromNow()
    }
  }
}
</script>

<style scoped>

</style>
