<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir la validación en todas las peticiones
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:pgsql_read.categories,id',
            'status' => 'integer',
        ];
    }

}
