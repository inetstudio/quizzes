import Swal from 'sweetalert2';

window.tinymce.PluginManager.add('quizzes', function (editor) {
    let widgetData = {
        widget: {
            events: {
                widgetSaved: function(model) {
                    editor.execCommand(
                        'mceReplaceContent',
                        false,
                        '<img class="content-widget" data-type="quiz" data-id="' + model.id + '" alt="Виджет-тест: '+model.additional_info.title+'" />',
                    );
                },
            },
        },
    };

    function loadWidget() {
        let component = window.Admin.vue.helpers.getVueComponent('quizzes-package', 'QuizWidget');

        component.$data.model.id = widgetData.model.id;
    }

    editor.addButton('add_quiz_widget', {
        title: 'Тесты',
        icon: 'menu',
        onclick: function () {
            editor.focus();

            let content = editor.selection.getContent();
            let isQuiz = /<img class="content-widget".+data-type="quiz".+>/g.test(content);

            if (content === '' || isQuiz) {
                widgetData.model = {
                    id: parseInt($(content).attr('data-id')) || 0,
                };

                window.Admin.vue.helpers.initComponent('quizzes-package', 'QuizWidget', widgetData);

                window.waitForElement('#add_quiz_widget_modal', function() {
                    loadWidget();

                    $('#add_quiz_widget_modal').modal();
                });
            } else {
                Swal.fire({
                    title: 'Ошибка',
                    text: 'Необходимо выбрать виджет-тест',
                    icon: 'error',
                });

                return false;
            }
        }
    })
});
