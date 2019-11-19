<?php

namespace InetStudio\QuizzesPackage\Quizzes\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Requests\Front\GetDataRequestContract;

/**
 * Class GetDataRequest.
 */
class GetDataRequest extends FormRequest implements GetDataRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id.required' => 'Параметр id является обязательным',
            'id.integer' => 'Параметр id должен быть целым положительным числом',
            'id.exists' => 'Тест с указанным параметром id не существует',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:quizzes',
        ];
    }
}
