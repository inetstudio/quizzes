<?php

namespace InetStudio\Quizzes\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizResultRequestContract;

/**
 * Class GetQuizResultRequest.
 */
class GetQuizResultRequest extends FormRequest implements GetQuizResultRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => 'Параметр id является обязательным',
            'id.integer' => 'Параметр id должен быть целым положительным числом',
            'id.exists' => 'Тест с указанным параметром id не существует',

            'answers.required' => 'Параметр answers является обязательным',
            'answers.array' => 'Параметр answers должен быть массивом',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:quizzes',
            'answers' => 'required|array',
        ];
    }
}
