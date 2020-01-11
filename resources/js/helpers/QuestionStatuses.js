/*
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

export const QuestionStatuses = {
  WAITING_FOR_ACTION: 0, // İşeleme alınmamış
  IN_ELECTION: 1, // değerledirme aşamasında
  NOT_MUST_ASKED: 2, // SORULMAMALI
  NEED_REVISION: 3, // Revizyon gerekir
  REVISION_COMPLETED: 4, // Revizyon tamamlandı
  APPROVED: 5 // Onaylanmış soru
}
