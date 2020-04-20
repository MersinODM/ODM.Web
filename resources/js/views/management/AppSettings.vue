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
            <h4>Uygulama ayarları</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <form
                action="post"
                @submit.prevent
              >
                <div class="col-md-offset-3 col-md-6">
                  <div class="form-group has-feedback">
                    <label>Captcha Ayarı</label>
                    <br>
                    <p-check
                      class="p-switch p-fill"
                      color="success"
                    />
                    <span />
                  </div>
                </div>
              </form>
            </div>
            <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <button
                  :class="{ disabled : isSending }"
                  type="submit"
                  class="btn btn-primary btn-block btn-flat"
                  @click="save"
                >
                  Kaydet
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
  name: 'AppSettings',
  data: () => ({
    isSending: false,
    showCaptcha: false,
    settings: {}
  }),
  beforeRouteEnter (from, to, next) {
    SettingService.getSettings()
      .then((settings) => {
        next(vm => {
          vm.settings = settings
        })
      })
      .catch((err) => {
        console.log(err)
      })
  },
  methods: {
    save () {

    }
  }
}
</script>

<style>

</style>
