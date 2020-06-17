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
