<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'jmbg' => ['required', 'string', 'size:13', 'regex:/^[0-9]+$/'],
            'note' => ['sometimes', 'string', 'max:2000'],
            // 'location_id' => ['required', 'integer', 'exists:locations,id'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:100'],

        ];
    }
    public function messages()
    {
        return [
            'location_id.required' => "Loacation is required",
        ];
    }
}
