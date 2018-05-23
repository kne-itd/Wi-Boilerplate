<?php
/**
 * Example of use:
 * $img = new Image_1();
 * $img->setImageInfo(array('filename' => 'test.jpg', 'type' => 'image/jpeg', 'dir' => 'images');
 * $img->setMaxHeight(100);
 * $img->setMaxWidth(100);
 * $img->setThumbPrefix('bb_');
 * $img->crop()->saveImage()->outputImage();
 * 
 * 
 * @author kaj
 */
class Image
{
    private $imageInfo = array();
    private $fileName;
    private $dir;
    private $mimeType;
    private $maxHeight;
    private $maxWidth;
    private $originalHeight;
    private $originalWidth;
    private $newHeight;
    private $newWidth;
    private $thumbPrefix;
    private $newImage;
            
    /**
     * 
     * @param array $imageInfo associative aray with keys: 'filename', 'type' and 'dir'
     */
    public function setImageInfo(Array $imageInfo) 
    {
        $this->imageInfo    = $imageInfo;
        $this->fileName     = $this->imageInfo['filename'];
        $this->dir       = $this->imageInfo['dir'];
        if (substr($this->dir, -1) != "/") {
            $this->dir .= '/';
        }
        $this->mimeType     = $this->imageInfo['type'];
        list($this->originalWidth, $this->originalHeight) = getimagesize($this->dir.$this->fileName);
    }
    
    public function setMaxHeight($maxHeight) 
    {
        $this->maxHeight = $maxHeight;
    }

    public function setMaxWidth($maxWidth) 
    {
        $this->maxWidth = $maxWidth;
    }
    
    public function setThumbPrefix($thumbPrefix = 'thumb_') 
    {
        $this->thumbPrefix = $thumbPrefix;
    }
    
    private function calculateDimensions()
    {
        if ($this->originalWidth > $this->originalHeight){ // landscape
            $ratio = $this->originalHeight / $this->originalWidth;
            $this->newWidth = $this->maxWidth;
            $this->newHeight = round($this->newWidth * $ratio);
        } elseif($this->originalHeight > $this->originalWidth) { // portrait
            $ratio = $this->originalWidth / $this->originalHeight;
            $this->newHeight = $this->maxHeight;
            $this->newWidth = round($this->newHeight * $ratio);
        } else { // square
            $this->newHeight = $this->maxHeight;
            $this->newWidth = $this->maxWidth;
        }
    }
    
    private function createCanvas()
    {
        $canvas = imagecreatetruecolor($this->newWidth, $this->newHeight);
        $color = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $color);
        if ($this->mimeType == 'image/png') {
            $canvas = imagecreate($this->newWidth, $this->newHeight);
            $color = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefill($canvas, 0, 0, $color);
        }
        
        return $canvas;
    }
    
    private function getOriginal()
    {
        $original = imagecreatefromstring(file_get_contents($this->dir.$this->fileName));
        return $original;
    }

    public function resize()
    {
        $this->calculateDimensions();
        $original = $this->getOriginal();
        $canvas = $this->createCanvas();
        if (!$original || !$canvas) {
            throw new Exception( 'Fejl. Billedet kunne ikke bearbejdes');
        }
        
        imagecopyresampled($canvas, $original, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->originalWidth, $this->originalHeight);
        
        $this->newImage = $canvas;
        return $this;
    }
    
//    public function crop($crop_right = 200, $crop_bottom = 0, $crop_left = 0, $crop_top = 0 )
    public function crop(Array $rectangle = array('x' => 100, 'y' => 400, 'width' => 1400, 'height' => 800) )
    {
	if (function_exists(imagecrop)) {
	    $this->ImageCrop($rectangle);
	}
        $this->newWidth = $rectangle['width'] ;
        $this->newHeight = $rectangle['height'];
        $original = $this->getOriginal();
        $canvas = $this->createCanvas();
	$src_x = $rectangle['x'];
	$src_y = $rectangle['y'];
	$dst_x = 0;
	$dst_y = 0;
	
//        imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
        imagecopy($canvas, $original, $dst_x, $dst_y, $src_x, $src_y, $this->newWidth, $this->newHeight);
		
//        imagecopyresampled($canvas, $original, 
////                $crop_right, $crop_bottom, $crop_left, $crop_top, 
//		$dst_x, $dst_y, $src_x, $src_y ,
//                $this->newWidth, 
//                $this->newHeight , 
//                $this->newWidth, 
//                $this->newHeight  );
//        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
        $this->newImage = $canvas;
        return $this;
        
    }
    
    function ImageCrop(Array $rectangle)
    {
        $original = $this->getOriginal();
	$this->newImage = imagecrop($original, $rectangle);
	return $this;
    }
    
    public function outputImage()
    {
        if($this->mimeType == "image/jpeg" || $this->mime_type == "image/pjpeg"){  // Hvis det uploadede billede er et jpg
            imagejpeg($this->newImage); // Vi viser billedet som jpg
        }
        elseif($this->mimeType == "image/gif"){ // Hvis det uploadede billede er et gif
            imagegif($this->newImage); // Vi viser billedet som gif
        }
        elseif($this->mimeType == "image/png"){ // Hvis det uploadede billede er et png
            imagepng($this->newImage); // Vi viser billedet som png
        }
        elseif($this->mimeType == "image/bmp"){ // Hvis det uploadede billede er et windows bitmap
            image2wbmp($this->newImage); // Vi viser billedet som bmp
        }
        return $this;
    }
    
    public function saveImage()
    {
        if($this->mimeType == "image/jpeg" || $this->mimeType == "image/pjpeg"){  // Hvis det uploadede billede er et jpg
            imagejpeg($this->newImage, $this->dir.  $this->thumbPrefix.$this->fileName); // Vi gemmer billedet som jpg
        }
        elseif($this->mimeType == "image/gif"){ // Hvis det uploadede billede er et gif
            magegif($this->newImage, $this->dir.  $this->thumbPrefix.$this->fileName); // Vi gemmer billedet som gif
        }
        elseif($this->mimeType == "image/png"){ // Hvis det uploadede billede er et png
            imagepng($this->newImage, $this->dir.  $this->thumbPrefix.$this->fileName); // Vi gemmer billedet som png
        }
        elseif($this->mimeType == "image/bmp"){ // Hvis det uploadede billede er et windows bitmap
            image2wbmp($this->newImage, $this->dir.  $this->thumbPrefix.$this->fileName); // Vi gemmer billedet som bmp
        }
        return $this;
    }
}