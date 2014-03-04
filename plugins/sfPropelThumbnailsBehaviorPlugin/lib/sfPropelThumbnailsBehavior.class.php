<?php

/*
 * This file is part of the symfony package.
 * (c) 2007 Dincho Todorov <dincho.todorov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPropelParanoidBehavior.class.php 2473 2006-10-21 09:17:15Z fabien $
 */
class sfPropelThumbnailsBehavior
{
  public function getImagesDir($object, $addSlash = true)
  {
    if($addSlash)
    {
//      return get_class($object) . DIRECTORY_SEPARATOR;
      return get_class($object) . '/';//DIRECTORY_SEPARATOR;
    } else {
      return get_class($object);
    }
  }
  
  public function preDelete($object)
  {
    $class = get_class($object);
    if(sfConfig::get('propel_behavior_thumbnails_'.$class .'_file')) $this->deleteImage($object, 'file');
    if(sfConfig::get('propel_behavior_thumbnails_'.$class .'_cropped')) $this->deleteImage($object, 'cropped');
  }
  
  public function getImagesPath($object)
  {
    return sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$this->getImagesDir($object);
  }
  
  public function getImagePath($object, $column = null, $thumbnail = null)
  {
    if( $this->getImageFilename($object, $column) )
    {
      if( $thumbnail )
      {
        return (file_exists($this->getImagesPath($object) . $thumbnail . DIRECTORY_SEPARATOR . $this->getImageFilename($object, $column))) ? $this->getImagesPath($object) . $thumbnail . DIRECTORY_SEPARATOR . $this->getImageFilename($object, $column) : null;
      } else {
        return $this->getImagesPath($object).$this->getImageFilename($object, $column);
      }
    }
  }
  
  public function getImageUrlPath($object, $column = null, $thumbnail = null, $absolute = false)
  {
      if( !$this->getImageFilename($object, $column) ) $column = 'file'; //default to file if no column exists
    if( $thumbnail )
    {
      
      return ($this->getImagePath($object, $column, $thumbnail)) ? _compute_public_path($this->getImageFilename($object, $column), 'uploads/images/' . $this->getImagesDir($object) . $thumbnail, null) : null;
    } else {
      //return $this->getImageFilename($object);
      return _compute_public_path($this->getImageFilename($object, $column), 'uploads/images/' . $this->getImagesDir($object, false), null, $absolute);
    }
  }
  
  public function getThumbSizes($object, $column = null)
  {
    $class = get_class($object);
    $config =  sfConfig::get('propel_behavior_thumbnails_'.$class.'_' . $column);
    return $config['thumbSizes'];
    //print_r($config);die('bp2');
  }
    
