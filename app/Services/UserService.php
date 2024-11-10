<?php

namespace App\Services;

use App\Models\Wallet;
use App\Repositories\IUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService implements IUserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(array $data)   
    {
        try{
            DB::beginTransaction();

            $user = $this->userRepository->save($data);
            //create wallet for user
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);

            GenerateQrcodeService::generateQrcode($user);

            DB::commit();
            return $user;
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception('Erreur lors de la création de l\'utilisateur : ' . $e->getMessage());
        }
        
    }

    public function update(int $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function findByEmailOrTelephone(string $email, string $telephone)
    {
        return $this->userRepository->findByEmailOrTelephone($email, $telephone);
    }

    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    public function findById(int $id){
        $user = $this->userRepository->findById($id);
        $user->load('wallet');
        return $user;
    }
}