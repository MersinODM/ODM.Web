<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
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
      <a href="javascript:">Değerlendirici Grup Kodu: {{ detectHeader(event) }}</a>
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
