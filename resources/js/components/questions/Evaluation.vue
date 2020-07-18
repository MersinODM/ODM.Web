<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <EvaluationCalculation :question="question" />
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <evaluation-stat :question="question" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EvaluationStat from './EvaluationStat'
import EvaluationCalculation from './EvaluationCalculation'
export default {
  name: 'Evaluation',
  components: { EvaluationCalculation, EvaluationStat },
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
