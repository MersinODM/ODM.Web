<template>
  <div>
    <n-header></n-header>
    <n-sidebar></n-sidebar>
    <div class="content-wrapper" style="min-height: 0 !important;">
      <!-- Content Header (Page header) -->
      <!--<section class="content-header">-->
        <!--<h1>-->
          <!--Page Header-->
          <!--<small>Optional description</small>-->
        <!--</h1>-->
        <!--<ol class="breadcrumb">-->
          <!--<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>-->
          <!--<li class="active">Here</li>-->
        <!--</ol>-->
      <!--</section>-->

      <!-- Main content -->
      <section class="content container-fluid">

        <!--------------------------
          | Your Page Content Here |
          -------------------------->
        <!--<transition-->
          <!--name="custom-classes-transition"-->
          <!--enter-to-class="animated slideInLeft"-->
          <!--leave-to-class="animated slideOutRight"-->
        <!--&gt;-->
<!--        <keep-alive>-->
            <router-view></router-view>
<!--        </keep-alive>-->
        <!--</transition>-->
      </section>
      <!-- /.content -->
    </div>
    <n-footer></n-footer>
  </div>
</template>

<script>
import NHeader from './HeaderView'
import NSidebar from './MainSidebar'
import NFooter from './FooterView'

export default {
  name: 'DashBoard',
  components: { NFooter, NSidebar, NHeader },
  beforeCreate () {
    document.body.classList.remove('hold-transition', 'login-page', 'register-page')
    document.body.classList.add('skin-blue-light', 'sidebar-mini', 'wysihtml5-supported') // , 'fixed'
  },
  mounted () {
    $('body').resize()
  }
}
</script>
<style lang="sass">
  // @import "../../../../../node_modules/animate.css/animate.min.css"
</style>
