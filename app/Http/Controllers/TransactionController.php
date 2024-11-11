<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\ITransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    private $transactionService;
    public function __construct(ITransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    
    public function store(TransactionRequest $request): JsonResponse
    {
        // Récupérer les données de la transaction validées
        $data = $request->validated();

        try {
            // Appeler le service de transaction pour enregistrer la transaction
            $transaction = $this->transactionService->save($data);

            // Vérifier si la transaction a échoué
            if ($transaction->status === 'ECHOUER') {
                return response()->json(['error' => 'La transaction a échoué. Vérifiez le solde ou le destinataire.'], 400);
            }

            // Retourner le résultat
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            // Gérer les exceptions et retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la transaction.', 'message' => $e->getMessage()], 500);
        }
    }
}
