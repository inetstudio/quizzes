<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Utility;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsChildrenRequestContract;

class GetSuggestionsChildrenRequest extends FormRequest implements GetSuggestionsChildrenRequestContract
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }
}
