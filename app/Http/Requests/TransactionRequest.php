<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionRequest extends FormRequest
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
            'sender_id' => 'required|exists:users,id',
            'receiver_phone' => 'required|string|exists:users,telephone',
            'amount' => 'required|numeric|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'sender_id.required' => 'L\'ID de l\'expéditeur est requis.',
            'sender_id.exists' => 'L\'expéditeur n\'existe pas.',
            'receiver_phone.required' => 'Le numéro du destinataire est requis.',
            'receiver_phone.exists' => 'Le destinataire n\'existe pas dans notre système.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant doit être au moins de 1.'
        ];
    }
    
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json(['erros' => $validator->errors()], 400));
    }

}
