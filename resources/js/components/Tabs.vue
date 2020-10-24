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
  <div class="card card-primary card-outline card-tabs">
    <div class="card-header p-0 pt-1 border-bottom-0">
      <ul class="nav nav-tabs">
        <li
          v-for="(tab, index) in tabs"
          :key="tab.title"
          class="nav-item"
          @click="selectTab(index)"
        >
          <a
            href="javascript: void(0)"
            class="nav-link"
            :class="{active: tab.isActive}"
          >{{ tab.title }}</a>
        </li>
      </ul>
      <div class="card-body">
        <div class="tab-content">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Tabs',
  data: () => ({
    selectedIndex: 0,
    tabs: []
  }),
  created () {
    this.tabs = this.$children
  },
  mounted () {
    this.selectTab(0)
  },
  methods: {
    selectTab (index) {
      this.selectedIndex = index
      this.tabs.forEach((tab, i) => {
        tab.isActive = (i === index)
      })
    }
  }

}
</script>

<style scoped>

</style>
