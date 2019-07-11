/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

// Access Control Logic Plugin
let ACL = {
  permissions: [],
  roles: [],
  install (Vue, options) {
    // Burada İzinler localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.can = function (permission) {
      if (this.permissions == null) {
        this.permissions = JSON.parse(localStorage.getItem('permissions'))
      }
      return this.permissions.filter(p => p.name === permission).length > 0
    }
    // Burada Rolleri localStorage içine almak sıkıntı yaratabilir
    // TODO: Refactoring gerekli
    Vue.isInRole = function (role) {
      if (this.roles == null) {
        this.roles = JSON.parse(localStorage.getItem('roles'))
      }
      return this.permissions.filter(r => r.name === role).length > 0
    }
  }
}

export default ACL
