<?php

namespace InetStudio\Quizzes\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Uploads\Validation\Rules\CropSize;
use InetStudio\Uploads\Validation\Rules\CropRequired;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;

/**
 * Class SaveQuizRequest.
 */
class SaveQuizRequest extends FormRequest implements SaveQuizRequestContract
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
            'quiz_type.required' => 'Поле «Тип теста» обязательно для заполнения',
            'title.required' => 'Поле «Заголовок» обязательно для заполнения',
            'title.max' => 'Поле «Заголовок» не должно превышать 255 символов',

            'preview.filename.required' => 'Поле «Превью» обязательно для заполнения',
            'preview.crop.album.required' => 'Необходимо выбрать область отображения «Альбомная ориентация»',
            'preview.crop.album.json' => 'Область отображения «Альбомная ориентация» должна быть представлена в виде JSON',

            'result_type.required' => 'Поле «Тип результата» обязательно для заполнения',
            'result.preview.*.crop.album.required' => 'Необходимо выбрать область отображения «Альбомная ориентация»',
            'result.preview.*.crop.album.json' => 'Область отображения «Альбомная ориентация» должна быть представлена в виде JSON',
            'result.min_points.*.integer' => 'Поле «Минимум баллов» должно содержать целое положительное число',
            'result.max_points.*.integer' => 'Поле «Максимум баллов» должно содержать целое положительное число',

            'question.preview.*.crop.album.required' => 'Необходимо выбрать область отображения «Альбомная ориентация»',
            'question.preview.*.crop.album.json' => 'Область отображения «Альбомная ориентация» должна быть представлена в виде JSON',

            'question.preview.*.crop.portrait.required' => 'Необходимо выбрать область отображения «Портретная ориентация»',
            'question.preview.*.crop.portrait.json' => 'Область отображения «Портретная ориентация» должна быть представлена в виде JSON',

            'question.preview.*.crop.square.required' => 'Необходимо выбрать область отображения «Квадратное изображение»',
            'question.preview.*.crop.square.json' => 'Область отображения «Квадратное изображение» должна быть представлена в виде JSON',

            'answer.preview.*.crop.album.required' => 'Необходимо выбрать область отображения «Альбомная ориентация»',
            'answer.preview.*.crop.album.json' => 'Область отображения «Альбомная ориентация» должна быть представлена в виде JSON',
            'answer.points.*.integer' => 'Поле «Количество баллов» должно содержать целое положительное число',
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
            'quiz_type' => 'required',
            'title' => 'required|max:255',
            'preview.filename' => 'required',
            'preview.crop.album' => [
                'required', 'json',
                new CropSize(392, 294, 'min', 'Альбомная ориентация'),
            ],
            'result_type' => 'required',

            'result.preview.*.crop' => [
                new CropRequired,
            ],
            'result.preview.*.crop.album' => [
                'nullable', 'json',
                new CropSize(448, 336, 'min', 'Альбомная ориентация'),
            ],
            'result.min_points.*' => 'nullable|integer',
            'result.max_points.*' => 'nullable|integer',

            'question.preview.*.crop' => [
                new CropRequired,
            ],
            'question.preview.*.crop.album' => [
                'nullable', 'json',
                new CropSize(448, 336, 'min', 'Альбомная ориентация'),
            ],
            'question.preview.*.crop.portrait' => [
                'nullable', 'json',
                new CropSize(448, 620, 'min', 'Портретная ориентация'),
            ],
            'question.preview.*.crop.square' => [
                'nullable', 'json',
                new CropSize(448, 448, 'min', 'Квадратное изображение'),
            ],

            'answer.preview.*.crop' => [
                new CropRequired,
            ],
            'answer.preview.*.crop.album' => [
                'nullable', 'json',
                new CropSize(190, 178, 'min', 'Альбомная ориентация'),
            ],
            'answer.points.*' => 'nullable|integer',
        ];
    }
}
