<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__. '/include/crypt.php';
use Intervention\Image\ImageManagerStatic as Image;
$secret = $_POST["secret"];
$password = $_POST["password"];
$image = $_FILES["image"];
var_dump($image);
$cipher = "aes-128-gcm";
$image = Image::make($image["tmp_name"])->encode("jpeg");
$encodedImage = $image->save(sys_get_temp_dir().DIRECTORY_SEPARATOR.'encoded'.uniqid().'.jpg');
$encodedImagePath = $encodedImage->dirname.DIRECTORY_SEPARATOR.$encodedImage->basename;
    $ciphertext = Crypt::encrypt($secret,$password);
    $tmpfname = tempnam(sys_get_temp_dir(), "secretMessage");
    $handle = fopen($tmpfname, "w");
    fwrite($handle, $ciphertext);
    fclose($handle);
    $tmpimg = tempnam(sys_get_temp_dir(),"outputImage");
    if(PHP_OS === "Linux"){
        $command = "/var/www/html/jsteg hide $encodedImagePath $tmpfname $tmpimg";
    }
    else{
        $command = "jsteg.exe hide $encodedImagePath $tmpfname $tmpimg";
    }
    exec($command);
    unlink($tmpfname);
    unlink($encodedImagePath);
    header("Content-Type: image/jpeg");
    header("Content-Disposition: attachment; filename=encoded.jpg");
    readfile($tmpimg);
    unlink($tmpimg);
