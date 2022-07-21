<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseCategoryRequest extends FormRequest
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
            'name' => 'required|unique:expense_categories,name',
            'status' => 'required|in:Active,DeActive',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'please enter name',
            'name.unique' => 'this name already exists,please try another!!',
            'status.required' => 'please select status',
            'status.in' => 'please select form list'

        ];
    }
}
