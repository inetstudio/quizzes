<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Data;

interface GetIndexDataRequestContract
{
    public function authorize(): bool;

    public function messages(): array;

    public function rules(): array;
}
