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

import Constants from '../helpers/constants'

export default {
  install (Vue, options) {
    // Burada İzinler localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.prototype.$can = function (permission) {
      const permissions = JSON.parse(localStorage.getItem(Constants.PERMISSIONS))
      return permissions.filter(p => p.name === permission).length > 0
    }
    // Burada Rolleri localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.prototype.$isInRole = function (role) {
      const roles = JSON.parse(localStorage.getItem(Constants.ROLES))
      if (roles) { return roles.filter(r => r === role).length > 0 }
      return false
    }
  }
}
