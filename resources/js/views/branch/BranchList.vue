<!--
  - Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
  - Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
  - Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
  -->

<template>
  <page>
    <template v-slot:header>
      <h1>Branş Listesi</h1>
    </template>
    <template v-slot:content>
      <div class="row">
        <div class="col-md-12">
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
              <div class="card">
                <div class="card-header">
                  <h4>
                    {{ b.name }} - {{ b.code }}
                  </h4>
                </div>
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="card-body">
                  <!-- /.widget-user-image -->
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a href="javascript:0">Soru Sayısı <span class="float-right badge bg-primary mt-1">{{ b.questionCount }}</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="javascript:0">Öğretmen Sayısı <span class="float-right badge bg-primary mt-1">{{ b.userCount }}</span>
                      </a>
                    </li>
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
    </template>
  </page>
</template>

<script>
import BranchService from '../../services/BranchService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'
import chunk from 'lodash/chunk'
import Page from '../../components/Page'

export default {
  name: 'BranchList',
  components: { Page },
  data () {
    return {
      branchGroup: null
    }
  },
  created () {
    this.getBranches()
  },
  methods: {
    getBranches () {
      BranchService.getBranchesWithStats()
        .then(data => {
          this.branchGroup = chunk(data, 3)
        })
        .catch(reason => {
          Messenger.showError(MessengerConstants.errorMessage)
        })
    }
  }

}
</script>

<style>

</style>
