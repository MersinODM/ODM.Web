<template>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul
        class="sidebar-menu tree"
        data-widget="tree"
      >
        <li class="header">
          <strong>MENÜ</strong>
        </li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview">
          <a href="#"><i class="mdi mdi-account-question" />
            <span>Soru Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'questionList' }">
                <span class="mdi mdi-book-multiple" />
                Soruları Listele
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'newQuestion' }">
                <span class="mdi mdi-book-plus" />
                Soru Oluştur
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="$isInRole('admin')"
          class="treeview"
        >
          <a href="#"><i class="mdi mdi-book-open-variant" />
            <span>Sınav Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a><span class="mdi mdi-book-multiple" />
                Sınavları Listele
              </a>
            </li>
            <li>
              <router-link :to="{name: 'home' }">
                <span class="mdi mdi-book-plus" />
                Sınav Oluştur
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="$isInRole('admin')"
          class="treeview"
        >
          <a href="#"><i class="mdi mdi-account-settings" />
            <span>Branş/Ders Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'branchList' }">
                <!-- Add a Font Awesome icon -->
                <span class="mdi mdi-briefcase-search" />
                Dersleri Listele
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'newBranch' }">
                <span class="mdi mdi-briefcase-plus" />
                Ders Ekle
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="$isInRole('admin')"
          class="treeview"
        >
          <a href="#"><i class="mdi mdi-matrix" />
            <span>Kazanım Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a>
                <!-- Add a Font Awesome icon -->
                <span class="mdi mdi-math-sin" />
                Kazanım Listele
              </a>
            </li>
            <li>
              <router-link :to="{name: 'newLO' }">
                <span class="mdi mdi-math-cos" />
                Kazanım Ekle
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="$isInRole('admin')"
          class="treeview"
        >
          <a href="#"><i class="mdi mdi-account-settings" />
            <span>Kullanıcı Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'users' }">
                <!-- Add a Font Awesome icon -->
                <span class="mdi mdi-account-group" />
                Kullanıcıları Listele
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'home' }">
                <span class="mdi mdi-account-plus" />
                Kullanıcı Ekle
              </router-link>
            </li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
export default {
  name: 'NMainSidebar',
  mounted () {
    $('ul').tree()
  }
}
</script>

<style>

</style>
