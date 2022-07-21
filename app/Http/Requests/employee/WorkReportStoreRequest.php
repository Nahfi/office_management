<?php

namespace App\Http\Requests\employee;

use Illuminate\Foundation\Http\FormRequest;

class WorkReportStoreRequest extends FormRequest
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
            'title'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' =>'please enter report title',
        ];
    }
}
