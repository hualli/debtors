<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImportRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //'file' => 'required|mimes:txt|max:2048',
            'file' => 'required|max:2048',
        ];
    }

    /**
     * Handles the failure of a request validation
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator  contains the validation errors
     * @throws \Illuminate\Http\Exceptions\HttpResponseException  throws an exception with validation errors
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ]
        ));
    }
}
