<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceStoreRequest extends FormRequest
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
			'employees' => ['bail', 'required', 'array'],
			'employees.*.id' => ['bail', 'required', 'uuid', 'exists:employees,id'],
			'turn' => ['bail', 'required', 'string', "in:day,night"],
		];
	}
}
