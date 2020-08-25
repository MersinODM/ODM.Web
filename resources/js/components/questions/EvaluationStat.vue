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
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          Değerlendirme İstatistikleri
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="card bg-primary">
                <div class="card-header">
                  <h6>Değerlendirme Sayısı</h6>
                </div>
                <div class="card-body">
                  <h4>45</h4>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card bg-warning">
                <div class="card-header">
                  <h6>Toplam Revizyon Sayısı</h6>
                </div>
                <div class="card-body">
                  <h4>45</h4>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card bg-success">
                <div class="card-header">
                  <h6>Son Değ. Puan Ortalaması</h6>
                </div>
                <div class="card-body">
                  <h4>45</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EvaluationStat',
  props: ['question']
}
</script>

<style scoped>

</style>
