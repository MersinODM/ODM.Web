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

const SkinHelper = {
  LoginSkin () {
    document.body.classList.remove('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed', 'register-page')
    document.body.classList.add('login-page')
  },
  MainSkin () {
    document.body.classList.remove('login-page', 'register-page')
    document.body.classList.add('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed')
  }
}

export default SkinHelper
