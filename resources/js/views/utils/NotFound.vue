<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>

    <div class="error-content">
      <h3><i class="fa fa-warning text-yellow"></i> Üzgünüz aradığınız sayfa bulunamadı!</h3>

      <p>
        Aradığınız sayfayı bulamadık :-(
        Belki <router-link :to="{name:'master'}">anasayfaya</router-link> dönmek isteyebilirsiniz.
      </p>

<!--      <form class="search-form">-->
<!--        <div class="input-group">-->
<!--          <input type="text" name="search" class="form-control" placeholder="Search">-->

<!--          <div class="input-group-btn">-->
<!--            <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>-->
<!--            </button>-->
<!--          </div>-->
<!--        </div>-->
<!--        &lt;!&ndash; /.input-group &ndash;&gt;-->
<!--      </form>-->
    </div>
    <!-- /.error-content -->
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style>

</style>
