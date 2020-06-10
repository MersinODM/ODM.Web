<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <div class="row">
    <div class="col-sm-8">
      <slot />
    </div>
    <div class="col-sm-4">
      <div
        v-if="hasDeleteRequest"
        class="float-right"
      >
        <h2 class="label label-danger">
          Silme Talep Edilmiş
        </h2>
      </div>
      <div
        v-if="isOwner"
        class="float-right"
      >
        <button
          class="btn btn-danger float-right"
          style="margin-right: 10px"
          @click="deleteRequest"
        >
          Silme Talep Et
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Messenger from '../helpers/messenger'
import QuestionService from '../services/QuestionService'
import AuthService from '../services/AuthService'

export default {
  name: 'HeaderDeleteRequest',
  props: {
    question: {
      type: Object,
      default: Object
    }
  },
  computed: {
    isOwner () {
      if (this.question) {
        return ((this.question.creator_id === AuthService.getUserId() ||
          this.$isInRole('admin')) &&
          !this.question.has_delete_request)
      }
      return false
    },
    hasDeleteRequest () {
      if (this.question) {
        return this.question.has_delete_request
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
