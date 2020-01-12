
import http from '../helpers/axios'

const StatService = {
  getQuestionCounts () {
    return new Promise((resolve, reject) => {
      http.get('/stats/question_counts/total')
        .then(resp => resolve(resp.data))
        .catch(err => reject(err))
    })
  },
  getClasses () {
    return new Promise((resolve, reject) => {
      http.get('/stats/classes')
        .then(resp => resolve(resp.data))
        .catch(err => reject(err))
    })
  },
  getLearningOutcomes (classLevel, isAnyQuestionLO) {
    return new Promise((resolve, reject) => {
      http.get('/stats/lo_count_by', { params: { class_level: classLevel, is_any_question_lo: isAnyQuestionLO } })
        .then(resp => resolve(resp.data))
        .catch(err => reject(err))
    })
  }
}

export default StatService
