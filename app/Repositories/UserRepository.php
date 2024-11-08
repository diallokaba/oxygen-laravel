<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements IUserRepository{
    public function save(array $data){
        return User::create($data);
    }

    public function update(int $id, array $data){
        return User::where('id', $id)->update($data);
    }

    public function findByEmailOrTelephone(string $email, string $telephone){
        return User::where('email', $email)->orWhere('telephone', $telephone)->first();
    }

    public function findAll(){
        return User::all();
    }
}