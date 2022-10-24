<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenancePDFRequest extends FormRequest
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
            "start_date" => ['bail', 'required', 'date_format:Y-m-d'],
            "end_date" => ['bail', 'required', 'date_format:Y-m-d'],
            'order_by' => ['bail', 'required', 'string', "in:serie_number,machine,amount,maintenance_numbers"],
            "type" => ['bail', 'required', "in:resumen,detail"],
        ];
    }
}
