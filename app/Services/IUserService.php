<?php

namespace App\Services;

interface IUserService
{
    public function save(array $data);
    public function update(int $id, array $data);
    public function findByEmailOrTelephone(string $email, string $telephone);
    public function findAll();
    public function findById(int $id);
}

