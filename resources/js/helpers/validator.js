/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

/*
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

import Vue from 'vue'
import VeeValidate, { Validator } from 'vee-validate'
// eslint-disable-next-line camelcase
// import { required, min, max, alpha_spaces, email, confirmed, size } from 'vee-validate/dist/rules.esm'
import tr from 'vee-validate/dist/locale/tr'

const dictionary = {
  tr: {
    attributes: {
      email: 'E-posta adresi',
      password: 'Şifre',
      retypePassword: 'Şifre tekrarı',
      full_name: 'Ad Soyad',
      phone: 'Telefon numarası',
      branchName: 'Branş/Ders',
      selectedBranch: 'Branş/Ders',
      inst: 'Kurum',
      branch: 'Alan/Ders',
      code: 'Kod',
      content: 'İçerik',
      questionFile: 'Soru dosyası',
      selectedClassLevel: 'Sınıf seviyesi',
      learningOutCome: 'Kazanım',
      itemRoot: 'Soru kökü',
      searchedContent: 'Aranacak metin',
      difficulty: 'Zorluk seviyesi',
      correctAnswer: 'Doğru cevap',
      comment: 'Gözden geçirme yorumu',
      instName: 'Okul/Kurum adı',
      instId: 'Okul/Kurum kodu',
      unit: 'Birim/Şube',
      evalPoint: 'Değerlendirme puanı',
      evalComment: 'Değerlendirme yorumu'
    }
  }
}

// Add the rules you need.
// Validator.extend('required', required)
// Validator.extend('min', min)
// Validator.extend('max', max)
// Validator.extend('alpha_spaces', alpha_spaces)
// Validator.extend('email', email)
// Validator.extend('confirmed', confirmed)
// Validator.extend('size', size)
// Merge the messages.

Vue.use(VeeValidate)

Validator.localize('tr', tr)
Validator.localize(dictionary)

Validator.extend('verify_password', {
  getMessage: field => 'Şifre en az: 1 büyük harf, 1 küçük harf, 1 rakam, ve bir özel karakter içermelidir(. , + @ # % vs.)',
  validate: value => {
    const strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[#$^+=!*()@%&.]).{8,16}')
    return strongRegex.test(value)
  }
})
