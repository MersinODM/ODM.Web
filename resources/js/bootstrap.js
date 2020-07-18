require('./helpers/filters')
require('admin-lte/plugins/bootstrap/js/bootstrap.min')
require('jquery-slimscroll/jquery.slimscroll.min')
require('fastclick/lib/fastclick')
require('admin-lte/dist/js/adminlte.min')
require('admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min')
require('./helpers/validator.js')

// require('pace-js/pace.min')

$.fn.dataTable.ext.errMode = 'none' // Datatables için err mode kapatılıyor tüm hataları biz yakalayacağız
$.fn.DataTable.ext.pager.numbers_length = 5 // Sayfalama genişliği

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
