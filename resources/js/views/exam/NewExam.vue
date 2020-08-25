<template>
  <page>
    <template slot="header">
      <h4>Sınav Oluşturma Sihirbazı <a href="https://www.google.com/search?q=morpheus">(MORPHEUS)</a></h4>
    </template>
    <template slot="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <button
                    class="btn btn-danger btn-block"
                    style="height:8em"
                    @click="$router.push({name: 'newManualExam'})"
                  >
                    Soruları Seçerek Sınavı Elle Oluşturayım
                  </button>
                </div>
                <div class="col-md-6">
                  <button
                    style="height:8em"
                    class="btn btn-primary btn-block"
                    @click="$router.push({name: 'newAutoExam'})"
                  >
                    Parametreleri Vereyim Otomatik Oluşturuver
                  </button>
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
  name: 'NewExam',
  components: { Page }
}
</script>

<style scoped>

</style>
