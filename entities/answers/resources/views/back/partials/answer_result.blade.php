@php
    $resultId = (isset($resultKey)) ? $resultKey : (($resultAssoc) ? $resultAssoc->id : 'new_result-id');
    $answerId = (isset($answerKey)) ? $answerKey : (($item->id) ? $item->id : 'new_template-id');
    $val = (isset($value)) ? $value : (($resultAssoc && $resultAssoc->pivot) ? $resultAssoc->pivot->association : 0);
    $title = (isset($resultKey)) ? old('result.title.'.$resultKey) : (($resultAssoc) ? $resultAssoc->title : 'Новый результат');
@endphp

<div class="row" style="margin-bottom: 10px;" data-assoc-result="{{ $resultId }}">
    <div class="col-sm-3">
        {!! Form::select('', [
            '0' => 'Нет',
            '1' => 'Нормальная',
            '2' => 'Полная',
        ], $val, [
            'name' => 'answer[association]['.$answerId.']['.$resultId.']',
            'data-placeholder' => 'Выберите связь',
            'style' => 'width: 100%',
        ]) !!}
    </div>
    <div class="col-sm-9">
        <span class="result-title">{{ $title }}</span>
    </div>
</div>
