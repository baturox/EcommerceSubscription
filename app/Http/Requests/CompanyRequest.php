<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'site_url' => 'required|max:255',
            'name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'company_name' => 'required|max:255',
            'email' => 'required|unique:companies',
            'password' => 'required|min:6',
        ];
    }
}
