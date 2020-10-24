<!--
  - ODM.Web  https://github.com/electropsycho/ODM.Web
  - Copyright (C) 2020 Hakan GÜLEN
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU General Public License as published by
  - the Free Software Foundation, either version 3 of the License, or
  - (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU General Public License for more details.
  -
  - You should have received a copy of the GNU General Public License
  - along with this program.  If not, see http://www.gnu.org/licenses/
  -->

<template>
  <div
    v-if="isShow"
    class="row"
  >
    <spinner
      v-if="isLoading"
      spin-style="double_bounce"
    />
    <div
      class="col-md-12"
    >
      <div class="card">
        <div class="card-header">
          <h5>Olaylar</h5>
        </div>
        <div class="card-body">
          <div class="timeline">
            <div
              v-for="event in questionEvents"
              :key="event.id"
            >
              <i
                v-if="event.elector_id"
                class="fa fa-commenting-o bg-blue"
              />
              <i
                v-else
                class="fa fa-recycle bg-warning"
              />

              <div
                v-if="event.elector_id"
                class="timeline-item elevation-1"
              >
                <span class="time"><i class="fa fa-clock-o" /> {{ formatDate(event.date) }}</span>

                <h3 class="timeline-header">
                  <a href="javascript:"><b>{{ event.code }}</b> grubundan değerlendirme</a>
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
                class="timeline-item elevation-1"
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
            </div>
            <div v-if="questionEvents.length > 0">
              <i class="fa fa-clock-o bg-gray" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dayjs from '../../helpers/dayjs'
import QuestionEvaluationService from '../../services/QuestionEvaluationService'
import Messenger from '../../helpers/messenger'
import RevisionService from '../../services/CommentService'
import Spinner from '../Spinner'

export default {
  name: 'Timeline',
  components: { Spinner },
  props: {
    questionId: {
      type: Number,
      required: true,
      default: 0
    }
  },
  data: () => ({
    questionEvents: [],
    isLoading: false
  }),
  computed: {
    isShow () {
      return this.questionId > 0 && this.questionEvents.length > 0
    }
  },
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
      return dayjs(date).fromNow()
    }
  }
}
</script>

<style scoped>

</style>
