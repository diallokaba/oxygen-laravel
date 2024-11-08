<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private IUserService$userService;
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(UserRequest $userRequest){
        // Create user in your database
        $user = $this->userService->save($userRequest->validated());

        // Generate QR code for the user
        //$qrcode = $this->generateQrCode($user);

        // Update the user's qrcode in the database
        //$user->qrcode = $qrcode;
        //$user->save();

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
    }
}
