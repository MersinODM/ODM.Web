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
  <div class="error-page">
    <h2 class="headline text-yellow">
      404
    </h2>

    <div class="error-content">
      <h3><i class="fa fa-warning text-yellow" /> Üzgünüz aradığınız sayfa bulunamadı!</h3>

      <p>
        Aradığınız sayfayı bulamadık :-(
        Belki <router-link :to="{name:'master'}">
          anasayfaya
        </router-link> dönmek isteyebilirsiniz.
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
