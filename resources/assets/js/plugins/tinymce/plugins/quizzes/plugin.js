window.tinymce.PluginManager.add('quizzes', function (editor) {
    editor.addButton('add_quiz_widget', {
        title: 'Тесты',
        image: '/images/tinymce-button-quizzes-add-widget.png',
        onclick: function () {
            editor.focus();

            $('#choose_quiz_modal .save').off('click');
            $('#choose_quiz_modal .save').on('click', function (event) {
                event.preventDefault();

                let data = JSON.parse($('#choose_quiz_modal .choose-data').val());

                editor.execCommand('mceReplaceContent', false, '' +
                    '<img class="content-widget" data-type="quiz" id="quiz-'+data.id+'" data-id="'+data.id+'" alt="Виджет-тест: '+data.title+'" style="height: 100px; width: 100%; border: 1px red solid;" />'
                );

                $('#choose_quiz_modal .choose-data').val('');
                $('#choose_quiz_modal input[name=quiz]').val('');

                $('#choose_quiz_modal').modal('hide');
            });

            $('#choose_quiz_modal').modal();
        }
    })
});
