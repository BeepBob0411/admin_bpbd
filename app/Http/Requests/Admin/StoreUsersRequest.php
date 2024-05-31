<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/|unique:users,email',
            'password' => 'required|string|min:8',
            'nik' => 'required|digits:16|integer|unique:users,nik',
            'phone' => 'required|integer',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }
}
