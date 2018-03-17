<?php

namespace InetStudio\Quizzes\Http\Requests\Front;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Quizzes\Contracts\Http\Requests\Front\SendResultToEmailRequestContract;

/**
 * Class SendResultToEmailRequest.
 */
class SendResultToEmailRequest extends FormRequest implements SendResultToEmailRequestContract
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
            'quiz_id.required' => 'Параметр quiz_id является обязательным',
            'quiz_id.integer' => 'Параметр quiz_id должен быть целым положительным числом',
            'quiz_id.exists' => 'Тест с указанным параметром quiz_id не существует',

            'result_id.required' => 'Параметр result_id является обязательным',
            'result_id.integer' => 'Параметр result_id должен быть целым положительным числом',
            'result_id.exists' => 'Результат с указанным параметром result_id не существует',

            'current_url.required' => 'Параметр current_url является обязательным',
            'current_url.url' => 'Параметр current_url содержит значение в некорректном формате',

            'email.required' => 'Параметр email является обязательным',
            'email.array' => 'Параметр email содержит значение в некорректном формате',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @param Request $request
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'quiz_id' => 'required|integer|exists:quizzes,id',
            'result_id' => [
                'required', 'integer',
                Rule::exists('quizzes_results', 'id')->where(function ($query) use ($request) {
                    $query->where('quiz_id', $request->get('quiz_id'));
                }),
            ],
            'current_url' => 'required|url',
            'email' => 'required|email',
        ];
    }
}
