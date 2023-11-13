<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CollectingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'store_id' => ['required'],
            'driver_id' => ['required'],
            'products' => ['required'],
            'products.*.product_id' => ['required','exists:products,id'],
            'products.*.count' => ['required'],
            'products.*.sell_count' => ['required'],

        ];
    }
    public function messages()
    {
        return [
            'login.exists' => 'неверный логин',
        ];
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()->first()], 400)
        );
    }
}
