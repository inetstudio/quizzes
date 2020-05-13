require('./plugins/tinymce/plugins/quizzes');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

require('./stores/quizzes-package');

Vue.component(
    'QuizWidget',
    require('./components/partials/QuizWidget/QuizWidget.vue').default,
);

let quizzes = require('./package/quizzes.js');
quizzes.init();
