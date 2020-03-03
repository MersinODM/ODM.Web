<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <h4>
    {{ title }}
    <div
      v-if="isOwner"
      class="pull-right"
    >
      <button
        class="btn btn-danger pull-right"
        style="margin-right: 10px"
        @click="deleteRequest"
      >
        Silme Talep Et
      </button>
    </div>
  </h4>
</template>

<script>
import Messenger from '../helpers/messenger'
import QuestionService from '../services/QuestionService'
import AuthService from '../services/AuthService';

export default {
  name: 'HeaderDeleteRequestComponent',
  props: {
    title: {
      type: String,
      default: ''
    },
    question: {
      type: Object,
      default: Object
    }
  },
  computed: {
    isOwner () {
      if (this.question) {
        return ((this.question.creator_id === AuthService.getUserId() || this.$isInRole('admin')) && !this.question.has_delete_request)
      }
      return false
    }
  },
  methods: {
    deleteRequest () {
      Messenger.showInput('Soruyu neden silmek istiyorsunuz? Kısaca yazınız')
        .then(result => {
          if (result) {
            QuestionService.sendDeleteRequest(this.question.id, { reason: result })
              .then(resp => {
                Messenger.showInfoV2(resp.message)
                  .then(() => this.$router.go(-1))
              })
              .catch(err => Messenger.showError(err.message))
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
