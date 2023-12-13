<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MovingStoreRequest extends FormRequest
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
            'type' => '',
            'status' => '',
            'from_user_id' => '',
            'to_user_id' => '',
            'count' => '',
            'from_box_id' => '',
            'to_box_id' => '',
            'accept_at' => '',
            'reject_at' => '',
            'order_id' => '',
            'products' => 'array'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
