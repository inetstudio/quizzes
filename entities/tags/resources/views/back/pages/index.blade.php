@extends('admin::back.layouts.app')

@php
    $title = 'Теги';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.quizzes-package.tags::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{ route('back.quizzes-package.tags.create') }}" class="btn btn-primary btn-sm">Добавить</a>
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

@pushonce('scripts:datatables_quizzes_tags_index')
{!! $table->scripts() !!}
@endpushonce
