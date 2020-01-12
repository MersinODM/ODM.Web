<template>
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <h4 v-if="$isInRole('admin')">
              Genel Soru Sayıları
            </h4>
            <h4 v-else>
              Branş/Alan Geneli Soru Sayıları
            </h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-gray">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">İşleme Alınmamış Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.waiting_for_action }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-aqua">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Değerlendirmedeki Soru sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.in_election }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-yellow">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Revizyon Alması Gereken Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.need_revision }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-blue">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Revizyonu Tamamlanmış Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.revision_completed }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-red">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Sorulamayacak Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.not_must_asked }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-green">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Onaylanmış Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.approved }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="info-box bg-navy">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Toplam Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.total }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <h4>
              Bana Ait Soru Sayıları
            </h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-gray">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">İşleme Alınmamış Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_waiting_for_action }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-aqua">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Değerlendirmedeki Soru sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_in_election }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-yellow">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Revizyon Alması Gereken Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_need_revision }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-blue">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Revizyonu Tamamlanmış Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_revision_completed }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-red">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Sorulamayacak Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_not_must_asked }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="info-box bg-green">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Onaylanmış Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_approved }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="info-box bg-navy">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Toplam Soru Sayısı</span>
                    <span class="info-box-number text-center">{{ questionCounts.own_total }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="box box-success">
          <div class="box-header with-border">
            <h4 class="pull-left">
              Soru Hazırlanan Sınıflar
            </h4>
          </div>
          <div class="box-body">
            <ul class="nav nav-stacked">
              <li>
                <a
                  href=""
                  @click.prevent.stop=""
                >
                  <div class="row">
                    <div class="col-md-6 col-xs-6">
                      Sınıflar
                    </div>
                    <div class="col-md-2 col-xs-2">
                      <span class="badge bg-green">H</span>
                    </div>
                    <div class="col-md-2 col-xs-2">
                      <span class="badge bg-orange">D</span>
                    </div>
                    <div class="col-md-2 col-xs-2">
                      <span class="badge bg-aqua">T</span>
                    </div>
                  </div>
                </a>
              </li>
              <li
                v-for="c in classes"
                :key="c.class_level"
              >
                <a
                  href=""
                  @click.prevent.stop="getLearningOutComesByClass(c.class_level)"
                >
                  <div class="row">
                    <div class="col-md-6 col-xs-6">{{ c.class_level }} .Sınıf</div>
                    <div class="col-md-2 col-xs-2"><span class="badge bg-green">{{ c.valid_count }}</span></div>
                    <div class="col-md-2 col-xs-2"><span class="badge bg-orange">{{ c.non_valid_count }}</span></div>
                    <div class="col-md-2 col-xs-2"><span class="badge bg-aqua">{{ c.total_count }}</span></div>
                  </div>
                </a>
              </li>
            </ul>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li>
                  <br>
                  <p-check
                    v-model="isAnyQuestionLO"
                    class="p-switch p-fill"
                    name="check"
                    color="success"
                  >
                    Hiç Soru Sorulmayan Kaz.
                  </p-check>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="box">
          <div class="box-header with-border">
            <h4 class="pull-left">
              Soru Sayılarına Göre Kazanımlar
            </h4>
          </div>
          <div class="box-body">
            <ul class="nav nav-stacked">
              <li
                v-for="l in learningOutComes"
                :key="l.learning_outcome_id"
              >
                <a
                  href=""
                  @click.prevent.stop=""
                >
                  <div class="row">
                    <div class="col-md-6 col-xs-9">{{ l.learning_outcome }}</div>
                    <div class="col-md-2 col-xs-1"><span class="badge bg-green">{{ l.valid_count }}</span></div>
                    <div class="col-md-2 col-xs-1"><span class="badge bg-orange">{{ l.non_valid_count }}</span></div>
                    <div class="col-md-2 col-xs-1"><span class="badge bg-aqua">{{ l.total_count }}</span></div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>

import StatService from '../../services/StatService'
import Messenger from '../../helpers/messenger'
import { MessengerConstants } from '../../helpers/constants'

export default {
  name: 'Stats',
  data () {
    return {
      questionCounts: null,
      total: 0,
      nonValidCount: 0,
      validCount: 0,
      classes: [],
      isAnyQuestionLO: false,
      learningOutComes: []
    }
  },
  beforeRouteEnter (to, from, next) {
    Promise.all([StatService.getClasses(), StatService.getQuestionCounts()])
      .then(([classes, questionCounts]) => {
        next(vm => {
          vm.questionCounts = questionCounts
          // vm.validCount = questionCounts.valid_count
          // vm.nonValidCount = questionCounts.non_valid_count
          // vm.total = questionCounts.total_count
          vm.classes = classes
        })
      })
      .catch(reason => {
        console.log(reason)
        location.reload()
      })

    // StatService.getQuestionCounts()
    //            .then((counts) => {
    //              next(vm => {
    //                vm.validCount = counts.valid_count
    //                vm.nonValidCount = counts.non_valid_count
    //                vm.total = counts.total_count
    //              })
    //            })
  },
  methods: {
    test () {

    },
    getLearningOutComesByClass (cls) {
      StatService.getLearningOutcomes(cls, this.isAnyQuestionLO ? 0 : 1)
        .then(data => { this.learningOutComes = data })
        .catch(() => { Messenger.showError(MessengerConstants.errorMessage) })
    }
  }
}
</script>

<style scoped>
.info-box {
  min-height: 50px;
}
.info-box .info-box-content {
  margin-left: auto;
}
</style>
