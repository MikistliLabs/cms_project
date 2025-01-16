<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir la validación en todas las peticiones
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required',
            'email' => 'required',
            'role_id' => 'required',
        ];
    }

}
