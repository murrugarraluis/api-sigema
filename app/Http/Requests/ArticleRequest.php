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
        return [
            "name" => ['required', 'string'],
            "brand" => ['required', 'string'],
            "model" => ['required', 'string'],
            "quantity" => ['required', 'numeric', 'min:0'],
            "article_type" => ['required', 'array'],
            "article_type.id" => ['required', 'uuid', 'exists:article_types,id'],
            'suppliers' => ['required', 'array'],
            'suppliers.*.id' => ['required', 'uuid', 'exists:suppliers,id'],
            'suppliers.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
