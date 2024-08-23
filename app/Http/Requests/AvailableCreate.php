<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableCreate extends FormRequest
{
    public function rules()
    {
        return [
            'good_id' => 'required',
            'type_parts_by' => 'integer|required',
            'count' => 'required|integer',
            'price' => 'required|numeric',
            'residue' => 'sometimes|nullable|integer',
            'comment' => 'sometimes|nullable|string'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
