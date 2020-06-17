<!--
  -  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  -  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  -  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
  -->

<template>
  <page>
    <template v-slot:header>
      <h4 class="text-danger">
        Yapım aşamasında 🛠️
      </h4>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-12">
          <div class="card card-danger">
            <div class="card-title" />
            <div class="card-body">
              <div class="col-md-6">
                <div class="row justify-content-md-center ">
                  <p><b>Üzgünüz 😔</b> istediğiniz sayfa şu an için yapım aşamasındadır. Sabrınız için teşekkür ederiz.</p>
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
import Page from '../../components/Page'
export default {
  name: 'UnderConstruction',
  components: { Page }
}
</script>

<style scoped>

</style>
