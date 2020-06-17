<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <section class="content">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <div class="col-md-12">
            <slot name="header" />
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="container-fluid">
      <slot name="content" />
    </div>
  </section>
</template>

<script>
export default {
  name: 'Page'
}
</script>

<style scoped>

</style>
