window.tinymce.PluginManager.add('quizzes', function (editor) {
    editor.addButton('add_quiz_widget', {
        title: 'Тесты',
        image: '/admin/images/tinymce-button-quizzes-add-widget.png',
        onclick: function () {
            editor.focus();

            let content = editor.selection.getContent();
            let quizWidgetID = '';

            if (content !== '' && ! /<img class="content-widget".+data-type="quiz".+\/>/g.test(content)) {
                swal({
                    title: "Ошибка",
                    text: "Необходимо выбрать виджет-тест",
                    type: "error"
                });

                return false;
            } else if (content !== '') {
                quizWidgetID = $(content).attr('data-id');

                window.Admin.modules.widgets.getWidget(quizWidgetID, function (widget) {
                    $('#choose_quiz_modal .choose-data').val(JSON.stringify(widget.additional_info));
                    $('#choose_quiz_modal input[name=quiz]').val(widget.additional_info.title);
                });
            }

            $('#choose_quiz_modal .save').off('click');
            $('#choose_quiz_modal .save').on('click', function (event) {
                event.preventDefault();

                let data = JSON.parse($('#choose_quiz_modal .choose-data').val());

                window.Admin.modules.widgets.saveWidget(quizWidgetID, {
                    view: 'admin.module.quizzes::front.partials.content.quiz_widget',
                    params: {
                        id: data.id
                    },
                    additional_info: data
                }, {
                    editor: editor,
                    type: 'quiz',
                    alt: 'Виджет-тест: '+data.title
                }, function (widget) {
                    $('#choose_quiz_modal').modal('hide');
                });
            });

            $('#choose_quiz_modal').modal();
        }
    })
});
