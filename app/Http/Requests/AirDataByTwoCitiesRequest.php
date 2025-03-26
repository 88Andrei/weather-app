<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirDataByTwoCitiesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city1' => 'required|string|max:255',
            'city2' => 'required|string|max:255|different:city1',
            'dateFrom' => 'required|date_format:Y-m-d',
            'dateTo' => 'required|date_format:Y-m-d|after_or_equal:dateFrom',
        ];
    }
}
