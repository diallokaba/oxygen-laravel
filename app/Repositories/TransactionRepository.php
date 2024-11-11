<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\Transaction;

class TransactionRepository implements ITransactionRepository{

    public function save(array $data){
        return Transaction::create($data);
    }

    public function update(int $id, array $data){
        return Transaction::where('id', $id)->update($data);
    }

    public function delete(int $id){
        return Transaction::where('id', $id)->delete();
    }

    public function findAll(){
        return Transaction::all();
    }

    public function findById(int $id){
        return Transaction::find($id);
    }
}