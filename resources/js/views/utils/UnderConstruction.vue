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
  <page>
    <template v-slot:header>
      <h4 class="text-danger">
        Yapım aşamasında 🛠️
      </h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-12">
          <div class="card card-danger">
            <div class="card-title" />
            <div class="card-body">
              <div class="col-md-6">
                <div class="row justify-content-md-center ">
                  <p><b>Üzgünüz 😔</b> istediğiniz sayfa şu an için yapım aşamasındadır. Sabrınız için teşekkür ederiz.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
export default {
  name: 'UnderConstruction',
  components: { Page }
}
</script>

<style scoped>

</style>
