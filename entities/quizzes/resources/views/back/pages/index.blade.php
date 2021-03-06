@extends('admin::back.layouts.app')

@php
    $title = 'Тесты';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.quizzes-package.quizzes::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-sm btn-primary dropdown-toggle">Добавить</button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('back.quizzes-package.quizzes.create', ['type' => 'trivia']) }}">Trivia</a></li>
                                <li><a href="{{ route('back.quizzes-package.quizzes.create', ['type' => 'personal']) }}">Personal Quiz</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            {{ $table->table(['class' => 'table table-striped table-bordered table-hover dataTable']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('scripts:datatables_quizzes_package_quizzes_index')
    {!! $table->scripts() !!}
@endpushonce
