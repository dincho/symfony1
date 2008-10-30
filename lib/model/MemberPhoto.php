<?php

/**
 * Subclass for representing a row from the 'member_photo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberPhoto extends BaseMemberPhoto
{
    public $no_photo = false;
    
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
	
	public function setAsMainPhoto()
	{
        $member = $this->getMember();
        if ( $this->getId() != $member->getMainPhotoId() )
        {
            $member->setMemberPhoto($this);
            $member->save();
        }
	}
	
	/* proxy so old code to work, remove it some day */
	public function getIsMainPhoto()
	{
	    return $this->getIsMain();
	}
	
	public function isMain()
	{
	    return ( $this->getMember()->getMainPhotoId() == $this->getId() );
	}
	
    /**
     * Short alias of the behavior method
     *
     * @param string $size
     * @param string $column
     * @return string
     */
	public function getImg($size = null, $column = 'cropped')
	{
	    if( $this->no_photo )
	    {
	        return 'static/member_photo/' . $this->getMember()->getSex() . '/no_photo_' . $size . '.jpg';
	    } else {
	        return $this->getImageUrlPath($column, $size);
	    }
	    
	}
}

$sizes = array(array('width' => 30, 'height' => 30), 
               array('width' => 50, 'height' => 50),
               array('width' => 80, 'height' => 100),
               array('width' => 100, 'height' => 100),
               array('width' => 350, 'height' => 350),
              );
sfPropelBehavior::add('MemberPhoto', array('thumbnails' => array(
                     'file' => array('thumbSizes' => $sizes), 
                     'cropped' => array('thumbSizes' => $sizes),
                     )));
