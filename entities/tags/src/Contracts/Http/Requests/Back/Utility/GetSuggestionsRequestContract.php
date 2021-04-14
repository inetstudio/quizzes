<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility;

interface GetSuggestionsRequestContract
{
    public function authorize(): bool;

    public function messages(): array;

    public function rules(): array;
}
