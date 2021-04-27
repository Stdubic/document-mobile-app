<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
			'name' => 'required|max:50',
			'email' => 'required|max:50|email|unique:users',
			'password' => 'required|confirmed|min:'.setting('min_pass_len'),
			'active' => 'boolean',
			'role_id' => 'required|integer|min:1'
        ];
    }
}
