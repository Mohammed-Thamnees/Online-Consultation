<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreValidate extends FormRequest
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
            'patient' => 'required|integer',
            'date' => 'required|date',
            'category_id' => 'required|integer',
            'doctor_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'patient.required' => 'please select any patient',
            'patient.integer' => 'patient value must be integer',
            'date.required' => 'please select the appointment date',
            'date.date' => 'this is not a valid date',
            'category_id.required' => 'please select the doctor category',
            'category.integer' => 'category value must be integer',
            'doctor_id.required' => 'please select any doctor',
            'doctor_id.integer' => 'the doctor value must be a integer'
        ];
    }

}
