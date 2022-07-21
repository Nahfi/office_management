<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:employees,email,'.$this->route('id'),
            'phone' => 'required|unique:employees,phone,'.$this->route('id'),
            'salary' => 'required',
            'national_id' => 'required',
            'address' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'guardian_phone' => 'required',
            'status' => 'required|in:Active,DeActive'

        ];
    }
}