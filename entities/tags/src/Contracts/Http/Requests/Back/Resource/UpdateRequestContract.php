<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource;

interface UpdateRequestContract
{
    public function authorize(): bool;

    public function messages(): array;

    public function rules(): array;
}
