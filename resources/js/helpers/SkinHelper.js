/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

const SkinHelper = {
  LoginSkin () {
    document.body.classList.remove('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed', 'register-page')
    document.body.classList.add('login-page')
  },
  MainSkin () {
    document.body.classList.remove('login-page', 'register-page')
    document.body.classList.add('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed')
  }
}

export default SkinHelper
