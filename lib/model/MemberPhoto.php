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
    $this->setCroppedAt(time());
    $this->save();
    $this->createThumbnails('cropped');
  }
    
    public function updateRotatedImage($deg)
    {
        $originalPath = $this->getImagePath('file'); // location of image to be rotated
    
        $rotated = new sfThumbnail();
        $rotated->loadFile($originalPath);
        $rotated->rotate($deg);
        $rotated->save($originalPath);
        $this->save();
        $this->createThumbnails('file');
        
        if($this->getCropped()) {
            $originalPath = $this->getImagePath('cropped'); // location of image to be rotated
            $rotated = new sfThumbnail();
            $rotated->loadFile($originalPath);
            $rotated->rotate($deg);
            $rotated->save($originalPath);
            $this->save();
            $this->createThumbnails('cropped');
        }
    }
    
  public function setAsMainPhoto($save_member = true)
  {
        if ( !$this->isMain() )
        {
            $member = $this->getMember();
            $member->setMemberPhoto($this);
            if($save_member) $member->save();
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
          return 'no_photo/' . $this->getMember()->getSex() . '/'. $size . '.jpg';
      } else {
          
          return ($column == 'cropped') ? ($this->getImageUrlPath($column, $size).'?'.$this->getCroppedAt(null)) : $this->getImageUrlPath($column, $size);
      }
      
  }
  
  public function delete($con = null)
  {
        //if deleting main photo, set the first photo as new main photo
        $member = $this->getMember();
        if( $member->getMainPhoto()->getId() == $this->getId() )
        {
            $c = new Criteria();
            $c->add(MemberPhotoPeer::MEMBER_ID, $member->getId());
            $c->add(MemberPhotoPeer::ID, $this->getId(), Criteria::NOT_EQUAL);
            $c->add(MemberPhotoPeer::IS_PRIVATE, false);
            $new_main = MemberPhotoPeer::doSelectOne($c);
            if( $new_main )
            {
                $member->setMemberPhoto($new_main);
                $member->save();
            }
        }
        parent::delete($con);
  }
  
  public function save($con = null)
  {
      parent::save($con);
      
      $member = $this->getMember();
      if (!$this->getIsPrivate() && $member->countMemberPhotos() == 1)
      {
          $member->setMemberPhoto($this);
          $member->save();
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
