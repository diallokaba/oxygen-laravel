<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'nom' => 'required|string|min:2|max:255',
            'prenom' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|unique:users,email',
            'telephone' => 'required|string|min:9|max:255|unique:users,telephone',
            'password' =>'required|string|min:5|max:255',
            'password_confirmation' => 'required_with:password|same:password',
            'role' => 'required|string|in:CLIENT,DISTRIBUTEUR,AGENT,ADMIN,MARCHAND',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'prenom.required' => 'Le prenom est obligatoire',
            'prenom.min' => 'Le prenom doit contenir au moins 2 caractères',
            'prenom.max' => 'Le prenom ne doit pas contenir plus de 255 caractères',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'Cette adresse email existe déjà',
            'telephone.required' => 'Le telephone est obligatoire',
            'telephone.min' => 'Le telephone doit contenir au moins 9 caractères',
            'telephone.max' => 'Le telephone ne doit pas contenir plus de 255 caractères',
            'telephone.unique' => 'Ce numéro de téléphone existe déjà',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 5 caractères',
            'password.max' => 'Le mot de passe ne doit pas contenir plus de 255 caractères',
            'password_confirmation.required_with' => 'La confirmation du mot de passe est requise',
            'password_confirmation.same' => 'La confirmation du mot de passe doit correspondre au mot de passe',
            'role.required' => 'Le role est requis',
            'role.in' => 'Le role doit être CLIENT, DISTRIBUTEUR, AGENT, ADMIN ou MARCHAND',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json(['erros' => $validator->errors()], 400));
    }

}
