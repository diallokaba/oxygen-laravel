<?php

namespace App\Services;

interface IFavorisService{
    public function save(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function findAll();
    public function findById(int $id);
}