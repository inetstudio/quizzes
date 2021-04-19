@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Редактирование тега' : 'Создание тега';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.quizzes-package.tags::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white m-r-xs" href="{{ route('back.quizzes-package.tags.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.quizzes-package.tags.store') : route('back.quizzes-package.tags.update', [$item->id]), 'id' => 'mainForm']) !!}

        @if ($item->id)
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

        {!! Form::hidden('type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.quizzes-package.tags.index']) !!}
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id="mainAccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain"
                                           aria-expanded="true">Основная информация</a>
                                    </h5>
                                </div>
                                <div id="collapseMain" class="collapse show" aria-expanded="true">
                                    <div class="panel-body">

                                        {!! Form::string('name', $item->name, [
                                            'label' => [
                                                'title' => 'Название',
                                            ],
                                           'field' => [
                                                'class' => 'form-control slugify',
                                                'data-slug-url' => route('back.quizzes-package.tags.getAlias'),
                                                'data-slug-target' => 'alias',
                                            ],
                                        ]) !!}

                                        {!! Form::string('alias', $item->alias, [
                                            'label' => [
                                                'title' => 'Алиас',
                                            ],
                                            'field' => [
                                                'class' => 'form-control slugify',
                                                'data-slug-url' => route('back.quizzes-package.tags.getAlias'),
                                                'data-slug-target' => 'alias',
                                            ],
                                        ]) !!}

                                        {!! Form::quizzes_tags('', $item, [
                                            'exclude' => [$item->id],
                                        ]) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                {!! Form::buttons('', '', ['back' => 'back.quizzes-package.tags.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>
@endsection
