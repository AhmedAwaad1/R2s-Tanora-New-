<?php

namespace App\Http\Requests\Product;

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
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'price' => ['required', 'numeric', 'between:1,99999999'],
            'category_id'=> ['required', 'exists:categories,id']
        ];
    }
}
