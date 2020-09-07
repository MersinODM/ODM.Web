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
      <h4>
        Uygulama ayarları
        <div class="float-right">
          <button
            class="btn btn-success float-right mr-2"
            @click="refreshSettings"
          >
            Yenile
          </button>
        </div>
      </h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div
                    class="form-group has-feedback"
                  >
                    <label>İlinizin Adı *</label>
                    <input
                      v-model="settings.city"
                      v-validate="'required|min:3'"
                      name="city"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('city')}"
                      placeholder="İlinizin adını giriniz"
                    >
                    <span
                      v-if="errors.has('city')"
                      class="error invalid-feedback"
                    >{{ errors.first('city') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Bağlı Bulunulan Yerel İdare *</label>
                    <input
                      v-model="settings.governor"
                      v-validate="'required|min:3'"
                      name="governor"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('governor')}"
                      placeholder="Valilik/Kaymakamlık bigisi(... Valiliği, ... Kaymakamlığı)"
                    >
                    <span
                      v-if="errors.has('governor')"
                      class="error invalid-feedback"
                    >{{ errors.first('governor') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Bağlı Bulunulan Müdürlük *</label>
                    <input
                      v-model="settings.directorate"
                      v-validate="'required|min:3'"
                      name="directorate"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('directorate')}"
                      placeholder="İl/İlçe Milli Eğitim Müdürlüğü"
                    >
                    <span
                      v-if="errors.has('directorate')"
                      class="error invalid-feedback"
                    >{{ errors.first('directorate') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Merkez Adı *</label>
                    <input
                      v-model="settings.inst_name"
                      v-validate="'required|min:3'"
                      name="inst_name"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('inst_name')}"
                      placeholder="Merkezin adını giriniz"
                    >
                    <span
                      v-if="errors.has('inst_name')"
                      class="error invalid-feedback"
                    >{{ errors.first('inst_name') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Web Siteniz *</label>
                    <input
                      v-model="settings.web_address"
                      v-validate="'required|min:3'"
                      name="web_address"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('web_address')}"
                      placeholder="Web sitenizin adresi(http://*****odm.meb.gov.tr/)"
                    >
                    <span
                      v-if="errors.has('web_address')"
                      class="error invalid-feedback"
                    >{{ errors.first('web_address') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Twitter Adresiniz *</label>
                    <input
                      v-model="settings.twitter_address"
                      v-validate="'required|min:3'"
                      name="twitter_address"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('twitter_address')}"
                      placeholder="Twitter adresinizi giriniz"
                    >
                    <span
                      v-if="errors.has('twitter_address')"
                      class="error invalid-feedback"
                    >{{ errors.first('twitter_address') }}</span>
                  </div>
                  <div
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
                      :class="{'is-invalid': errors.has('phone')}"
                      placeholder="Telefon numaranızı giriniz(Yoksa il/ilçe mem numarası giriniz)"
                    >
                    <span
                      v-if="errors.has('phone')"
                      class="error invalid-feedback"
                    >{{ errors.first('phone') }}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Email Adresiniz *</label>
                    <input
                      v-model="settings.email"
                      v-validate="'required|email'"
                      name="email"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('email')}"
                      placeholder="Lütfen gmail e-posta adresinizi giriniz"
                    >
                    <span
                      v-if="errors.has('email')"
                      class="error invalid-feedback"
                    >{{ errors.first('email') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Captcha Private(Özel/Gizli) Anahtarınız *</label>
                    <input
                      v-model="settings.captcha_private_key"
                      v-validate="'required'"
                      name="captcha_private_key"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('captcha_private_key')}"
                      placeholder="recaptcha v2 private(özel/gizli) anahtarınızı giriniz"
                    >
                    <span
                      v-if="errors.has('captcha_private_key')"
                      class="error invalid-feedback"
                    >{{ errors.first('captcha_private_key') }}</span>
                  </div>
                  <div
                    class="form-group has-feedback"
                  >
                    <label>Captcha Public(Açık) Anahtarınız *</label>
                    <input
                      v-model="settings.captcha_public_key"
                      v-validate="'required'"
                      name="captcha_public_key"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors.has('captcha_public_key')}"
                      placeholder="recaptcha v2 public anahtarınızı giriniz"
                    >
                    <span
                      v-if="errors.has('captcha_public_key')"
                      class="error invalid-feedback"
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
                    class="form-group has-feedback"
                  >
                    <label>Kurumunuzun Adresi</label>
                    <textarea
                      v-model="settings.address"
                      v-validate="'required|min:10'"
                      name="address"
                      class="form-control"
                      :class="{'is-invalid': errors.has('address')}"
                      rows="2"
                      style="max-width: 100%; min-width: 100%; min-height: 50px"
                      placeholder="Kurum adresinizi giriniz"
                    />
                    <span class="mdi mdi-flagform-control-feedback" />
                    <span
                      v-if="errors.has('address')"
                      class="error invalid-feedback"
                    >{{ errors.first('address') }}</span>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Captcha Ayarı </label>
                    <p-check
                      v-model="settings.captcha_enabled"
                      class="p-switch p-fill"
                      color="success"
                    >
                      {{ settings.captcha_enabled ? 'Açık' : 'Kapalı' }}
                    </p-check>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Kom. üyelerine değerlendirme atamada e-posta atılsın mı? </label>
                    <p-check
                      v-model="settings.will_the_electors_be_emailed"
                      class="p-switch p-fill"
                      color="success"
                    >
                      {{ settings.will_the_electors_be_emailed ? 'Evet' : 'Hayır' }}
                    </p-check>
                  </div>
                </div>
              </div>
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <button
                    :class="{ disabled : isSending }"
                    type="submit"
                    class="btn btn-primary btn-block"
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
    </template>
  </page>
</template>

<script>
import { SettingService } from '../../services/SettingService'
import Messenger from '../../helpers/messenger'
import Page from '../../components/Page'
import PCheck from 'pretty-checkbox-vue/check'

export default {
  name: 'AppSettings',
  components: { Page, PCheck },
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
              .then((res) => { Messenger.showInfo(res.message) })
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
