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
    <div class="col-md-10 col-sm-12">
      <slot />
    </div>
    <div class="col-md-2 col-sm-12">
      <h4
        v-if="hasDeleteRequest"
        class=" center-block float-right"
      >
        <span class="badge badge-danger">Silme Talep Edilmiş</span>
      </h4>
      <button
        v-if="isOwner"
        class="btn btn-danger btn-block float-right"
        style="margin-right: 10px"
        @click="deleteRequest"
      >
        Silme Talep Et
      </button>
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
          if (result.isConfirmed) {
            QuestionService.sendDeleteRequest(this.question.id, { reason: result.value })
              .then(resp => {
                Messenger.showInfo(resp.message)
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
