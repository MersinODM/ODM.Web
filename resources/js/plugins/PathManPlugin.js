/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

export default {
  install (Vue, options) {
    // Base path bulma fplugin i
    Vue.prototype.$getBasePath = () => {
      if (!window.location.host.includes('localhost')) {
        return window.location.pathname.split('/').slice(0, 2).join('/')
      }
      return ''
    }
  }
}
