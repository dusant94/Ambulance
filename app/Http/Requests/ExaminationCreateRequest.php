<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationCreateRequest extends FormRequest
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
            'diagnosis' => ['required', 'string', 'max:2000'],
            'parformed' => ['sometimes', 'boolean'],
            'doctor_id' => ['required', 'integer', 'exists:users,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
        ];
    }
}
