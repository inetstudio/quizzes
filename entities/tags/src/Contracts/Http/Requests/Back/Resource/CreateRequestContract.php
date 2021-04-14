<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource;

interface CreateRequestContract
{
    public function authorize(): bool;

    public function messages(): array;

    public function rules(): array;
}
