/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

// Access Control Logic Plugin
const ACL = {
  install (Vue, options) {
    // Burada İzinler localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli

    let roles = []
    let permissions = []
    Vue.prototype.$can = function (permission) {
      // if (permissions === null || permissions.length === 0) {
      permissions = JSON.parse(localStorage.getItem('permissions'))
      // }
      return permissions.filter(p => p.name === permission).length > 0
    }
    // Burada Rolleri localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.prototype.$isInRole = function (role) {
      // if (roles === null || roles.length === 0) {
      roles = JSON.parse(localStorage.getItem('roles'))
      // }
      return roles.filter(r => r.name === role).length > 0
    }
  }
}

export default ACL
