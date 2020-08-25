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
  <div class="form-group">
    <label>{{ label }}</label>
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar" />
      </div>
      <input
        type="text"
        class="form-control pull-right"
      >
    </div>
  </div>
</template>
<script>
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min'
import 'bootstrap-datepicker/dist/locales/bootstrap-datepicker.tr.min'

export default {
  name: 'DatePicker',
  props: {
    format: String,
    label: String,
    value: Date,
    language: String
  },
  mounted () {
    // this.id = this.$uuid.v4();
    const self = this
    // $.extend($.fn.datepicker.defaults, { language: this.language });
    // $.extend($.fn.datepicker.defaults, { language: 'tr', autoclose: true, todayBtn: 'linked' });
    const dp = $(this.$el).find('.input-group')
    dp.datepicker({
      language: 'tr',
      todayBtn: 'linked',
      autoclose: true,
      format: this.format,
      value: this.value
    }).on('changeDate', (e) => {
      self.$emit('update:date', moment(e.date, this.format).format())
    })
      .on('show', () => { $('.datepicker-dropdown').css('z-index', 100000) })
  }
}
</script>
<style lang="sass">
  @import '~bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
</style>
