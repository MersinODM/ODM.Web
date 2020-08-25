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
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>
              E-Posta Senkronizasyonu(Deneysel Özellik)
            </h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-offset-4 col-md-4">
                <button
                  class="btn btn-primary btn-block"
                  @click="sync"
                >
                  E-Postaları Dağıt
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { SettingService } from '../../services/SettingService'

export default {
  name: 'MailSync',
  methods: {
    sync () {
      SettingService.mailSync()
    }
  }
}
</script>

<style scoped>

</style>
