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
  <nav class="main-header navbar navbar-expand navbar-white navbar-light elevation-1">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a
          class="nav-link"
          data-widget="pushmenu"
          href="#"
          role="button"
        ><i class="fas fa-bars" />
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a
          class="nav-link"
          role="button"
          @click="logout"
        >
          <i class="mdi mdi-logout" /></a>
      </li>
    </ul>
  </nav>
</template>

<script>
import Auth from '../../services/AuthService'
import img from '../../../images/Logo.png'
import Messenger from '../../helpers/messenger'

export default {
  name: 'NHeader',
  data: () => ({
    image: img,
    user: null,
    name: ''
  }),
  mounted () {
    $('[data-widget="pushmenu"]').PushMenu()
  },
  methods: {
    logout () {
      Messenger.showPrompt('Oturumu kapatmak istediğinizden emin misiniz?')
        .then(value => {
          if (value.isConfirmed) {
            Auth.logout()
          }
        })
    }
  }
}
</script>

<style lang="sass">

</style>
