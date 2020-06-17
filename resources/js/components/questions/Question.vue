<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <div class="row">
    <div class="col-md 12">
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
          <h6 v-if="question != null">
            <span style="font-weight: bold">Madde Kökü/Anahtar Kelimeler: </span>{{ question.keywords == null ?
              'Girilmemiş' : question.keywords }}
          </h6>
          <h6 v-if="question !== null && $isInRole('admin')">
            <span style="font-weight: bold">Soru yazarı: </span>{{ question.creator }}
          </h6>
          <h6 v-if="question != null">
            <span style="font-weight: bold">Kazanım: </span>{{ question.learning_outcome }}
          </h6>
          <h6 v-if="question != null">
            <span style="font-weight: bold">Sınıf seviyesi: </span>{{ question.class_level }} .Sınıf
          </h6>
          <h6 v-if="question != null">
            <span style="font-weight: bold">Doğru Cevap: </span><span class="text-red text-bold">{{ question.correct_answer }}</span> Seçeneği
          </h6>
          <h6 v-if="question != null">
            <span style="font-weight: bold">Zorluk Seviyesi: </span>{{ getDifficulty() }}
          </h6>
          <h6 v-if="question != null">
            <span style="font-weight: bold">Tasarım ihtiyacı: </span>{{ question.is_design_required ? 'Var' : 'Yok' }}
          </h6>
          <h6 v-if="question != null">
            <span style="font-weight: bold">Durumu: </span>
            <span
              class="label"
              :class="getStatusClass"
            >{{ question.status_title }} </span>
          </h6>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { QuestionStatuses } from '../../helpers/QuestionStatuses'

export default {
  name: 'Question',
  props: ['question', 'questionFile'],
  data () {
    return {
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
    getStatusClass () {
      return {
        'label-danger': this.question.status === QuestionStatuses.NOT_MUST_ASKED,
        'label-info': this.question.status === QuestionStatuses.IN_ELECTION,
        'label-primary': this.question.status === QuestionStatuses.REVISION_COMPLETED,
        'label-warning': this.question.status === QuestionStatuses.NEED_REVISION,
        'label-success': this.question.status === QuestionStatuses.APPROVED,
        'label-default': this.question.status === QuestionStatuses.WAITING_FOR_ACTION
      }
    }
  },
  methods: {
    getDifficulty () {
      return this.difficultyLevels.filter(diff => diff.degree === this.question.difficulty)[0].content
    }
  }
}
</script>

<style scoped>

</style>
