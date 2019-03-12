<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManagementService
{

    public function __construct() { }

    function resize_image(UploadedFile $file, $w, $h, $size, $crop = FALSE ) {

        list($width, $height) = getimagesize($file);
        $r = $w / $h;

        if ($crop) {

            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }

            $newWidth = $w;
            $newHeight = $h;

        } else {

            if ($w/$h > $r) {
                $newWidth = $h*$r;
                $newHeight = $h;
            } else {
                $newHeight = $w/$r;
                $newWidth = $w;
            }
        }

        $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
        $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
        $path = $file->getPath();

        if($ext == 'png' || $ext == 'PNG') {
            $src = imagecreatefrompng($file);
        } elseif($ext == 'jpeg'|| $ext == 'jpg' || $ext == 'JPG') {
            $src = imagecreatefromjpeg($file);
        } else {
            $src = imagecreatefromgif($file);
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);

        $finalName = $path . $name . '-' . $size . '.' . $ext;


        if($ext == 'png' || $ext == 'PNG') {

            $background = imagecolorallocate($dst , 0, 0, 0);
            imagecolortransparent($dst , $background);
            imagealphablending($dst, FALSE);
            imagesavealpha($dst, TRUE);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagepng($dst, $finalName, 9);
        } elseif($ext == 'jpeg'|| $ext == 'jpg' || $ext == 'JPG') {
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($dst, $finalName, 100);
        } else {
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagegif($dst, $finalName);
        }

    }

}