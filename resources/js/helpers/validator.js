/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
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
      evalComment: 'Değerlendirme yorumu',
      examTitle: 'Sınav adı/başlığı',
      examPurpose: 'Sınav genel amacı',
      plannedDate: 'Planlan tarih'
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
