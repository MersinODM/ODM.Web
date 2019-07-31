<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h4>Branş Listesi</h4>
          </div>
          <div class="box-body">
            <div
              v-for="branches in branchGroup"
              class="row"
            >
              <div
                v-for="b in branches"
                :key="b.id"
                class="col-md-4"
              >
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header" :class="colors[Math.floor(Math.random() * colors.length)]">
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">
                      {{ b.name }}
                    </h3>
                    <h5>{{ b.code }}</h5>
                  </div>
                  <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="#">Soru Sayısı <span class="pull-right badge bg-blue">{{ b.questionCount }}</span></a></li>
                      <li><a href="#">Öğretmen Sayısı <span class="pull-right badge bg-aqua">{{ b.userCount }}</span></a></li>
                      <!--                      <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>-->
                      <!--                      <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>-->
                    </ul>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import BranchService from '../../services/BranchService'

export default {
  name: 'BranchList',
  data () {
    return {
      branchGroup: null,
      colors: ['bg-yellow', 'bg-green', 'bg-yellow', 'bg-red', 'bg-aqua', 'bg-purple', 'bg-blue', 'bg-navy', 'bg-teal', 'bg-maroon', 'bg-black', 'bg-gray', 'bg-olive', 'bg-orange', 'bg-fuchsia']
    }
  },
  created () {
    this.getBranches()
  },
  methods: {
    getBranches () {
      BranchService.getBranchesWithStats(data => {
        this.branchGroup = _.chunk(data, 3)
      })
    }
  }

}
</script>

<style scoped>

</style>
