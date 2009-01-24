<?php

/**
 * Subclass for representing a row from the 'stock_photo' table.
 *
 * 
 *
 * @package lib.model
 */
class StockPhoto extends BaseStockPhoto
{

    public function setHomepagesArray($array)
    {
        if (! is_array($array) || count($array) == 0)
        {
            $this->setHomepages(null);
        } else
        {
            $this->setHomepages(implode(',', $array));
        }
    }

    public function getHomepagesArray()
    {
        if (! is_null($this->getHomepages()))
        {
            return explode(',', $this->getHomepages());
        }
        
        return array();
    }

    public function updateCroppedImage($sizes)
    {
        //delete old image
        $this->deleteImage('cropped');
        
        $originalPath = $this->getImagePath('file'); // location of image to be cropped
        $newName = 'crop_' . $this->getFile();
        $newPath = $this->getImagesPath() . $newName; // where to put cropped image
        
        $cropped = new sfThumbnail();
        $cropped->loadFile($originalPath);
        $cropped->crop($sizes);
        $cropped->save($newPath);
        
        $this->setCropped($newName);
        $this->save();
        $this->createThumbnails('cropped');
        
        $this->addEffects();
    }
    
    public function addEffects()
    {
        $originalPath = $this->getImagePath('cropped', '100x95');
        if( $this->getGender() == 'M')
        {
            $newName = 'blue_crop_' . $this->getFile();
            $hue = 195; $saturation = 25;
        } elseif($this->getGender() == 'F')
        {
            $newName = 'orange_crop_' . $this->getFile();
            $hue = 25; $saturation = 27;
        } else {
            throw new sfException('StockPhoto::tint No gender set!');
        }
        
        
        $newPath = $this->getImagesPath() . '100x95' . DIRECTORY_SEPARATOR . $newName;
        $cropped = new sfThumbnail();
        $cropped->loadFile($originalPath);
        $cropped->addPrEffects($hue, $saturation);
        $cropped->save($newPath);
    }
    
    public function getTiltImageUrlPath()
    {
        $prefix = ($this->getGender() == 'F') ? 'orange_' : 'blue_'; 
        
        return _compute_public_path($prefix . $this->getImageFilename('cropped'), 'uploads/images/' . $this->getImagesDir() . '100x95', null, false);
    }
    
    public function delete($con = null)
    {
        if( $this->getGender() == 'M')
        {
            $name = 'blue_crop_' . $this->getFile();
        } elseif($this->getGender() == 'F')
        {
            $name = 'orange_crop_' . $this->getFile();
        }
                
        $path = $this->getImagesPath() . '100x95' . DIRECTORY_SEPARATOR . $name;
        
        @unlink($path);
        parent::delete($con);
    }

}

$sizes = array(array('width' => 50, 'height' => 50),
                array('width' => 100, 'height' => 95), //home page
                array('width' => 220, 'height' => 225), //member stories
                array('width' => 350, 'height' => 350));//backend full size when cropping
                
sfPropelBehavior::add('StockPhoto', array('thumbnails' => array('file' => array('thumbSizes' => $sizes), 'cropped' => array('thumbSizes' => $sizes))));