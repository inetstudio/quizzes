@php
    $blockId = (isset($key)) ? str_replace('new_', '', $key) : (($item->id) ? $item->id : 'template-id');
    $dataId = (isset($key)) ? $key : (($item->id) ? $item->id : 'new_template-id');
@endphp

<div class="panel-group col-xs-12" id="answer-{{ $blockId }}" data-type="answer" data-id="{{ $dataId }}" style="margin: 20px 0 0 0">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#answer-{{ $blockId }}" aria-expanded="false" href="#collapseAnswer-{{ $blockId }}">{{ (isset($key)) ? old('answer.title.'.$key) : (($item->title) ? $item->title : 'Новый ответ') }}</a>
                <a href="#" class="btn btn-danger delete-option pull-right btn-xs" style="color: #fff;"><i class="fa fa-times-circle"></i></a>
            </h4>
        </div>
        <div id="collapseAnswer-{{ $blockId }}" class="panel-collapse collapse" aria-expanded="false">
            <div class="panel-body">

                {!! Form::hidden('', (isset($key)) ? $key : $dataId, [
                    'name' => 'answer[keys][]',
                ]) !!}

                {!! Form::hidden('', (isset($key)) ? old('answer.question_id.'.$key) : (($item->quiz_question_id) ? $item->quiz_question_id : 'question-id'), [
                    'name' => 'answer[question_id]['.$dataId.']',
                ]) !!}

                {!! Form::string('', (isset($key)) ? old('answer.title.'.$key) : (($item->title) ? $item->title : 'Новый ответ'), [
                    'label' => [
                        'title' => 'Ответ',
                    ],
                    'field' => [
                        'name' => 'answer[title]['.$dataId.']',
                        'class' => 'form-control change-header',
                    ],
                ]) !!}

                @if ($quizType == 'trivia')

                    {!! Form::wysiwyg('description', (isset($key)) ? old('answer.description.'.$key) : $item->description, [
                        'label' => [
                            'title' => 'Описание',
                        ],
                        'field' => [
                            'class' => 'tinymce',
                            'id' => 'answer-'.$blockId.'_description',
                            'hasImages' => true,
                            'name' => 'answer[description]['.$dataId.']',
                        ],
                        'images' => [
                            'media' => $item->getMedia('description'),
                            'fields' => [
                                [
                                    'title' => 'Описание',
                                    'name' => 'description',
                                ],
                                [
                                    'title' => 'Copyright',
                                    'name' => 'copyright',
                                ],
                                [
                                    'title' => 'Alt',
                                    'name' => 'alt',
                                ],
                            ],
                        ],
                    ]) !!}

                    {!! Form::string('', (isset($key)) ? old('answer.points.'.$key) : $item->points, [
                        'label' => [
                            'title' => 'Количество баллов',
                        ],
                        'field' => [
                            'class' => 'form-control',
                            'name' => 'answer[points]['.$dataId.']',
                        ],
                    ]) !!}

                @endif

                @php
                    $previewImageMedia = (isset($key)) ? null : $item->getFirstMedia('preview');
                @endphp

                {!! Form::crop('answer[preview]['.$dataId.']', $previewImageMedia, [
                    'label' => [
                        'title' => 'Превью',
                    ],
                    'image' => [
                        'filepath' => isset($previewImageMedia) ? url($previewImageMedia->getUrl()) : '',
                        'filename' => isset($previewImageMedia) ? $previewImageMedia->file_name : '',
                    ],
                    'crops' => [
                        [
                            'title' => 'Альбомная ориентация',
                            'name' => 'album',
                            'ratio' => '190/178',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.album') : '',
                            'size' => [
                                'width' => 190,
                                'height' => 178,
                                'type' => 'min',
                                'description' => 'Минимальный размер области — 190x178 пикселей'
                            ],
                        ],
                    ],
                    'additional' => [
                        [
                            'title' => 'Описание',
                            'name' => 'description',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('description') : '',
                        ],
                        [
                            'title' => 'Copyright',
                            'name' => 'copyright',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('copyright') : '',
                        ],
                        [
                            'title' => 'Alt',
                            'name' => 'alt',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('alt') : '',
                        ],
                    ],
                ]) !!}

                @if ($quizType == 'personal')
                    <div class="form-group answer-results col-xs-12" style="@if (! ((isset($key) && old('answer.association.'.$key)) or ($item && $item->results->count() > 0)))display:none;@endif margin-top: 20px">
                        <label class="col-sm-2 control-label">Связь с результатом</label>
                        <div class="col-sm-10">
                            @if (isset($key) && old('answer.association.'.$key))
                                @foreach (old('answer.association.'.$key) as $resultKey => $val)
                                    @include('admin.module.quizzes::back.partials.answers.answer_result', [
                                        'resultKey' => $resultKey,
                                        'answerKey' => $key,
                                        'value' => $val,
                                    ])
                                @endforeach
                            @elseif ($item->results->count() > 0)
                                @foreach ($item->results as $resultAssoc)
                                    @include('admin.module.quizzes::back.partials.answers.answer_result', [
                                        'resultAssoc' => $resultAssoc,
                                    ])
                                @endforeach
                            @elseif (isset($quizItem))
                                @foreach ($quizItem->results as $resultAssoc)
                                    @include('admin.module.quizzes::back.partials.answers.answer_result', [
                                        'resultAssoc' => $resultAssoc,
                                    ])
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                @endif

            </div>
        </div>
    </div>
</div>
