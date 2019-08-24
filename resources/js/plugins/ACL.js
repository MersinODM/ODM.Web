/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

// Access Control Logic Plugin


export default {
  install (Vue, options) {
    // Burada İzinler localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.prototype.$can = function (permission) {
      let permissions = JSON.parse(localStorage.getItem('permissions'))
      return permissions.filter(p => p.name === permission).length > 0
    }
    // Burada Rolleri localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.prototype.$isInRole = function (role) {
      let roles = JSON.parse(localStorage.getItem('roles'))
      return roles.filter(r => r === role).length > 0
    }
  }
}
