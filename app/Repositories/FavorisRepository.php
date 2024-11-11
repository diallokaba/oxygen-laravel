<?php

namespace App\Repositories;

use App\Models\Favorite;

class FavorisRepository implements IFavorisRepository{

    public function save(array $data){
        return Favorite::create($data);
    }

    public function update(int $id, array $data){
        return Favorite::where('id', $id)->update($data);
    }

    public function delete(int $id){
        return Favorite::where('id', $id)->delete();
    }

    public function findAll(){
        return Favorite::all();
    }

    public function findById(int $id){
        return Favorite::find($id);
    }
}