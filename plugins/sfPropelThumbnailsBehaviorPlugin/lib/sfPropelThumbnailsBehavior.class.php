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
      return get_class($object) . DIRECTORY_SEPARATOR;
    } else {
      return get_class($object);
    }
  }
  
  public function preDelete($object)
  {
    $this->deleteImage($object, 'file');
    $this->deleteImage($object, 'cropped');
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
  
  public function updateImageFromRequest($object, $column = null, $ImageField = 'image', $CreateThumbnails = true)
  {
    $Request = sfContext::getInstance()->getRequest();
    
    if ($Request->getFileSize($ImageField))
    {
     
      $object->deleteImage($column);
      
      $file = $Request->getFileName($ImageField);
      $FileName = time().'_'.Tools::escapeFileName(substr($file, 0, strrpos($file, '.')));
      $ext = $Request->getFileExtension($ImageField);
         
      $newFile = $object->getImagesPath().$FileName.$ext;
      
      //max 700x700 for original image!
      $file_arr = $Request->getFile($ImageField);
      $tmp_file = $file_arr['tmp_name'];
      
      $thumbnail = new sfThumbnail(700, 700);
      $thumbnail->loadFile($tmp_file);
      $thumbnail->save($newFile);
      
      chmod($newFile, 0666);
            
      //$Request->moveFile($ImageField, $newFile);

      //set the image field
      $class = get_class($object);
      //if( is_null($column) ) $columnName = sfConfig::get('propel_behavior_thumbnails_'.$class.'_column', 'image');
      $method = 'set'.call_user_func(array($class.'Peer', 'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
      call_user_func(array($object, $method), $FileName.$ext);
            
      //$object->setImage($FileName.$ext);
      if( $CreateThumbnails ) $object->createThumbnails($column);
    }
  }
  
  public function updateImageFromFile($object, $column = 'file', $ImagePath, $CreateThumbnails = true)
  {
    if (filesize($ImagePath))
    {
      $object->deleteImage($column);
      
      $file = basename($ImagePath);
      $FileName = time().'_'.Tools::escapeFileName(substr($file, 0, strrpos($file, '.')));
      $ext = substr($file, strrpos($file, '.'));
      //$ext = $Request->getFileExtension($file);
      
      $newFile = $object->getImagesPath().$FileName.$ext;
      if(!file_exists($object->getImagesPath())) mkdir($object->getImagesPath(), 0777, true);
      
      $thumbnail = new sfThumbnail(700, 700);
      $thumbnail->loadFile($ImagePath);
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
      
    foreach ($this->getThumbSizes($object, $column) as $thumbSize)
    {
      $thumbnail = $this->getImagePath($object, $column, $thumbSize['width'] . 'x' . $thumbSize['height']);
      if( file_exists($thumbnail) ) unlink($thumbnail);
    }    
  }
  
  public function deleteImage($object, $column)
  {
    //delete thumbnails
    $this->deleteThumbnails($object, $column);
    
    //delete object`s normal image
    if( file_exists($this->getImagePath($object, $column)) ) unlink($this->getImagePath($object, $column));      
  }  
}
