<?php

namespace Modules\Education\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
			'name' => 'required|string|max:255',
			'email' => 'required|string|max:255|email',
			'academic_record' => 'required',
			'cpf' => 'required|string|max:255',
        ];
    }
}
