<template>
  <header class="main-header">
    <!-- Logo -->
    <a
      href=""
      class="logo"
    >
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span
        class="logo-mini"
        style="font-size:small"
      ><b>N</b>ÖDM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Nevşehir</b>ÖDM</span>
    </a>

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
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a
              href="#"
              class="dropdown-toggle"
              data-toggle="dropdown"
            >
              <i class="fa fa-envelope-o" />
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                You have 4 messages
              </li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                  <li>
                    <!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <!-- User Image -->
                        <img :src="image"
                          class="img-circle"
                          alt="User Image"
                        >
                      </div>
                      <!-- Message title and timestamp -->
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o" /> 5 mins</small>
                      </h4>
                      <!-- The message -->
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer">
                <a href="#">See All Messages</a>
              </li>
            </ul>
          </li>
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a
              href="#"
              class="dropdown-toggle"
              data-toggle="dropdown"
            >
              <i class="fa fa-bell-o" />
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                You have 10 notifications
              </li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li>
                    <!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua" /> 5 new members joined today
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all</a>
              </li>
            </ul>
          </li>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a
              href="#"
              class="dropdown-toggle"
              data-toggle="dropdown"
            >
              <i class="fa fa-flag-o" />
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                You have 9 tasks
              </li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
                  <li>
                    <!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div
                          class="progress-bar progress-bar-aqua"
                          style="width: 20%"
                          role="progressbar"
                          aria-valuenow="20"
                          aria-valuemin="0"
                          aria-valuemax="100"
                        >
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
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
                  <a
                    href="#"
                    class="btn btn-default btn-flat"
                  >Ayarlarım</a>
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


export default {
  name: 'NHeader',
  data () {
    return {
      image: img,
      user: null
    }
  },
  watch: {
    '$route': 'getUser'
  },
  created () {
    this.getUser()
  },
  // beforeRouteEnter (to, from, next) {
  //   console.log('Before')
  //   Auth.getUser((err, user) => {
  //     console.log('Before' + user)
  //     next(vm => vm.setUser(err, user))
  //   })
  // },
  // beforeRouteUpdate (to, from, next) {
  //   console.log('BeforeUpt')
  //   this.post = null
  //   Auth.getUser((err, user) => {
  //     this.setData(err, user)
  //     next()
  //   })
  // },
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

<style>

</style>
