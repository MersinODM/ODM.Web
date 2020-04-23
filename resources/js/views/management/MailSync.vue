<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
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
