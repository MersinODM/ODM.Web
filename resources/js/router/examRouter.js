
import ExamList from '../views/exam/ExamList'
import NewExam from '../views/exam/NewExam'
import NewAutoExam from '../views/exam/NewAutoExam'
// import NewManualExam from '../views/exam/NewManualExam'
import UnderConstruction from '../views/utils/UnderConstruction'

const examRoutes = [
  {
    path: '/exams/list',
    name: 'examList',
    component: ExamList
  },
  {
    path: '/exams/wizard',
    name: 'newExam',
    component: NewExam
  },
  {
    path: '/exams/create/auto',
    name: 'newAutoExam',
    component: NewAutoExam
  },
  {
    path: '/exams/create/manual',
    name: 'newManualExam',
    component: UnderConstruction
  }
]

export default examRoutes
