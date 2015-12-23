<?php
/**
 * Class KYImages
 *
 * Делает ресайз изображения
 * http://sanchiz.net/blog/resizing-images-with-php
 *
 *
 * Пример использования:
 *  Сохранение файла с пропорциями - по ширине 150px
    $this->load($this->patch.$this->file);
    $this->resizeToWidth(150);
    $this->save($this->patch.'chunks/'.'small-'.$this->file);
 *  Сохранение файла с изменением в %ах от исходного
    $this->scale(50);
 *  Сохранение файла с указаным шириной и высотой
    $this->resize(400, 200);
 *
 */
class KYImages extends CWidget
{

    public $patch;
    public $file;
    private  $image;
    private  $image_type;

    function run()
    {
        $tempFolder = Yii::app()->basePath . '/../'.SITE_PUBLIC_NAME;

        $this->load($tempFolder.$this->patch.$this->file);
        $this->resizeToWidth(150);
        $newPatch = $this->patch.'chunks/';
        $newFile = 'small-'.$this->file;
        if ( $this->save($tempFolder.$newPatch.$newFile) ){ return array('filename'=>$newFile, 'patch'=>$newPatch); }
        else { return false; }

    }

    function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
        $flag = false;
        if( $image_type == IMAGETYPE_JPEG ) {
            if ( imagejpeg($this->image,$filename,$compression) ) { $flag = true; }
        } elseif( $image_type == IMAGETYPE_GIF ) {
            if (  imagegif($this->image,$filename) ) { $flag = true; }
        } elseif( $image_type == IMAGETYPE_PNG ) {
            if (  imagepng($this->image,$filename) ) { $flag = true; }
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
        return $flag;
    }
    function output($image_type=IMAGETYPE_JPEG) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image);
        }
    }
    function getWidth() {
        return imagesx($this->image);
    }
    function getHeight() {
        return imagesy($this->image);
    }
    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }
    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }
    function scale($scale) {
        $width = $this->getWidth() * $scale/100;
        $height = $this->getheight() * $scale/100;
        $this->resize($width,$height);
    }
    function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }


}