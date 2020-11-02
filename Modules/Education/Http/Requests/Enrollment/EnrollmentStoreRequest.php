<?php

namespace Modules\Education\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentStoreRequest extends FormRequest
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
			'team_id' => 'required|numeric',
			'student_id' => 'required|numeric',
        ];
    }
}
