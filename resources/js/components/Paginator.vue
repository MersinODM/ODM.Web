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
      <ul class="pagination justify-content-center">
        <li class="paginate_button page-item previous">
          <a
            data-toggle="tooltip"
            data-placement="top"
            title="Tooltip on top"
            href="javascript: void(0)"
            class="page-link"
            :class="{disabled: isCurrentFirstPage}"
            @click="onFirst"
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
            v-model="localCurrentPage"
            type="number"
            class="page-link text-center"
            style="min-width:5em"
            :max="lastPage"
            :min="1"
            @input="onInput"
            @keydown.enter="onEnter"
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
            @click="onLast"
          >{{ lastPage }}</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Paginator',
  props: {
    currentPage: {
      type: Number,
      default: 1
    },
    lastPage: {
      type: Number,
      default: 0
    },
    isEnabled: {
      type: Boolean,
      default: true
    }
  },
  data: () => ({
    localCurrentPage: ''
  }),
  computed: {
    previousEnabled () {
      return this.currentPage > 1
    },
    nextEnabled () {
      return this.currentPage < this.lastPage
    },
    isCurrentFirstPage () {
      return this.currentPage === 1
    },
    isCurrentLastPage () {
      return this.currentPage === this.lastPage
    }
  },
  watch: {
    currentPage (newVal) {
      this.localCurrentPage = newVal
    }
  },
  created () {
    this.localCurrentPage = this.currentPage
  },
  methods: {
    onEnter () {
      if (this.localCurrentPage !== this.currentPage) {
        this.$emit('page-changed', this.localCurrentPage)
      }
    },
    onPrevious () {
      if (this.currentPage <= 0) return
      this.$emit('page-changed', this.currentPage - 1)
    },
    onNext () {
      if (this.currentPage >= this.lastPage) return
      this.$emit('page-changed', this.currentPage + 1)
    },
    onFirst () {
      this.$emit('page-changed', 1)
    },
    onLast () {
      this.$emit('page-changed', this.lastPage)
    },
    onInput (event) {
      const value = event.target.value
      if (Number(value) > this.lastPage) {
        this.localCurrentPage = this.lastPage
      } else if (Number(value) < 1) {
        this.localCurrentPage = 1
      } else {
        this.localCurrentPage = Number(value)
      }
    }
    // checkInput (event) {
    //   if (event.keyCode === 8 || event.keyCode === 46) return
    //   if (!/[0-9]/.test(event.key)) {
    //     event.preventDefault()
    //   }
    // }
  }
}
</script>

<style scoped>

</style>
