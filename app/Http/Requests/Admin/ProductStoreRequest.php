<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'article' => 'unique:products',
            'category_id' => '',
            'id_1c' => '',
            'measure' => '',
            'name' => '',
            'barcode' => '',
            'remainder' => '',
            'enabled' => '',
            'presale_id' => '',
            'discount' => '',
            'rating' => '',

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
