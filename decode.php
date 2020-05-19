<?php
require __DIR__ . '/vendor/autoload.php';

$password = $_POST["password"];
$image = $_FILES["image"];

$stegoContainer = new Picamator\SteganographyKit\StegoContainer();
$stegoSystem    = new Picamator\SteganographyKit\StegoSystem\SecretLsb();

// configure secret key
$secretKey = intval($password);
$stegoKey  = new Picamator\SteganographyKit\StegoKey\RandomKey($secretKey);

$stegoSystem->setStegoKey($stegoKey);
$stegoContainer->setStegoSystem($stegoSystem);

// stego-image.png
$secretText = $stegoContainer->decode($image['tmp_name']);

echo "Secret message : ".$secretText;
?>
<br/><a href="decode.html">Decode a new image</a>