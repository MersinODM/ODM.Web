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
  <i
    v-if="event.elector_id"
    class="fa fa-commenting-o bg-blue"
  />
  <i
    v-else
    class="fa fa-recycle bg-orange"
  />

  <div
    v-if="event.elector_id"
    class="timeline-item"
  >
    <span class="time"><i class="fa fa-clock-o" /> {{ formatDate(event.date) }}</span>

    <h3 class="timeline-header">
      <a
        href="#"
        @click.prevent
      >Değerlendirici Grup Kodu: {{ detectHeader(event) }}</a>
    </h3>

    <div class="timeline-body">
      {{ event.comment }}
    </div>
    <div class="timeline-footer">
      Değerlendirme Tarihi <span class="label label-primary">{{ event.date | trDate }}</span>
    </div>
  </div>
  <div
    v-else
    class="timeline-item"
  >
    <span class="time"><i class="fa fa-clock-o" /> {{ formatDate(event.date) }}</span>

    <h3 class="timeline-header">
      <a href="javascript:">Revizyon</a>
    </h3>

    <div class="timeline-body">
      {{ event.comment }}
    </div>
    <div class="timeline-footer">
      Revizyon Tarihi <span class="label label-warning">{{ event.date | trDate }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TimeLineItem'
}
</script>

<style scoped>

</style>
