<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
  -  geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a
      href="#"
      class="brand-link"
    >
      <img
        :src="userImg"
        alt="Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: .8"
      >
      <span class="brand-text font-weight-light">{{ name }} ÖDM</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a
            href="javascript:0;"
            class="d-block"
          >dfgdfg</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar nav-child-indent flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="true"
        >
          <!-- Optionally, you can add icons to the links -->
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Ana Sayfa & İstatistikler
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'stats' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Ana Sayfa</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'underConstruction' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-plus" />
                  <p>Kazanım/Soru Sayılarını İncele</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Soru Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'questionTableList' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Soruları Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'newQuestion' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-plus" />
                  <p>Soru Oluştur</p>
                </router-link>
              </li>
              <li
                v-if="$isInRole('admin') || $isInRole('elector')"
                class="nav-item"
              >
                <router-link
                  :to="{name: 'questionEvaluationRequests' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-test-tube" />
                  <p>Soru Değerlendirme İstekleri</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'questionDeleteRequests' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-delete-restore" />
                  <p>Soru Silme İstekleri</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            v-if="$isInRole('admin')"
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-book-open-variant" />
              <p>Sınav Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'underConstruction' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Sınavları Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'underConstruction' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-plus" />
                  <p>Sınav Oluştur</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            v-if="$isInRole('admin')"
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-settings" />
              <p>Branş/Ders Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'branchList' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-briefcase-search" />
                  <p>Dersleri Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'newBranch' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-briefcase-plus" />
                  <p>Ders Ekle</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            v-if="$isInRole('admin')"
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-matrix" />
              <p>Kazanım Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'loList' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-format-list-checkbox" />
                  <p>Kazanım Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'newLO' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-math-integral" />
                  <p>Kazanım Ekle</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            v-if="$isInRole('admin')"
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-school" />
              <p>Kurum Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{ name: 'institutions' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-bank" />
                  <p>Okul/Kurum Listesi</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{ name: 'newInst' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-bank-plus" />
                  <p>Okul/Kurum Ekle</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            v-if="$isInRole('admin')"
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-settings" />
              <p>Kullanıcı Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'users' }"
                  class="nav-link"
                >
                  <!-- Add a Font Awesome icon -->
                  <i class="mdi mdi-account-group" />
                  <p>Kullanıcıları Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: 'passiveUsers' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-table-row-remove" />
                  <p>Pasif Kull. Listele</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            v-if="$isInRole('admin')"
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-cogs" />
              <p>Uygulama Yönetimi
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'appSettings' }"
                  class="nav-link"
                >
                  <!-- Add a Font Awesome icon -->
                  <i class="mdi mdi-settings-box" />
                  <p>Uygulama Ayarları</p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>

import img from '../../../images/Logo.png'
import Constants from '../../helpers/constants'

export default {
  name: 'NMainSidebar',
  data: () => ({
    userImg: img,
    name: ''
  }),
  mounted () {
    $('ul').Treeview()
  },
  methods: {
    getSettings () {
      this.name = JSON.parse(localStorage.getItem(Constants.generalInfo)).city
    }
  }
}
</script>

<style>

</style>
