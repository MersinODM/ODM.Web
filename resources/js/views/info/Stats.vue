<template>
  <section class="content">
    <div class="row">
      <div class="col-md-4">
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ validCount }}</h3>

            <p>Havuzdaki Soru Sayısı</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars" />
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ nonValidCount }}</h3>

            <p>Değerlendirmedeki Soru sayısı</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add" />
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ total }}</h3>
            <p>Toplam</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag" />
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
               vm.validCount = questionCounts.valid_count
               vm.nonValidCount = questionCounts.non_valid_count
               vm.total = questionCounts.total_count
               vm.classes = classes
             })
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

<style>

</style>
