<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Data;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;

class GetIndexDataRequest extends FormRequest implements GetIndexDataRequestContract
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
