<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;

class GenerateQrcodeService{

    public static function generateQrcode($user){
        $qrCodeContent = $user->telephone;
        $qrcode = Builder::create()
            ->writer(new PngWriter())
            ->data($qrCodeContent)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->build();

        $qrcodePath = storage_path('app/temp/qrcode_' . uniqid() . '.png');
        $qrcode->saveToFile($qrcodePath);

        
        // Chemin pour enregistrer le QR code temporaire
        $tempDir = storage_path('app/temp'); // Utilisation de storage_path() pour obtenir le chemin absolu
        $qrTempPath = $tempDir . '/qrcode_' . uniqid() . '.png';

        // Vérifiez si le répertoire existe, sinon créez-le
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true); // Créez le répertoire s'il n'existe pas
        }

        // Enregistrer le QR code temporaire
        file_put_contents($qrTempPath, $qrcode->getString()); // Utilisation de file_put_contents() pour écrire le fichier

        $imgLink = UploadImageWithImgUr::uploadImage($qrTempPath);
        $user->qrcode = $imgLink;
        $user->save();

        $pdf = Pdf::loadView('carte-oxygen-pdf', [
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'telephone' => $user->telephone,
            'qrcode' => $qrTempPath
        ])->setPaper('a4', 'portrait');

        // Définir le chemin temporaire du PDF
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true); // Créez le répertoire s'il n'existe pas
        }

        // Sauvegarde temporaire du PDF
        $pdfPath = $tempDir . '/fidelite_card_' . uniqid() . '.pdf';
        $pdf->save($pdfPath);

        Mail::to($user->email)->send(new SendMailWithAttachment($user,$pdfPath));
    }
}