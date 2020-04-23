<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
  -  geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

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
            <span>Ana Sayfa & İstatistikler</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'stats' }">
                <span class="mdi mdi-book-multiple" />
                Ana Sayfa
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'underConstruction' }">
                <span class="mdi mdi-book-plus" />
                Kazanım/Soru Sayılarını İncele
              </router-link>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="mdi mdi-account-question" />
            <span>Soru Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'questionTableList' }">
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
            <li v-if="$isInRole('admin') || $isInRole('elector')">
              <router-link :to="{name: 'questionEvaluationRequests' }">
                <span class="mdi mdi-test-tube" />
                Soru Değerlendirme İstekleri
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'questionDeleteRequests' }">
                <span class="mdi mdi-delete-restore" />
                Soru Silme İstekleri
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
              <router-link :to="{name: 'underConstruction' }">
                <span class="mdi mdi-book-multiple" />
                Sınavları Listele
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'underConstruction' }">
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
              <router-link :to="{name: 'loList' }">
                <span class="mdi mdi-format-list-checkbox" />
                Kazanım Listele
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'newLO' }">
                <span class="mdi mdi-math-integral" />
                Kazanım Ekle
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="$isInRole('admin')"
          class="treeview"
        >
          <a href="#"><i class="mdi mdi-school" />
            <span>Kurum Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'newInst' }">
                <span class="mdi mdi-bank-plus" />
                Okul/Kurum Ekle
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
              <router-link :to="{name: 'passiveUsers' }">
                <span class="mdi mdi-table-row-remove" />
                Pasif Kull. Listele
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="$isInRole('admin')"
          class="treeview"
        >
          <a href="#"><i class="mdi mdi-account-settings" />
            <span>Uygulama Yönetimi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" />
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link :to="{name: 'mailSync' }">
                <!-- Add a Font Awesome icon -->
                <span class="mdi mdi-mailbox-open" />
                Mail Senkronizasyonu
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'appSettings' }">
                <!-- Add a Font Awesome icon -->
                <span class="mdi mdi-settings-box" />
                Uygulama Ayarları
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
