<?php

namespace App\Services;

use App\Repositories\IFavorisRepository;

class FavorisService implements IFavorisService
{
    private IFavorisRepository $favorisRepository;
    public function __construct(IFavorisRepository $favorisRepository){
        $this->favorisRepository = $favorisRepository;
    }
    public function save(array $data)
    {
        return $this->favorisRepository->save($data);
    }
    public function update(int $id, array $data)
    {
        return $this->favorisRepository->update($id, $data);
    }
    public function delete(int $id)
    {
        return $this->favorisRepository->delete($id);
    }
    public function findAll()
    {
        return $this->favorisRepository->findAll();
    }
    public function findById(int $id)
    {
        return $this->favorisRepository->findById($id);
    }
}