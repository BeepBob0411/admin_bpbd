<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|nullable|string|min:8',
            'nik' => 'required|digits:16|integer|unique:users,nik,' . $this->route('user'),
            'phone' => 'required|integer',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }
}
