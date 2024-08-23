<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsCreate extends FormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|string',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'inn' => 'sometimes|nullable|string',
            'fio' => 'required|string',
            'company_name' => 'exclude_if:type,1|required|string',
            'address' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email',
            'gender' => 'sometimes|nullable|integer'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
