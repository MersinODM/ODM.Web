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
import Constants from '../../helpers/constants'
import Messenger from "../../helpers/messenger";
export default {
  name: 'NHeader',
  data () {
    return {
      image: img,
      user: null,
      name: ''
    }
  },
  created () {
    this.getUser()
    // this.getSettings()
  },
  mounted () {
    $('[data-widget="pushmenu"]').PushMenu()
  },
  methods: {
    logout () {
      Auth.logout()
    }
  }
}
</script>

<style lang="sass">

</style>
