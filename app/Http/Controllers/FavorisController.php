<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavorisRequest;
use App\Services\IFavorisService;
use App\Services\IUserService;
use Illuminate\Http\Request;

class FavorisController extends Controller
{

    private $favorisService;
    private $userService;
    public function __construct(IFavorisService $favorisService, IUserService $userService)
    {
        $this->favorisService = $favorisService;
        $this->userService = $userService;
    }
    public function index(){

    }

    public function store(FavorisRequest $request)
    {
        $data = $request->validated(); 
        $phoneNumber = $data['phone_number'];
        $user = $this->userService->findByPhoneNumber($phoneNumber);
        
        if (!$user) {
            return response()->json(['error' => 'Ce numéro n\'existe pas dans notre système'], 404);
        }
        
        $data['name'] = "{$user->nom} {$user->prenom}";
        $favoris = $this->favorisService->save($data);
        
        return response()->json($favoris, 201);
    }
    
}
