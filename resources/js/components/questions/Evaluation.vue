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
