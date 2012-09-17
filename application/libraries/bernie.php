<?php

class Bernie {

    static $image;
    static $image_type;
    static $directory = './public/';

    public static function migrate($uri = null, $save_path = "basement/")
    {

        $local_path = "./public/";

        $new_file = self::generate_filename($uri);

        $file = fopen($uri, "rb");
        if ($file) {
            $newf = fopen($local_path . $save_path . $new_file, "w+");

            if ($newf)
                while (!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
        }

        if ($file) {
            fclose($file);
        }

        if ($newf) {
            fclose($newf);
        }
        
        self::load($save_path . $new_file);
        
        return "/" . $save_path . $new_file;

    }

    public static function generate_filename($uri)
    {

        $new_file = preg_replace('/\W+/', '-', substr(Hash::make(time() . $uri), 10));
        $new_file = strtolower(trim($new_file, '-'));
        switch (self::$image_type) {
            
            case 'IMAGETYPE_JPEG' :
                $new_file .= '.jpg';
                break;
            case 'IMAGETYPE_GIF' :
                $new_file .= '.gif';
                break;
            case 'IMAGETYPE_PNG' :
                $new_file .= '.png';
                break;
            default :
                $new_file .= '.jpg';
                break;

        }

        return $new_file;

    }

    public static function format($filename)
    {
        self::load($filename);
        
        if (self::getHeight() > self::getWidth() && self::getHeight() > 320) {

            self::resizeToHeight(320);

        } elseif (self::getWidth() > self::getHeight() && self::getWidth() > 320) {

            self::resizeToWidth(320);

        }

        self::save($filename);

    }

    public static function load($filename)
    {

        $filename = self::$directory . $filename;
        $image_info = getimagesize($filename);
        self::$image_type = $image_info[2];
        if (self::$image_type == IMAGETYPE_JPEG) {

            self::$image = imagecreatefromjpeg($filename);
        } elseif (self::$image_type == IMAGETYPE_GIF) {

            self::$image = imagecreatefromgif($filename);
        } elseif (self::$image_type == IMAGETYPE_PNG) {

            self::$image = imagecreatefrompng($filename);
        }

    }

    public static function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
    {

        $filename = self::$directory . $filename;
        
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg(self::$image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {

            imagegif(self::$image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {

            imagepng(self::$image, $filename);
        }
        if ($permissions != null) {

            chmod($filename, $permissions);
        }

    }

    public static function output($image_type = IMAGETYPE_JPEG)
    {

        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg(self::$image);
        } elseif ($image_type == IMAGETYPE_GIF) {

            imagegif(self::$image);
        } elseif ($image_type == IMAGETYPE_PNG) {

            imagepng(self::$image);
        }

    }

    public static function getWidth()
    {

        return imagesx(self::$image);

    }

    public static function getHeight()
    {

        return imagesy(self::$image);

    }

    public static function resizeToHeight($height)
    {

        $ratio = $height / self::getHeight();
        $width = self::getWidth() * $ratio;
        self::resize($width, $height);

    }

    public static function resizeToWidth($width)
    {
        $ratio = $width / self::getWidth();
        $height = self::getheight() * $ratio;
        self::resize($width, $height);

    }

    public static function scale($scale)
    {
        $width = self::getWidth() * $scale / 100;
        $height = self::getheight() * $scale / 100;
        self::resize($width, $height);

    }

    public static function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, self::$image, 0, 0, 0, 0, $width, $height, self::getWidth(), self::getHeight());
        self::$image = $new_image;

    }

}
