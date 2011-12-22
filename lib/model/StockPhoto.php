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
    }
}

$sizes = array(array('width' => 50, 'height' => 50),
                array('width' => 308, 'height' => 293), //home page
                array('width' => 220, 'height' => 225), //member stories
                array('width' => 70, 'height' => 105), //assistant
                array('width' => 100, 'height' => 95), //backend
                array('width' => 350, 'height' => 350));//backend full size when cropping
                
sfPropelBehavior::add('StockPhoto', array('thumbnails' => array('file' => array('thumbSizes' => $sizes), 'cropped' => array('thumbSizes' => $sizes))));