<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\UpdateRequestContract;

class UpdateRequest extends FormRequest implements UpdateRequestContract
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле «Название» обязательно для заполнения',
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
        ];
    }
}
