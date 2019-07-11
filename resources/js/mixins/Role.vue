<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<script>
export default {
  data () {
    return {
      roles: null
    }
  },
  methods: {
    $can (roleName) {
      if (this.roles == null) {
        this.roles = JSON.parse(localStorage.getItem('roles'))
      }
      // if (Array.isArray(roleNames))
      //   let res = true
      //   roleNames.each(rn => {
      //     this.roles.filter(p => p.name === rn).length > 0
      //   })
      //   return this.roles.filter(p => p.name === r).length > 0;
      return this.roles.filter(p => p.name === roleName).length > 0
    }
  }
}
</script>
