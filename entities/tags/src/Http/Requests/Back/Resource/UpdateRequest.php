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
            'alias.required' => 'Поле «Алиас» обязательно для заполнения',
            'alias.max' => 'Поле «Алиас» не должно превышать 255 символов',
            'alias.unique' => 'Такое значение поля «Алиас» уже существует',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'alias' => 'required|max:255|unique:quizzes_tags,alias,'.$this->input('id'),
        ];
    }
}
