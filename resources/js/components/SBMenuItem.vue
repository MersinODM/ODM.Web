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
