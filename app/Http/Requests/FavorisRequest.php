<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FavorisRequest extends FormRequest
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
                'user_id' => 'required|exists:users,id',
                'phone_number' => [
                    'required',
                    'string',
                    'unique:favorites,phone_number,NULL,id,user_id,' . $this->user_id,
                ],
            ];
           }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Le champ user_id est requis.',
            'phone_number.required' => 'Le champ phone_number est requis.',
            'phone_number.unique' => 'Le numéro de téléphone existe déjà dans votre liste des favoris.',
        ];
    }

    public function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 400));
}
}
