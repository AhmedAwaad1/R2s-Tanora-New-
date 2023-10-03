<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name'=> 'required',
            'address' => 'required|max:300',
            'phone' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'date' => 'required|date|after:' . date('Y-m-d'),
            'time' => 'required|in:8-12,3-6'

        ];
    }
}
