<?php
require __DIR__ . '/vendor/autoload.php';

$secret = $_POST["secret"];
$password = $_POST["password"];
$image = $_FILES["image"];
$stegoContainer = new Picamator\SteganographyKit\StegoContainer();
$stegoSystem    = new Picamator\SteganographyKit\StegoSystem\SecretLsb();

// configure secret key
$secretKey = intval($password);
$stegoKey  = new Picamator\SteganographyKit\StegoKey\RandomKey($secretKey);

$stegoSystem->setStegoKey($stegoKey);
$stegoContainer->setStegoSystem($stegoSystem);

// it's not necessary to set second parameter if result will put in stream 
$stegoContainer->encode($image['tmp_name'], '', $secret);

// // output raw image
header('Content-Type: image/png');
header("Content-Disposition: attachment; filename=encoded.png");
$stegoContainer->renderImage();