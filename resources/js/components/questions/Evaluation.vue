<!--
  - ODM.Web  https://github.com/electropsycho/ODM.Web
  - Copyright 2019-2020 Hakan GÜLEN
  -
  - Licensed under the Apache License, Version 2.0 (the "License");
  - you may not use this file except in compliance with the License.
  - You may obtain a copy of the License at
  -
  - http://www.apache.org/licenses/LICENSE-2.0
  -
  - Unless required by applicable law or agreed to in writing, software
  - distributed under the License is distributed on an "AS IS" BASIS,
  - WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  - See the License for the specific language governing permissions and
  - limitations under the License.
  -->

<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <EvaluationCalculation :question="question" />
        </div>
      </div>
      <!--      <div class="row">-->
      <!--        <div class="col-md-12">-->
      <!--          <evaluation-stat :question="question" />-->
      <!--        </div>-->
      <!--      </div>-->
    </div>
  </div>
</template>

<script>
// import EvaluationStat from './EvaluationStat'
import EvaluationCalculation from './EvaluationCalculation'
export default {
  name: 'Evaluation',
  // components: { EvaluationCalculation, EvaluationStat },
  components: { EvaluationCalculation },
  props: ['question'],
  data: () => ({
    isShowingStats: false,
    isShowingManualCalculation: false
  }),
  methods: {
    showEvaluationStats () {

    },
    showManuelCalculation () {

    }
  }
}
</script>

<style scoped>

</style>
