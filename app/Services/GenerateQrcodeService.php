<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateQrcodeService{

    public static function generateQrcode($user){
        // Préparation du dossier temporaire
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        try{
            $qrCodeContent = $user->telephone;
            $qrcode = Builder::create()
                ->writer(new PngWriter())
                ->data($qrCodeContent)
                ->encoding(new Encoding('UTF-8'))
                ->size(300)
                ->build();

             // Génération d'un nom de fichier unique pour le QR code
            $qrcodePath = $tempDir . '/qrcode_' . uniqid() . '.png';
            
            // Sauvegarde du QR code
            $qrcode->saveToFile($qrcodePath);

             // Upload du QR code sur ImgUr
            $imgLink = UploadImageWithImgUr::uploadImage($qrcodePath);
            $user->qrcode = $imgLink;
            $user->save();

            // Génération du PDF
            $pdf = Pdf::loadView('carte-oxygen-pdf', [
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'telephone' => $user->telephone,
                'qrcode' => $qrcodePath
            ])->setPaper('a4', 'portrait');

            // Sauvegarde temporaire du PDF
            $pdfPath = $tempDir . '/qrcode_card_' . uniqid() . '.pdf';
            $pdf->save($pdfPath);

            Mail::to($user->email)->send(new SendMailWithAttachment($user,$pdfPath));

            // Nettoyage des fichiers temporaires
            if (file_exists($qrcodePath)) {
                unlink($qrcodePath);
            }
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }catch (Exception $e) {
            // Log de l'erreur
            Log::error('Erreur lors de la génération du QR code : ' . $e->getMessage());
            throw $e;
        }
    }
}