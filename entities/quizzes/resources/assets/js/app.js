import {quizzes} from './package/quizzes';

require('./plugins/tinymce/plugins/quizzes');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

require('./stores/quizzes-package');

window.Vue.component(
    'QuizWidget',
    () => import('./components/partials/QuizWidget/QuizWidget.vue'),
);

quizzes.init();
