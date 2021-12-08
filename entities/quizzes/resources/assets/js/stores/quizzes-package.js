import hash from 'object-hash';
import { v4 as uuidv4 } from 'uuid';

window.Admin.vue.stores['quizzes-package'] = new window.Vuex.Store({
  state: {
    emptyQuiz: {
      model: {
        title: '',
        description: '',
        quiz_type: '',
        result_type: '',
        created_at: null,
        updated_at: null,
        deleted_at: null,
      },
      isModified: false,
      hash: '',
    },
    quiz: {},
    mode: '',
  },
  mutations: {
    setQuiz(state, quiz) {
      let emptyQuiz = JSON.parse(JSON.stringify(state.emptyQuiz));
      emptyQuiz.model.id = uuidv4();

      let resultQuiz = _.merge(emptyQuiz, quiz);
      resultQuiz.hash = hash(resultQuiz.model);

      state.quiz = resultQuiz;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
  },
});
