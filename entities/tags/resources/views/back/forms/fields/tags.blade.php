@inject('tagsService', 'InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ItemsServiceContract')

@php
    $item = $value;
@endphp

{!! Form::dropdown('parent_id', $item->parent()->pluck('id')->toArray(), [
    'label' => [
        'title' => 'Родительский тег',
    ],
    'field' => [
        'class' => 'select2-drop form-control',
        'data-placeholder' => 'Выберите тег',
        'style' => 'width: 100%',
        'data-source' => route('back.quizzes-package.tags.getSuggestions'),
        'data-exclude' => isset($attributes['exclude']) ? implode('|', $attributes['exclude']) : '',
    ],
    'options' => [
        'values' => (old('parent_id')) ? $tagsService->getItemById(old('parent_id'))->pluck('name', 'id')->toArray() : $item->parent()->pluck('name', 'id')->toArray(),
    ],
]) !!}
