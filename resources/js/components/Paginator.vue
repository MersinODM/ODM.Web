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
      <ul class="pagination justify-content-center mb-0">
        <li class="paginate_button page-item previous">
          <a
            href="javascript: void(0)"
            class="page-link"
            :class="{disabled: isCurrentFirstPage}"
          >1</a>
        </li>
        <li class="paginate_button page-item previous">
          <a
            href="javascript: void(0)"
            class="page-link"
            :class="{disabled: !previousEnabled}"
            @click="onPrevious"
          ><</a>
        </li>
        <li class="paginate_button page-item">
          <input
            v-model="currentPage"
            type="text"
            class="page-link text-center"
            style="width:3.2em"
            :class="{disabled: isCurrentLastPage}"
            @keydown="checkInput"
          >
        </li>
        <li class="paginate_button page-item next">
          <a
            href="javascript: void(0)"
            class="page-link"
            :class="{disabled: !nextEnabled}"
            @click="onNext"
          >></a>
        </li>
        <li class="paginate_button page-item next">
          <a
            href="javascript: void(0)"
            class="page-link"
            :class="{disabled: isCurrentLastPage}"
          >{{ totalPages }}</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Paginator',
  computed: {
    ...mapGetters('learningOutcome', {
      totalPages: 'totalPages',
      perPage: 'perPage',
      from: 'from',
      to: 'to'
    }),
    currentPage: {
      get () {
        return this.$store.getters['learningOutcome/currentPage']
      },
      set (value) {
        if (value > 0 && value <= this.totalPages) { this.setCurrentPage(Number(value)) }
      }
    },
    previousEnabled () {
      return this.currentPage > 1
    },
    nextEnabled () {
      return this.currentPage < this.totalPages
    },
    isCurrentFirstPage () {
      return this.currentPage === 1
    },
    isCurrentLastPage () {
      return this.currentPage === this.totalPages
    }
  },
  methods: {
    ...mapActions('learningOutcome', {
      setCurrentPage: 'setCurrentPage'
    }),
    onPrevious () {
      if (this.currentPage <= 0) return
      this.setCurrentPage(this.currentPage - 1)
    },
    onNext () {
      if (this.currentPage >= this.totalPages) return
      this.setCurrentPage(this.currentPage + 1)
    },
    checkInput (event) {
      if (event.keyCode === 8 || event.keyCode === 46) return
      if (!/[0-9]/.test(event.key)) {
        event.preventDefault()
      }
    },
    checkValue (event) {
      if (this.currentPage >= this.totalPages) {
        event.preventDefault()
        this.setCurrentPage(this.totalPages)
      }
    }
  }
}
</script>

<style scoped>

</style>
