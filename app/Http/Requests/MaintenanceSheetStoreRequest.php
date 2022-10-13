<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceSheetStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "date" => ['bail', 'required', 'date_format:Y-m-d'],
            "responsible" => ['bail', 'required', 'string'],
            "technical" => ['bail', 'required', 'string'],
            "description" => ['bail', 'nullable', 'string'],
            'maintenance_type' => ['bail', 'nullable', 'array'],
            'maintenance_type.id' => ['bail', 'required', 'uuid', 'exists:maintenance_types,id'],
            'supplier' => ['bail', 'nullable', 'array'],
            'supplier.id' => ['bail', 'required', 'uuid', 'exists:suppliers,id'],
            'machine' => ['bail', 'nullable', 'array'],
            'machine.id' => ['bail', 'required', 'uuid', 'exists:machines,id'],

            "detail" => ['bail', 'required', 'array'],
            "detail.*.article" => ['bail', 'nullable', 'array'],
            "detail.*.article.id" => ['bail', 'nullable', 'uuid', 'exists:articles,id'],
            "detail.*.description" => ['bail', 'nullable', 'string'],
            "detail.*.price" => ['bail', 'nullable', 'numeric'],
            "detail.*.quantity" => ['bail', 'nullable', 'numeric'],
        ];
    }
}
