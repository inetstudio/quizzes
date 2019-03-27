@pushonce('modals:choose_quiz')
    <div id="choose_quiz_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Выберите тест</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content">

                        {!! Form::hidden('quiz_data', '', [
                            'class' => 'choose-data',
                            'id' => 'quiz_data',
                        ]) !!}

                        {!! Form::string('quiz', '', [
                            'label' => [
                                'title' => 'Тест',
                            ],
                            'field' => [
                                'class' => 'form-control autocomplete',
                                'data-search' => route('back.quizzes.getSuggestions'),
                                'data-target' => '#quiz_data'
                            ],
                        ]) !!}

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary save">Сохранить</a>
                </div>

            </div>
        </div>
    </div>
@endpushonce
