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
