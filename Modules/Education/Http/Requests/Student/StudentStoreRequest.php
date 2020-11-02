<?php

namespace Modules\Education\Http\Requests\Student;

use App\Rules\ValidaCpf;
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
     * To replace the attribute name in the error message.
     */
    public function attributes()
    {
        return [
            'academic_record' => 'RA'
        ];
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
			'email' => 'required|string|max:255|email|unique:students',
			'academic_record' => 'required|unique:students',
			'cpf' => ['required', 'unique:students', 'string', 'max:14', new ValidaCpf]
        ];
    }
}
