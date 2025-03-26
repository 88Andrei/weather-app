<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirDataRequest extends FormRequest
{

    public function rules()
    {
        return [
            'city' => 'required|string',
            'dateFrom' => 'required|date_format:Y-m-d',
            'dateTo' => 'required|date_format:Y-m-d|after_or_equal:dateFrom',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
