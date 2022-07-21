<?php

namespace App\Http\Requests\admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
        $customers = User::where('status','Active')->pluck('id')->toArray();
        return [
            'customer_id'=>'required|in:'.implode(',', $customers),
            "title"=>'required',
            "details"=>'required',
            "status"=>'required',
        ];
    }
}