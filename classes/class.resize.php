<?php
class resize
{
    public $ext; //extension
    public $image; //image
    public $newimage;
    public $origWidth;
    public $origHeight;
    public $resizeWidth;
    public $resizeHeight;
    public function __construct($filename){ //kiểm tra file tồn tại hay ko nếu có thì set iamge
        if(file_exists($filename)){
            $this->setImage($filename);
        }else{
            throw new Exception("Image could not be found");
        }
    }
    private function setImage($filename){
        $size = getimagesize($filename);
        $this->ext = $size['mime'];
        switch ($this->ext){
            //if image jpg
            case 'image/jpg':
            case 'image/jpeg':
                $this->image = imagecreatefromjpeg($filename);
                break;
            //if image png
            case 'image/png':
                $this->image = imagecreatefrompng($filename);
                break;
            default:
                throw new Exception('File not an image.');
        }
        $this->origHeight = imagesy($this->image);
        $this->origWidth  = imagesx($this->image);

    }
    public function saveImage($savePath, $imageQuality="100"){
        switch ($this->ext){
            case 'image/jpg':
            case 'image/jpeg':
                if(imagetypes() & IMG_JPG){
                    imagejpeg($this->newimage,$savePath,$imageQuality);
                }
            break;
            case 'image/png':
                $invertScaleQuality = 9 - round(($imageQuality/100) * 9);
                if(imagetypes() & IMG_PNG){
                    imagepng($this->newimage, $savePath, $invertScaleQuality);
                }
            break;
        }
    }
    public function resizeTo(){
        if($this->origWidth > 640 && $this->origHeight < 480){
            $this->resizeWidth = 640;
            $this->resizeHeight = floor(($this->origWidth/$this->origHeight)*640);
        }elseif($this->origWidth < 640 && $this->origHeight > 480){
            $this->resizeHeight = 480;
            $this->resizeWidth = floor(($this->origWidth/$this->origHeight)*480);
        }elseif($this->origWidth > 640 && $this->origHeight > 480){
            $this->resizeWidth = 640;
            $this->resizeHeight = ($this->origHeight/$this->origWidth)*640;
        }else{
            $this->resizeHeight = $this->origHeight;
            $this->resizeWidth = $this->origWidth;
        }
        $this->newimage = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);
        imagecopyresampled($this->newimage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
    }
}
?>