/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

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
