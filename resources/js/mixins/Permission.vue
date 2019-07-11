<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<script>
export default {
  data () {
    return {
      permissions: null
    }
  },
  methods: {
    $can (permissionName) {
      if (this.permissions == null) {
        this.permissions = JSON.parse(localStorage.getItem('permissions'))
      }
      return this.permissions.filter(p => p.name === permissionName).length > 0
    }
  }
}
</script>
