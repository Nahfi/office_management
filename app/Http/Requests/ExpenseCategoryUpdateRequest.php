<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseCategoryUpdateRequest extends FormRequest
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
            'name' => 'required|unique:expense_categories,name,'.$this->route('id'),
            'status' => 'required|in:Active,DeActive'
        ];
    }
    public function messages()
    {
        return[
            'name.rquired' => 'please enter status',
            'name.unique' => 'this name already exists, Please try another!!',
            'status.rquired' => 'please select a status',
            'status.in' => 'please select form list'
        ];
    }
}
