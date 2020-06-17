// export default {
//
//   boot () {
/**
     * We'll load jQuery and the Bootstrap jQuery plugin which provides support
     * for JavaScript based Bootstrap features such as modals and tabs. This
     * code may be modified to fit the specific needs of your application.
     */
// window._ = require('lodash')
// import $ from 'jquery/dist/jquery.min'
// window.$ = window.jQuery = $
// window.moment = require('moment/min/moment.min')
// const momentTR = require('moment/locale/tr')
// moment.locale('tr')
// require('jquery-ui')
// let swal = require('sweetalert')

// require('noty');
/** s
     * Vue is a modern JavaScript library for building interactive web interfaces
     * using reactive data binding and reusable components. Vue's API is clean
     * and simple, leaving you to focus on building your next great project.
     */

// window.Vue = require('vue')
// const axios = require('./helpers/axios')
require('./helpers/filters')
require('bootstrap/dist/js/bootstrap.bundle.min')
require('jquery-slimscroll/jquery.slimscroll.min')
require('fastclick/lib/fastclick')
require('admin-lte/dist/js/adminlte.min')
require('admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min')

// require('pace-js/pace.min')

// Datatables için err mode kapatılıyot tüm hataları biz yakalayacağız
$.fn.dataTable.ext.errMode = 'none'
$.fn.DataTable.ext.pager.numbers_length = 5

// eslint-disable-next-line no-undef

// console.log(window.axios)
//
// /**
//  * We'll register a HTTP interceptor to attach the "CSRF" header to each of
//  * the outgoing requests issued by this application. The CSRF middleware
//  * included with Laravel will automatically verify the header's value.
//  */
//

// eslint-disable-next-line no-undef
// Vue.prototype.$http = axios
//   }
// }

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"
//
// window.Echo = new Echo({
//   broadcaster: 'pusher',
//   key: 'a1c1c701c5ea3bb53e8e'
// });
//
// Pusher.log = function(message)
// {
//   window.console.log(message)
// }
