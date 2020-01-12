<template>
  <header class="main-header">
    <!-- Logo -->
    <router-link
      class="logo"
      :to="{name: 'stats' }"
    >
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span
        class="logo-mini"
        style="font-size:small"
      ><b>{{ name[0] }}</b>ÖDM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ name }}</b>ÖDM</span>
    </router-link>

    <!-- Header Navbar -->
    <nav
      class="navbar navbar-static-top"
      role="navigation"
    >
      <!-- Sidebar toggle button-->
      <a
        href="#"
        class="sidebar-toggle"
        data-toggle="push-menu"
        role="button"
      >
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!--          <li class="dropdown messages-menu">-->
          <!--            &lt;!&ndash; Menu toggle button &ndash;&gt;-->
          <!--            <a-->
          <!--              href="#"-->
          <!--              class="dropdown-toggle"-->
          <!--              data-toggle="dropdown"-->
          <!--            >-->
          <!--              <i class="fa fa-envelope-o" />-->
          <!--              <span class="label label-success">4</span>-->
          <!--            </a>-->
          <!--            <ul class="dropdown-menu">-->
          <!--              <li class="header">-->
          <!--                You have 4 messages-->
          <!--              </li>-->
          <!--              <li>-->
          <!--                &lt;!&ndash; inner menu: contains the messages &ndash;&gt;-->
          <!--                <ul class="menu">-->
          <!--                  <li>-->
          <!--                    &lt;!&ndash; start message &ndash;&gt;-->
          <!--                    <a href="#">-->
          <!--                      <div class="pull-left">-->
          <!--                        &lt;!&ndash; User Image &ndash;&gt;-->
          <!--                        <img :src="image"-->
          <!--                          class="img-circle"-->
          <!--                          alt="User Image"-->
          <!--                        >-->
          <!--                      </div>-->
          <!--                      &lt;!&ndash; Message title and timestamp &ndash;&gt;-->
          <!--                      <h4>-->
          <!--                        Support Team-->
          <!--                        <small><i class="fa fa-clock-o" /> 5 mins</small>-->
          <!--                      </h4>-->
          <!--                      &lt;!&ndash; The message &ndash;&gt;-->
          <!--                      <p>Why not buy a new awesome theme?</p>-->
          <!--                    </a>-->
          <!--                  </li>-->
          <!--                  &lt;!&ndash; end message &ndash;&gt;-->
          <!--                </ul>-->
          <!--                &lt;!&ndash; /.menu &ndash;&gt;-->
          <!--              </li>-->
          <!--              <li class="footer">-->
          <!--                <a href="#">See All Messages</a>-->
          <!--              </li>-->
          <!--            </ul>-->
          <!--          </li>-->
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <!--          <li class="dropdown notifications-menu">-->
          <!--            &lt;!&ndash; Menu toggle button &ndash;&gt;-->
          <!--            <a-->
          <!--              href="#"-->
          <!--              class="dropdown-toggle"-->
          <!--              data-toggle="dropdown"-->
          <!--            >-->
          <!--              <i class="fa fa-bell-o" />-->
          <!--              <span class="label label-warning">10</span>-->
          <!--            </a>-->
          <!--            <ul class="dropdown-menu">-->
          <!--              <li class="header">-->
          <!--                You have 10 notifications-->
          <!--              </li>-->
          <!--              <li>-->
          <!--                &lt;!&ndash; Inner Menu: contains the notifications &ndash;&gt;-->
          <!--                <ul class="menu">-->
          <!--                  <li>-->
          <!--                    &lt;!&ndash; start notification &ndash;&gt;-->
          <!--                    <a href="#">-->
          <!--                      <i class="fa fa-users text-aqua" /> 5 new members joined today-->
          <!--                    </a>-->
          <!--                  </li>-->
          <!--                  &lt;!&ndash; end notification &ndash;&gt;-->
          <!--                </ul>-->
          <!--              </li>-->
          <!--              <li class="footer">-->
          <!--                <a href="#">View all</a>-->
          <!--              </li>-->
          <!--            </ul>-->
          <!--          </li>-->
          <!-- Tasks Menu -->
          <!--          <li class="dropdown tasks-menu">-->
          <!--            &lt;!&ndash; Menu Toggle Button &ndash;&gt;-->
          <!--            <a-->
          <!--              href="#"-->
          <!--              class="dropdown-toggle"-->
          <!--              data-toggle="dropdown"-->
          <!--            >-->
          <!--              <i class="fa fa-flag-o" />-->
          <!--              <span class="label label-danger">9</span>-->
          <!--            </a>-->
          <!--            <ul class="dropdown-menu">-->
          <!--              <li class="header">-->
          <!--                You have 9 tasks-->
          <!--              </li>-->
          <!--              <li>-->
          <!--                &lt;!&ndash; Inner menu: contains the tasks &ndash;&gt;-->
          <!--                <ul class="menu">-->
          <!--                  <li>-->
          <!--                    &lt;!&ndash; Task item &ndash;&gt;-->
          <!--                    <a href="#">-->
          <!--                      &lt;!&ndash; Task title and progress text &ndash;&gt;-->
          <!--                      <h3>-->
          <!--                        Design some buttons-->
          <!--                        <small class="pull-right">20%</small>-->
          <!--                      </h3>-->
          <!--                      &lt;!&ndash; The progress bar &ndash;&gt;-->
          <!--                      <div class="progress xs">-->
          <!--                        &lt;!&ndash; Change the css width attribute to simulate progress &ndash;&gt;-->
          <!--                        <div-->
          <!--                          class="progress-bar progress-bar-aqua"-->
          <!--                          style="width: 20%"-->
          <!--                          role="progressbar"-->
          <!--                          aria-valuenow="20"-->
          <!--                          aria-valuemin="0"-->
          <!--                          aria-valuemax="100"-->
          <!--                        >-->
          <!--                          <span class="sr-only">20% Complete</span>-->
          <!--                        </div>-->
          <!--                      </div>-->
          <!--                    </a>-->
          <!--                  </li>-->
          <!--                  &lt;!&ndash; end task item &ndash;&gt;-->
          <!--                </ul>-->
          <!--              </li>-->
          <!--              <li class="footer">-->
          <!--                <a href="#">View all tasks</a>-->
          <!--              </li>-->
          <!--            </ul>-->
          <!--          </li>-->
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a
              href="#"
              class="dropdown-toggle"
              data-toggle="dropdown"
            >
              <!-- The user image in the navbar-->
              <img
                :src="image"
                class="user-image"
                alt="User Image"
              >
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ user ? user.full_name : '' }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img
                  :src="image"
                  class="img-circle"
                  alt="User Image"
                >

                <p>
                  {{ user ? user.full_name : '' }}
                  <small>Üyelik yılı {{ user ? user.created_at : '' | year }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <router-link
                    :to="{name: 'underConstruction' }"
                    href="#"
                    class="btn btn-default btn-flat"
                  >
                    Ayarlarım
                  </router-link>
                </div>
                <div class="pull-right">
                  <a
                    href="#"
                    class="btn btn-default btn-flat"
                    @click="logout"
                  >Oturumu Kapat</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
import Auth from '../../services/AuthService'
import img from '../../../images/Logo.png'
import { SettingService } from '../../services/SettingService'
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
    this.getSettings()
  },
  methods: {
    logout () {
      Auth.logout()
    },
    getUser () {
      Auth.getUser((err, user) => {
        // console.log('Before' + user)
        this.setUser(err, user)
      })
    },
    getSettings () {
      this.name = JSON.parse(localStorage.getItem('settings')).city
    },
    setUser (err, user) {
      if (err) {
        this.error = err.toString()
      } else {
        this.user = user
      }
    }
  }
}
</script>

<style lang="sass">

</style>
