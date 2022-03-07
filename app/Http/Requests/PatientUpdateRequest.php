<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'jmbg' => ['sometimes', 'string', 'size:13', 'regex:/^[0-9]+$/'],
            'note' => ['sometimes', 'string', 'max:2000'],
            'location_id' => ['sometimes', 'integer', 'exists:locations,id'],
        ];
    }
}
