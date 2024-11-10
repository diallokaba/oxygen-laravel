<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carte Oxygen</title>
    <style>
    </style>
</head>
<body >
    <h1>Votre carte qrcode de Oxygen</h1>
    <p><strong>Nom et prenom:</strong> {{$nom}} {{$prenom}}</p>
    <p><strong>Téléphone:</strong> {{ $telephone }}</p>
    <img src="{{$qrcode}}" alt="QR Code" style="width: 200px; height: 200px;">
</body>
</html>

