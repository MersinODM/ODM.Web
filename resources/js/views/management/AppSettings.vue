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
              Uygulama ayarları
              <div class="pull-right">
                <button
                  class="btn btn-success pull-right"
                  style="margin-right: 10px"
                  @click="refreshSettings"
                >
                  Yenile
                </button>
              </div>
            </h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <form @submit.prevent>
                  <div class="col-md-6">
                    <div
                      :class="{'has-error': errors.has('city')}"
                      class="form-group has-feedback"
                    >
                      <label>İlinizin Adı *</label>
                      <input
                        v-model="settings.city"
                        v-validate="'required|min:3'"
                        name="city"
                        type="text"
                        class="form-control"
                        placeholder="İlinizin adını giriniz"
                      >
                      <span
                        v-if="errors.has('city')"
                        class="help-block"
                      >{{ errors.first('city') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('governor')}"
                      class="form-group has-feedback"
                    >
                      <label>Bağlı Bulunulan Yerel İdare *</label>
                      <input
                        v-model="settings.governor"
                        v-validate="'required|min:3'"
                        name="governor"
                        type="text"
                        class="form-control"
                        placeholder="Valilik/Kaymakamlık bigisi(... Valiliği, ... Kaymakamlığı)"
                      >
                      <span
                        v-if="errors.has('governor')"
                        class="help-block"
                      >{{ errors.first('governor') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('directorate')}"
                      class="form-group has-feedback"
                    >
                      <label>Bağlı Bulunulan Müdürlük *</label>
                      <input
                        v-model="settings.directorate"
                        v-validate="'required|min:3'"
                        name="directorate"
                        type="text"
                        class="form-control"
                        placeholder="İl/İlçe Milli Eğitim Müdürlüğü"
                      >
                      <span
                        v-if="errors.has('directorate')"
                        class="help-block"
                      >{{ errors.first('directorate') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('inst_name')}"
                      class="form-group has-feedback"
                    >
                      <label>Merkez Adı *</label>
                      <input
                        v-model="settings.inst_name"
                        v-validate="'required|min:3'"
                        name="inst_name"
                        type="text"
                        class="form-control"
                        placeholder="Merkezin adını giriniz"
                      >
                      <span
                        v-if="errors.has('inst_name')"
                        class="help-block"
                      >{{ errors.first('inst_name') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('web_address')}"
                      class="form-group has-feedback"
                    >
                      <label>Web Siteniz *</label>
                      <input
                        v-model="settings.web_address"
                        v-validate="'required|min:3'"
                        name="web_address"
                        type="text"
                        class="form-control"
                        placeholder="Web sitenizin adresi(http://*****odm.meb.gov.tr/)"
                      >
                      <span
                        v-if="errors.has('web_address')"
                        class="help-block"
                      >{{ errors.first('web_address') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('twitter_address')}"
                      class="form-group has-feedback"
                    >
                      <label>Twitter Adresiniz *</label>
                      <input
                        v-model="settings.twitter_address"
                        v-validate="'required|min:3'"
                        name="twitter_address"
                        type="text"
                        class="form-control"
                        placeholder="Twitter adresinizi giriniz"
                      >
                      <span
                        v-if="errors.has('twitter_address')"
                        class="help-block"
                      >{{ errors.first('twitter_address') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('phone')}"
                      class="form-group has-feedback"
                    >
                      <label>Telefon Numaranız *</label>
                      <input
                        v-model="settings.phone"
                        v-mask="'### ### ####'"
                        v-validate="{ required: true, regex:/[0-9]{1,3}[ ][0-9]{1,3}[ ][0-9]{4}$/ }"
                        name="phone"
                        type="text"
                        class="form-control"
                        placeholder="Telefon numaranızı giriniz(Yoksa il/ilçe mem numarası giriniz)"
                      >
                      <span
                        v-if="errors.has('phone')"
                        class="help-block"
                      >{{ errors.first('phone') }}</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div
                      :class="{'has-error': errors.has('email')}"
                      class="form-group has-feedback"
                    >
                      <label>Email Adresiniz *</label>
                      <input
                        v-model="settings.email"
                        v-validate="'required|email'"
                        name="email"
                        type="text"
                        class="form-control"
                        placeholder="Lütfen gmail e-posta adresinizi giriniz"
                      >
                      <span
                        v-if="errors.has('email')"
                        class="help-block"
                      >{{ errors.first('email') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('captcha_private_key')}"
                      class="form-group has-feedback"
                    >
                      <label>Captcha Private(Özel/Gizli) Anahtarınız *</label>
                      <input
                        v-model="settings.captcha_private_key"
                        v-validate="'required'"
                        name="captcha_private_key"
                        type="text"
                        class="form-control"
                        placeholder="recaptcha v2 private(özel/gizli) anahtarınızı giriniz"
                      >
                      <span
                        v-if="errors.has('captcha_private_key')"
                        class="help-block"
                      >{{ errors.first('captcha_private_key') }}</span>
                    </div>
                    <div
                      :class="{'has-error': errors.has('captcha_public_key')}"
                      class="form-group has-feedback"
                    >
                      <label>Captcha Public(Açık) Anahtarınız *</label>
                      <input
                        v-model="settings.captcha_public_key"
                        v-validate="'required'"
                        name="captcha_public_key"
                        type="text"
                        class="form-control"
                        placeholder="recaptcha v2 public anahtarınızı giriniz"
                      >
                      <span
                        v-if="errors.has('captcha_public_key')"
                        class="help-block"
                      >{{ errors.first('captcha_public_key') }}</span>
                    </div>
                    <div class="form-group has-feedback">
                      <label>Facebook Adresiniz</label>
                      <input
                        v-model="settings.facebook_address"
                        type="text"
                        class="form-control"
                        placeholder="Facebook adresinizi giriniz(Zorunlu değil)"
                      >
                    </div>
                    <div class="form-group has-feedback">
                      <label>Instagram Adresiniz</label>
                      <input
                        v-model="settings.instagram_address"
                        type="text"
                        class="form-control"
                        placeholder="Instagram adresinizi giriniz(Zorunlu değil)"
                      >
                    </div>
                    <div
                      :class="{'has-error': errors.has('address')}"
                      class="form-group has-feedback"
                    >
                      <label>Kurumunuzun Adresi</label>
                      <textarea
                        v-model="settings.address"
                        v-validate="'required|min:10'"
                        name="address"
                        class="form-control"
                        rows="2"
                        style="max-width: 100%; min-width: 100%; min-height: 50px"
                        placeholder="Kurum adresinizi giriniz"
                      />
                      <span class="mdi mdi-flagform-control-feedback" />
                      <span
                        v-if="errors.has('address')"
                        class="help-block"
                      >{{ errors.first('address') }}</span>
                    </div>
                    <div class="form-group has-feedback">
                      <label>Captcha Ayarı </label>
                      <p-check
                        v-model="settings.captcha_enabled"
                        class="p-switch p-fill"
                        color="success">
                        {{ settings.captcha_enabled ? 'Açık' : 'Kapalı' }}
                      </p-check>
                    </div>
                  </div>
                </form>
              </div>
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
import Messenger from '../../helpers/messenger'

export default {
  name: 'AppSettings',
  data: () => ({
    isSending: false,
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
        Messenger.showError('İstediğiniz sayfayı açamıyoruz sistem lütfen yöneticinize başvurunuz!')
        console.log(err)
      })
  },
  methods: {
    save () {
      this.$validator.validateAll()
        .then(valRes => {
          if (valRes) {
            this.isSending = true
            const loader = this.$loading.show()
            SettingService.update(this.settings)
              .then((res) => { Messenger.showInfoV2(res.message) })
              .catch((err) => {
                Messenger.showError('Ayarlarınız güncelleyemedik lütfen sistem yöneticinize başvurunuz!')
                console.log(err)
              })
              .finally(() => {
                this.isSending = false
                loader.hide()
              })
          }
        })
    },
    refreshSettings () {
      const loader = this.$loading.show()
      SettingService.getSettings()
        .then((settings) => {
          this.settings = settings
        })
        .catch((err) => {
          Messenger.showError('Ayarlarınız sunucudan getiremedik lütfen yöneticinize başvurunuz!')
          console.log(err)
        })
        .finally(() => {
          this.$validator.reset()
          loader.hide()
        })
    }
  }
}
</script>

<style>

</style>
