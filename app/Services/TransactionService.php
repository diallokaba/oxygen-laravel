<?php

namespace App\Services;

use App\Repositories\ITransactionRepository;
use App\Repositories\IUserRepository;
use Illuminate\Support\Facades\DB;

class TransactionService implements ITransactionService
{
    private ITransactionRepository $transactionRepository;
    private IUserRepository $userRepository;
    public function __construct(ITransactionRepository $transactionRepository, IUserRepository $userRepository){
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }
    public function save(array $data)
    {
        // Récupérer l'utilisateur expéditeur et vérifier son solde
        $sender = $this->userRepository->findById($data['sender_id']);
        if (!$sender || $sender->wallet->balance < $data['amount']) {
            // Solde insuffisant ou expéditeur introuvable
            $data['status'] = 'ECHOUER';
            return $this->transactionRepository->save($data);
        }

        // Récupérer le destinataire via le numéro de téléphone
        $receiver = $this->userRepository->findByPhoneNumber($data['receiver_phone']);
        if (!$receiver) {
            // Destinataire introuvable
            $data['status'] = 'ECHOUER';
            return $this->transactionRepository->save($data);
        }

        // Débuter une transaction de base de données
        DB::beginTransaction();
        try {
            // Débiter le montant du solde de l'expéditeur
            $sender->wallet->balance -= $data['amount'];
            $sender->wallet->save();

            // Créditer le montant au solde du destinataire
            $receiver->wallet->balance += $data['amount'];
            $receiver->wallet->save();

            // Mettre à jour le statut de la transaction en succès
            $data['status'] = 'SUCCES';

            // Enregistrer la transaction
            $transaction = $this->transactionRepository->save($data);

            // Commit de la transaction
            DB::commit();

            return $transaction;
        } catch (\Exception $e) {
            // En cas d'erreur, rollback de la transaction
            DB::rollBack();
            $data['status'] = 'ECHOUER';

            // Enregistrer la transaction échouée
            return $this->transactionRepository->save($data);
        }
    }
    public function update(int $id, array $data)
    {
        return $this->transactionRepository->update($id, $data);
    }
    public function delete(int $id)
    {
        return $this->transactionRepository->delete($id);
    }
    public function findAll()
    {
        return $this->transactionRepository->findAll();
    }
    public function findById(int $id)
    {
        return $this->transactionRepository->findById($id);
    }
}