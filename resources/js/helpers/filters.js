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

import Vue from 'vue'
import dayjs from '../helpers/dayjs'

Vue.filter('year', (value) => {
  if (!value) return ''
  // console.log('Moment Filter: ' + value)
  return dayjs(value).format('YYYY')
})

Vue.filter('dateTime', (value) => {
  if (!value) return ''
  if (!dayjs(value).isValid()) return value
  return dayjs(value).format('DD.MM.YYYY HH:mm')
})

Vue.filter('trDate', (value) => {
  if (!value) return ''
  // console.log('Moment Filter: ' + value)
  return dayjs(value).format('L')
})
