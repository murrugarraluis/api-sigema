<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
//        TODO:
//          -VALIDATE UUIDS
//          -VALIDATE TYPES
//          -VALIDATE UUIDS EXIST IN TABLES
//
        return [
            "name" => "required",
            "brand" => 'required',
            "model" => 'required',
            "quantity" => 'required',
            "article_type" => [
                'id' => 'required',
            ],
            "suppliers" => [
                '*' => [
                    'id' => 'required',
                    'price' => 'required'
                ],
            ],
        ];
    }
}
