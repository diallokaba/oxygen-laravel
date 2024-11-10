<?php

namespace App\Services;
use GuzzleHttp\Client;

class UploadImageWithImgUr{

    protected static $clientId;
    public static function initialize(){
        self::$clientId = env('IMGUR_CLIENT_ID');
    }

    public static function uploadImage($imagePath){
        if (!self::$clientId) {
            self::initialize();
        }
        $client = new Client();
        try {
            $response = $client->request('POST','https://api.imgur.com/3/image', [
                'headers' => [
                    'Authorization' => 'Client-ID '. self::$clientId
                ],
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($imagePath, 'r')
                    ]
                ]
            ]);
    
            $body = json_decode((string)$response->getBody());
    
            if ($body && $body->success) {
                return $body->data->link ?? null;
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Si le code de réponse est 429, cela signifie que nous avons dépassé la limite
            if ($e->getResponse()->getStatusCode() == 429) {
                // Enregistre localement ou retourne un message d'erreur personnalisé
                return 'Erreur: Limite de requêtes atteinte';
            }
        }
    
        return null;
    }
    
}