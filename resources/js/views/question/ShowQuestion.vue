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
          <evaluation
            v-if="canShowEvalMenus"
            :question="question"
          />
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
import Evaluation from '../../components/questions/Evaluation'
import { QuestionStatuses } from '../../helpers/QuestionStatuses'

export default {
  name: 'ShowQuestion',
  components: { Evaluation, Page, Timeline, Question, HeaderDeleteRequest },
  data: () => ({
    question: null,
    questionFile: null,
    oldQuestionFile: null,
    revisions: [],
    evaluations: [],
    questionId: null
  }),
  computed: {
    canShowEvalMenus () {
      return this.$isInRole('admin') &&
        this.question.status === QuestionStatuses.IN_ELECTION
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
