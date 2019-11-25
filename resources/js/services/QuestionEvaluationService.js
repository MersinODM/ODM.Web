import http from '../helpers/axios'

const QuestionEvaluationService = {
  save (id, data) {
    return new Promise((resolve, reject) => {
      http.post(`/questions/${id}/evaluations`, data)
          .then(response => { resolve(response.data) })
          .catch(error => reject(error))
    })
  },
  findByQuestionId (id) {
    return new Promise((resolve, reject) => {
      http.get(`/questions/${id}/evaluations`)
          .then(response => { resolve(response.data) })
          .catch(error => reject(error))
    })
  }
}

export default QuestionEvaluationService
