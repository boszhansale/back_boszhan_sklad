<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CouplingStoreRequest extends FormRequest
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
            'formula_id' => ['required','exists:formulas,id'],
            'box_id' => ['required','exists:boxes,id'],
            'count' => ['required'],

            'boxes' => ['required','array','min:1'],
            'boxes.*' => ['exists:boxes,id'],

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
