@inject('tagsService', 'InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ItemsServiceContract')

@php
    $blockId = (isset($key)) ? str_replace('new_', '', $key) : (($item->id) ? $item->id : 'template-id');
    $dataId = (isset($key)) ? $key : (($item->id) ? $item->id : 'new_template-id');
@endphp

<div class="panel-group col-xs-12" id="result-{{ $blockId }}" data-type="result" data-id="{{ $dataId }}" style="margin: 20px 0 0 0">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-11">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#result-{{ $blockId }}" aria-expanded="false" href="#collapseResult-{{ $blockId }}">{{ (isset($key)) ? old('result.title.'.$key) : (($item->title) ? $item->title : 'Новый результат') }}</a>
                    </h4>
                </div>
                <div class="col-1">
                    <button class="btn btn-danger btn-xs float-right delete-option"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
        <div id="collapseResult-{{ $blockId }}" class="collapse" aria-expanded="false">
            <div class="panel-body">

                {!! Form::hidden('', (isset($key)) ? $key : $dataId, [
                    'name' => 'result[keys][]',
                ]) !!}

                {!! Form::string('', (isset($key)) ? old('result.title.'.$key) : (($item->title) ? $item->title : 'Новый результат'), [
                    'label' => [
                        'title' => 'Заголовок',
                    ],
                    'field' => [
                        'name' => 'result[title]['.$dataId.']',
                        'class' => 'form-control change-header',
                    ],
                ]) !!}

                @if ($quizType == 'trivia')

                    {!! Form::string('', (isset($key)) ? old('result.min_points.'.$key) : $item->min_points, [
                        'label' => [
                            'title' => 'Минимум баллов',
                        ],
                        'field' => [
                            'name' => 'result[min_points]['.$dataId.']',
                        ],
                    ]) !!}

                    {!! Form::string('', (isset($key)) ? old('result.max_points.'.$key) : $item->max_points, [
                        'label' => [
                            'title' => 'Максимум баллов',
                        ],
                        'field' => [
                            'name' => 'result[max_points]['.$dataId.']',
                        ],
                    ]) !!}

                @endif

                {!! Form::wysiwyg('short_description', $item->short_description, [
                    'label' => [
                        'title' => 'Короткий результат',
                    ],
                    'field' => [
                        'class' => 'tinymce',
                        'id' => 'result-'.$blockId.'_short_description',
                        'hasImages' => true,
                        'name' => 'result[short_description]['.$dataId.']',
                    ],
                    'images' => [
                        'media' => $item->getMedia('short_description'),
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

                {!! Form::wysiwyg('full_description', $item->full_description, [
                    'label' => [
                        'title' => 'Полный результат',
                    ],
                    'field' => [
                        'class' => 'tinymce',
                        'id' => 'result-'.$blockId.'_full_description',
                        'hasImages' => true,
                        'name' => 'result[full_description]['.$dataId.']',
                    ],
                    'images' => [
                        'media' => $item->getMedia('full_description'),
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

                @php
                    $previewImageMedia = (isset($key)) ? null : $item->getFirstMedia('preview');
                @endphp

                {!! Form::crop('result[preview]['.$dataId.']', $previewImageMedia, [
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

                {!! Form::dropdown('result[tags]['.$dataId.']', (isset($key)) ? old('result.tags.'.$key) : $item->tags()->pluck('id')->toArray(), [
                    'label' => [
                        'title' => 'Теги',
                    ],
                    'field' => [
                        'class' => ((isset($key)) ? $key : (($item->id) ? 'select2-drop form-control' : 'form-control')),
                        'data-placeholder' => 'Выберите теги',
                        'style' => 'width: 100%',
                        'data-source' => route('back.quizzes-package.tags.getSuggestionsChildren'),
                    ],
                    'options' => [
                        'values' => (isset($key)) ? $tagsService->getItemById(old('result.tags.'.$key))->pluck('name', 'id')->toArray() : $item->tags()->pluck('name', 'id')->toArray(),
                    ],
                ]) !!}

            </div>
        </div>
    </div>
</div>
