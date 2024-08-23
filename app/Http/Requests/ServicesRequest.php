<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'price' => 'required|integer'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
