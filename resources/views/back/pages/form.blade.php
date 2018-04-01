@php
    $quizType = ($item->quiz_type) ? $item->quiz_type : $type;
@endphp

@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Редактирование теста' : 'Добавление теста';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.quizzes::back.partials.breadcrumbs.form')
    @endpush

    <div class="row m-sm">
        <a class="btn btn-white" href="{{ route('back.quizzes.index') }}">
            <i class="fa fa-arrow-left"></i> Вернуться назад
        </a>
    </div>

    <div class="wrapper wrapper-content">

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.quizzes.store') : route('back.quizzes.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'quizz-form form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('quiz_id', (! $item->id) ? '' : $item->id) !!}

            {!! Form::buttons('', '', ['back' => 'back.quizzes.index']) !!}

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    {!! Form::dropdown('quiz_type', $quizType, [
                                        'label' => [
                                            'title' => 'Тип теста',
                                        ],
                                        'field' => [
                                            'class' => 'select2 form-control',
                                            'data-placeholder' => 'Выберите тип',
                                            'style' => 'width: 100%',
                                            'readonly' => 'readonly',
                                        ],
                                        'options' => [
                                            'values' => [
                                                null => '',
                                                'trivia' => 'Trivia',
                                                'personal' => 'Personality Quiz',
                                            ],
                                        ],
                                    ]) !!}

                                    {!! Form::string('title', $item->title, [
                                        'label' => [
                                            'title' => 'Заголовок',
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('description', $item->description, [
                                        'label' => [
                                            'title' => 'Описание',
                                        ],
                                        'field' => [
                                            'class' => 'tinymce',
                                            'id' => 'description',
                                            'hasImages' => true,
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

                                    @php
                                        $previewImageMedia = $item->getFirstMedia('preview');
                                    @endphp

                                    {!! Form::crop('preview', $previewImageMedia, [
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
                                                'ratio' => '392/294',
                                                'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.album') : '',
                                                'size' => [
                                                    'width' => 392,
                                                    'height' => 294,
                                                    'type' => 'min',
                                                    'description' => 'Минимальный размер области — 392x294 пикселей'
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group" id="resultsAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#resultsAccordion" aria-expanded="false" href="#collapseResults">Результаты</a>
                                </h4>
                            </div>
                            <div id="collapseResults" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body">

                                    {!! Form::dropdown('result_type', $item->result_type, [
                                        'label' => [
                                            'title' => 'Тип результата',
                                        ],
                                        'field' => [
                                            'class' => 'select2 form-control',
                                            'data-placeholder' => 'Выберите тип',
                                            'style' => 'width: 100%',
                                        ],
                                        'options' => [
                                            'values' => [
                                                null => '',
                                                'full' => 'Полный результат',
                                                'short_email' => 'Короткий + на почту',
                                                'email' => 'На почту',
                                            ],
                                        ],
                                    ]) !!}

                                    @if (old('result.keys'))
                                        @foreach (old('result.keys') as $key)
                                            @include('admin.module.quizzes::back.partials.results.block', ['key' => $key, 'quizType' => $quizType])
                                        @endforeach
                                    @else
                                        @foreach ($item->results as $result)
                                            @include('admin.module.quizzes::back.partials.results.block', ['item' => $result, 'quizType' => $quizType])
                                        @endforeach
                                    @endif

                                    <a href="#" class="btn btn-md btn-success add-result" style="margin-top: 20px"><i class="fa fa-plus"></i> Добавить результат</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group" id="questionsAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#questionsAccordion" aria-expanded="false" href="#collapseQuestions">Вопросы</a>
                                </h4>
                            </div>
                            <div id="collapseQuestions" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body">

                                    @if (old('question.keys'))
                                        @foreach (old('question.keys') as $key)
                                            @include('admin.module.quizzes::back.partials.questions.block', ['key' => $key, 'quizType' => $quizType])
                                        @endforeach
                                    @else
                                        @foreach ($item->questions as $question)
                                            @include('admin.module.quizzes::back.partials.questions.block', ['item' => $question, 'quizType' => $quizType])
                                        @endforeach
                                    @endif

                                    <a href="#" class="btn btn-md btn-success add-question" style="margin-top: 20px"><i class="fa fa-plus"></i> Добавить вопрос</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::buttons('', '', ['back' => 'back.quizzes.index']) !!}

        {!! Form::close()!!}
    </div>

    <div class="templates" style="display: none">
        <div class="question">
            @include('admin.module.quizzes::back.partials.questions.block', [
                'item' => app()->make('InetStudio\Quizzes\Contracts\Models\QuestionModelContract'),
                'key' => null,
                'quizType' => $quizType,
            ])
        </div>
        <div class="answer">
            @include('admin.module.quizzes::back.partials.answers.block', [
                'item' => app()->make('InetStudio\Quizzes\Contracts\Models\AnswerModelContract'),
                'key' => null,
                'quizType' => $quizType,
                'quizItem' => $item,
            ])
        </div>
        <div class="result">
            @include('admin.module.quizzes::back.partials.results.block', [
                'item' => app()->make('InetStudio\Quizzes\Contracts\Models\ResultModelContract'),
                'key' => null,
                'quizType' => $quizType,
            ])
        </div>

        @if ($quizType == 'personal')
            <div class="answer_results">
                @include('admin.module.quizzes::back.partials.answers.answer_result', [
                    'item' => app()->make('InetStudio\Quizzes\Contracts\Models\AnswerModelContract'),
                    'resultAssoc' => null,
                ])
            </div>
        @endif
    </div>
@endsection
