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
  <div class="wrapper">
    <n-header />
    <n-sidebar />
    <div
      class="content-wrapper"
      style="min-height: 0 !important;"
    >
      <router-view />
    </div>
    <n-footer />
    <div
      id="sidebar-overlay"
      @click="toggleSidebar"
    />
  </div>
</template>

<script>
import NHeader from './HeaderView'
import NSidebar from './MainSidebar'
import NFooter from './FooterView'
import SkinHelper from '../../helpers/SkinHelper'

export default {
  name: 'DashBoard',
  components: { NFooter, NSidebar, NHeader },
  beforeCreate () {
    SkinHelper.MainSkin()
  },
  methods: {
    toggleSidebar () {
      $('[data-widget="pushmenu"]').PushMenu('toggle')
    }
  }
}
</script>
<style lang="sass">
  // @import "../../../../../node_modules/animate.css/animate.min.css"
</style>
