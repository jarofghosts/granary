<?php

class Bernie {

    static $image;
    static $location;
    static $image_type;
    static $directory = './public/';

    public static function migrate($uri, $save_path = "basement/")
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

        public static function nresize($file, $width, $height)
        {
            $image = new Imagick($file); 

            $image = $image->coalesceImages(); 

        foreach ($image as $frame) { 
              $frame->setImagePage($width, $height, 0, 0); 
          } 

          $image = $image->deconstructImages(); 
          $image->writeImages($file, true);
      }

      public static function generate_filename($uri)
      {

        $new_file = preg_replace('/\W+/', '-', substr(Hash::make(time() . $uri), 10));
        $new_file = strtolower(trim($new_file, '-'));

        switch (substr($uri, -3)) {
            case 'jpg':
            case 'peg':
            return $new_file . '.jpg';
            break;
            case 'png':
            return $new_file . '.png';
            break;
            case 'gif':
            return $new_file . '.gif';
            break;
            default:
            return "Unsupported.";
            break;
        }

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

    public static function formatSmiley($filename)
    {
        self::load($filename);

        self::resizeToHeight(20);

        self::save($filename);
    }

    public static function load($filename)
    {
        if (substr($filename, 0, 1) === '/') {
            $filename = substr($filename, 1);
        }
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

        self::$location = $filename;

    }

    public static function save($filename, $compression = 75, $permissions = null)
    {

        $filename = self::$directory . $filename;

        if (self::$image_type == IMAGETYPE_JPEG) {
            imagejpeg(self::$image, $filename, $compression);
        } elseif (self::$image_type == IMAGETYPE_GIF) {

            imagegif(self::$image, $filename);
        } elseif (self::$image_type == IMAGETYPE_PNG) {

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

        if(!list($w, $h) = getimagesize(self::$location)) return "Unsupported picture type!";

        $type = strtolower(substr(strrchr(self::$location,"."),1));
        if($type == 'jpeg') $type = 'jpg';

        switch($type){

            case 'bmp': $img = imagecreatefromwbmp(self::$location); break;
            case 'gif': $img = imagecreatefromgif(self::$location); break;
            case 'jpg': $img = imagecreatefromjpeg(self::$location); break;
            case 'png': $img = imagecreatefrompng(self::$location); break;
            default : return "Unsupported picture type!";

        }

        if($w < $width and $h < $height) return "Picture is too small!";
        $ratio = min($width/$w, $height/$h);
        $width = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;

        $new = imagecreatetruecolor($width, $height);

  // preserve transparency
        if($type == "gif" or $type == "png"){
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

        switch ($type) {
            case 'bmp': imagewbmp($new, self::$location); break;
            case 'gif': imagegif($new, self::$location); break;
            case 'jpg': imagejpeg($new, self::$location); break;
            case 'png': imagepng($new, self::$location); break;
        }
        return true;
    }

}