<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            //'email_or_telephone' =>'required|string|email|exists:users,email|exists:users,telephone',
            'login' =>'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'L\'email ou le numero de telephone est obligatoire',
            //'email_or_telephone.exists' => 'Cet utilisateur n\'existe pas',
            'password.required' => 'Le mot de passe est obligatoire',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json(['erros' => $validator->errors()], 400));
    }
}
