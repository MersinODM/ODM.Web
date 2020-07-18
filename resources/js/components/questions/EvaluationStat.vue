<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
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
