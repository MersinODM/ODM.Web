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

import http from '../helpers/axios'

export const SettingService = {
  getGeneralInfo () {
    return new Promise((resolve, reject) => {
      http.get('auth/general_info')
        .then(value => {
          // localStorage.setItem(Constants.generalInfo, JSON.stringify(value.data))
          resolve(value.data)
        })
        .catch(reason => reject(reason))
    })
  },
  getSettings () {
    return new Promise((resolve, reject) => {
      http.get('settings')
        .then(response => resolve(response.data))
        .catch(reason => reject(reason))
    })
  },
  update (settings) {
    return new Promise((resolve, reject) => {
      http.put('settings', settings)
        .then((response) => {
          resolve(response.data)
        })
        .catch((reason) => reject(reason))
    })
  },
  mailSync () {
    return new Promise((resolve, reject) => {
      http.get('mails/sync')
        .then((response) => resolve(response.data))
        .catch((reason) => reject(reason))
    })
  }
}
