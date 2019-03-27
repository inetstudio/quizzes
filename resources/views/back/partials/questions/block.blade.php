@php
    $blockId = (isset($key)) ? str_replace('new_', '', $key) : (($item->id) ? $item->id : 'template-id');
    $dataId = (isset($key)) ? $key : (($item->id) ? $item->id : 'new_template-id');
@endphp

<div class="panel-group col-xs-12" id="question-{{ $blockId }}" data-type="question" data-id="{{ $dataId }}" style="margin: 20px 0 0 0">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-11">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#question-{{ $blockId }}" aria-expanded="false" href="#collapseQuestion-{{ $blockId }}">{{ (isset($key)) ? old('question.title.'.$key) : (($item->title) ? $item->title : 'Новый вопрос') }}</a>
                    </h4>
                </div>
                <div class="col-1">
                    <button class="btn btn-danger btn-xs float-right delete-option"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
        <div id="collapseQuestion-{{ $blockId }}" class="collapse" aria-expanded="false">
            <div class="panel-body">

                {!! Form::hidden('', (isset($key)) ? $key : $dataId, [
                    'name' => 'question[keys][]',
                ]) !!}

                {!! Form::string('', (isset($key)) ? old('question.title.'.$key) : (($item->title) ? $item->title : 'Новый вопрос'), [
                    'label' => [
                        'title' => 'Вопрос',
                    ],
                    'field' => [
                        'name' => 'question[title]['.$dataId.']',
                        'class' => 'form-control change-header',
                    ],
                ]) !!}

                @php
                    $previewImageMedia = (isset($key)) ? null : $item->getFirstMedia('preview');
                @endphp

                {!! Form::crop('question[preview]['.$dataId.']', $previewImageMedia, [
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
                            'ratio' => '448/336',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.album') : '',
                            'size' => [
                                'width' => 448,
                                'height' => 336,
                                'type' => 'min',
                                'description' => 'Минимальный размер области — 448x336 пикселей'
                            ],
                        ],
                        [
                            'title' => 'Портретная ориентация',
                            'name' => 'portrait',
                            'ratio' => '448/620',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.portrait') : '',
                            'size' => [
                                'width' => 448,
                                'height' => 620,
                                'type' => 'min',
                                'description' => 'Минимальный размер области — 448x620 пикселей'
                            ],
                        ],
                        [
                            'title' => 'Квадратное изображение',
                            'name' => 'square',
                            'ratio' => '448/448',
                            'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.square') : '',
                            'size' => [
                                'width' => 448,
                                'height' => 448,
                                'type' => 'min',
                                'description' => 'Минимальный размер области — 448x448 пикселей'
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

                @if (old('answer.keys'))
                    @foreach (old('answer.keys') as $key)
                        @if (old('answer.question_id.'.$key) == $dataId)
                            @include('admin.module.quizzes::back.partials.answers.block', ['key' => $key, 'quizType' => $quizType])
                        @endif
                    @endforeach
                @else
                    @if ($item->answers)
                        @foreach ($item->answers as $answer)
                            @include('admin.module.quizzes::back.partials.answers.block', ['item' => $answer, 'quizType' => $quizType])
                        @endforeach
                    @endif
                @endif

                <a href="#" class="btn btn-md btn-success add-answer" style="margin-top: 20px"><i class="fa fa-plus"></i> Добавить ответ</a>

            </div>
        </div>
    </div>
</div>