  public function getImageFilename($object, $column = null)
  {
    //$column = 'chep';
    //if( is_null($column) ) $columnName = sfConfig::get('propel_behavior_thumbnails_'.$class.'_column', 'image');
    $class = get_class($object);
    $method = 'get'.call_user_func(array($class.'Peer', 'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
    return $object->$method();    
  }
  
  public function updateImageFromRequest($object, $column = null, $ImageField = 'image', $CreateThumbnails = true, $brandName = null)
  {
    $Request = sfContext::getInstance()->getRequest();
    
    if ($Request->getFileSize($ImageField))
    {
     
      $object->deleteImage($column);
      
      //max 700x700 for original image!
      $file_arr = $Request->getFile($ImageField);
      $tmp_file = $file_arr['tmp_name'];

      $ext = $this->getFileExtension($tmp_file);                         

      if( in_array($ext, array('.jpg', '.jpeg')) )
      {
        $exif = exif_read_data($tmp_file, 'EXIF', true);
        
        if(!($exif===false) && array_key_exists('IFD0', $exif) && array_key_exists('Orientation', $exif['IFD0']) )
        {
          $ort = $exif['IFD0']['Orientation']; 
    
          $img = new sfImage($tmp_file, 'image/jpg');
          switch($ort)
          {
              case 1: // nothing
              break;
      
              case 2: // horizontal flip
                  $img->mirror();
              break;
                                     
              case 3: // 180 rotate left
                  $img->rotate(180);
              break;
                         
              case 4: // vertical flip
                  $img->flip();
              break;
                     
              case 5: // vertical flip + 90 rotate right
                  $img->flip();
                  $img->rotate(-90);
              break;
                     
              case 6: // 90 rotate right
                  $img->rotate(-90);
              break;
                     
              case 7: // horizontal flip + 90 rotate right
                  $img->mirror();   
                  $img->rotate(-90);
              break;
                     
              case 8:    // 90 rotate left
                  $img->rotate(90);
              break;
          }      
          $img->save();    
        }               
      }// is jpg

      $file = $Request->getFileName($ImageField);
      $FileName = time().'_'.Tools::escapeFileName(substr($file, 0, strrpos($file, '.')));                  
         
      $newFile = $object->getImagesPath().$FileName.$ext;
      
      $thumbnail = new sfThumbnail(700, 700);
      $thumbnail->loadFile($tmp_file);
      if( $brandName ) $thumbnail->prBrand($brandName);
      $thumbnail->save($newFile);
      
      chmod($newFile, 0666);
            
      //set the image field
      $class = get_class($object);
      $method = 'set'.call_user_func(array($class.'Peer', 'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
      call_user_func(array($object, $method), $FileName.$ext);
            
      if( $CreateThumbnails ) $object->createThumbnails($column);
    }
  }
  
  public function updateImageFromFile($object, $column = 'file', $ImagePath, $CreateThumbnails = true, $brandName = null)
  {
    if (filesize($ImagePath))
    {
      $object->deleteImage($column);
      
      $file = basename($ImagePath);
      $FileName = time().'_'.Tools::escapeFileName(substr($file, 0, strrpos($file, '.')));
      $ext = $this->getFileExtension($file);
      // $ext = substr($file, strrpos($file, '.'));
      //$ext = $Request->getFileExtension($file);
      
      $newFile = $object->getImagesPath().$FileName.$ext;
      if(!file_exists($object->getImagesPath())) mkdir($object->getImagesPath(), 0777, true);
      
      $thumbnail = new sfThumbnail(700, 700);
      $thumbnail->loadFile($ImagePath);
      if( $brandName ) $thumbnail->prBrand($brandName);
      $thumbnail->save($newFile);

      $class = get_class($object);
      $method = 'set'.call_user_func(array($class.'Peer', 'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
      call_user_func(array($object, $method), $FileName.$ext);
      
      if( $CreateThumbnails ) $object->createThumbnails($column);     
    }
  }
  
  
  public function createThumbnails($object, $column = null)
  {
    foreach ($this->getThumbSizes($object, $column) as $thumbSize)
    {
      $thumbnail = new sfThumbnail($thumbSize['width'], $thumbSize['height']);
      $thumbnail->loadFile($this->getImagePath($object, $column));
      
      $thumbDir = $this->getImagesPath($object) . $thumbSize['width'] . 'x' . $thumbSize['height'] . DIRECTORY_SEPARATOR;
      if(!file_exists($thumbDir)) {
        mkdir($thumbDir, 0777, true); //why this fucking mode do not work :( fix below
        chmod($thumbDir, 0777);
      }
      
      $thumbFIle = $thumbDir . $this->getImageFilename($object, $column);
      $thumbnail->save($thumbFIle);
      chmod($thumbFIle, 0666);
    }
  }

    public function deleteThumbnails($object, $column)
    {
        $thumbSizes = $this->getThumbSizes($object, $column);
        if ($thumbSizes)
        {
            foreach ($thumbSizes as $thumbSize)
            {
                $thumbnail = $this->getImagePath($object, $column, $thumbSize['width'] . 'x' . $thumbSize['height']);
                if (file_exists($thumbnail))
                    unlink($thumbnail);
            }
        }
    }
  
  public function deleteImage($object, $column)
  {
    //delete thumbnails
    $this->deleteThumbnails($object, $column);
    
    //delete object`s normal image
    if( file_exists($this->getImagePath($object, $column)) ) unlink($this->getImagePath($object, $column));      
  }
  
  protected function getFileExtension($file)
  {
    static $mimeTypes = null;

    $imgData = @getimagesize($file);

    if (!$imgData)
    {
      throw new sfException("Could not load image data for: " . $file);
    }
        
    $file_mime = $imgData['mime'];
    
    if (!$file_mime)
    {
      return '.bin';
    }

    if (is_null($mimeTypes))
    {
      $mimeTypes = unserialize(file_get_contents(sfConfig::get('sf_symfony_data_dir').'/data/mime_types.dat'));
    }

    return isset($mimeTypes[$file_mime]) ? '.'.$mimeTypes[$file_mime] : '.bin';
  }  
}
