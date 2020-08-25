<!--
  - ODM.Web  https://github.com/electropsycho/ODM.Web
  - Copyright (C) 2020 Hakan GÜLEN
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU General Public License as published by
  - the Free Software Foundation, either version 3 of the License, or
  - (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU General Public License for more details.
  -
  - You should have received a copy of the GNU General Public License
  - along with this program.  If not, see http://www.gnu.org/licenses/
  -->

<template>
  <router-link
    v-if="router && router.name"
    tag="li"
    :to="router"
  >
    <a href="#">
      <i :class="icon" /> <span>{{ name }}</span>
      <span
        v-show="badge"
        class="pull-right-container"
      >
        <small
          class="label pull-right"
          :class="[badge.type==='String'?'bg-green':'label-primary']"
        >{{ badge.data }}
        </small>
      </span>
    </a>
  </router-link>
  <li
    v-else
    :class="getType"
  >
    {{ isHeader ? name : '' }}
    <a
      v-if="!isHeader"
      href="#"
    >
      <i :class="icon" /> <span>{{ name }}</span>
      <span class="pull-right-container">
        <small
          v-if="badge && badge.data"
          class="label pull-right"
          :class="[badge.type==='String'?'bg-green':'label-primary']"
        >{{ badge.data }}</small>
        <i
          v-else
          class="fa fa-angle-left pull-right"
        />
      </span>
    </a>
    <ul
      v-if="items.length > 0"
      class="treeview-menu"
    >
      <router-link
        v-for="(item,index) in items"
        v-if="item.router && item.router.name"
        :key="index"
        tag="li"
        :data="item"
        :to="item.router"
      >
        <a>
          <i :class="item.icon" /> {{ item.name }}
        </a>
      </router-link>
      <li v-else>
        <a>
          <i :class="item.icon" /> {{ item.name }}
        </a>
      </li>
    </ul>
  </li>
</template>

<script>
export default {
  name: 'SbMenuItem',
  props: {
    type: {
      type: String,
      default: 'item'
    },
    isHeader: {
      type: Boolean,
      default: false
    },
    icon: {
      type: String,
      default: ''
    },
    name: {
      type: String
    },
    badge: {
      type: Object,
      default () {
        return {}
      }
    },
    items: {
      type: Array,
      default () {
        return []
      }
    },
    router: {
      type: Object,
      default () {
        return {
          name: ''
        }
      }
    },
    link: {
      type: String,
      default: ''
    }
  },
  computed: {
    getType () {
      if (this.isHeader) {
        return 'header'
      }
      return this.type === 'item' ? '' : 'treeview'
    }
  },
  created () {
  }
}
</script>
