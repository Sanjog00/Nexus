<?php

namespace app\components;

use Yii;
use yii\base\Component;

class ProfilePictureGenerator extends Component
{
    public static function generate($fullName, $username)
    {

        $firstLetter = strtoupper(substr($fullName, 0, 1));


        $image = imagecreatetruecolor(100, 100);

        $bgColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefill($image, 0, 0, $bgColor);
        $textColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));

        // Add the first letter to the image
        $fontPath = Yii::getAlias('@webroot/fonts/ARIAL.TTF'); // Path to your font file
        $fontSize = 40;
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $firstLetter);
        $x = (imagesx($image) - ($bbox[2] - $bbox[0])) / 2;
        $y = (imagesy($image) - ($bbox[5] - $bbox[1])) / 2;


        imagettftext($image, $fontSize, 0, (int)$x, (int)$y, $textColor, $fontPath, $firstLetter);

        $fileName = 'profile_' . ($username) . '.png';
        $filePath = Yii::getAlias('@webroot/uploads/profile_pictures/' . $fileName);

        if (!file_exists(Yii::getAlias('@webroot/uploads/profile_pictures'))) {
            mkdir(Yii::getAlias('@webroot/uploads/profile_pictures'), 0777, true);
        }

        // Save the image to the file system
        imagepng($image, $filePath);

        // Free up memory
        imagedestroy($image);

        // Return the URL of the image, which can be used in the frontend
        return '/uploads/profile_pictures/' . $fileName;
    }
}
