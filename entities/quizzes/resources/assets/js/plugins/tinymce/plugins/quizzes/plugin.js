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

    function initQuizzesComponents() {
        if (typeof window.Admin.vue.modulesComponents.$refs['quizzes-package_QuizWidget'] == 'undefined') {
            window.Admin.vue.modulesComponents.modules['quizzes-package'].components = _.union(
                window.Admin.vue.modulesComponents.modules['quizzes-package'].components, [
                    {
                        name: 'QuizWidget',
                        data: widgetData,
                    },
                ]);
        }
    }

    function loadWidget() {
        let component = window.Admin.vue.modulesComponents.$refs['quizzes-package_QuizWidget'][0];

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

                initQuizzesComponents();

                window.waitForElement('#add_quiz_widget_modal', function() {
                    loadWidget();

                    $('#add_quiz_widget_modal').modal();
                });
            } else {
                swal({
                    title: 'Ошибка',
                    text: 'Необходимо выбрать виджет-тест',
                    type: 'error',
                });

                return false;
            }
        }
    })
});
