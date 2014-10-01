<?php

/**
 * Subclass for representing a row from the 'homepage_member_photo' table.
 *
 *
 *
 * @package lib.model
 */
class HomepageMemberPhoto extends BaseHomepageMemberPhoto
{
    public function setHomepagesArray($array)
    {
        if (! is_array($array) || count($array) == 0) {
            $this->setHomepages(null);
        } else {
            $this->setHomepages(implode(',', $array));
        }
    }

    public function getHomepagesArray()
    {
        if (! is_null($this->getHomepages())) {
            return explode(',', $this->getHomepages());
        }

        return array();
    }

    public function updateCroppedImageFromPhoto($photo, $sizes)
    {
        //delete old image
        //unlink(@$this->getFilePath());
        $this->deleteImage();

        $relative_path = DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.'Homepage'.DIRECTORY_SEPARATOR;
        $path = sfConfig::get('sf_upload_dir').$relative_path;

        $originalPath = $photo->getImagePath('file'); // location of image to be cropped
        $newName = time().'_'.$photo->getFile();
        $fullPath = $path . $newName; // where to put cropped image

        if (!file_exists($path)) {
            mkdir($path, 0777, true); //why this fucking mode do not work :( fix below
            chmod($path, 0777);
        }

        $cropped = new sfThumbnail();
        $cropped->loadFile($originalPath);
        $cropped->crop($sizes);

        $thumb = new sfThumbnail(100, 95);
        $thumb->loadSource($cropped->getThumb(), $cropped->getMime());
        $thumb->save($fullPath);
        chmod($fullPath, 0666);

        $this->setFilePath($newName);
    }

    public function deleteImage()
    {
        $relative_path = DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.'Homepage'.DIRECTORY_SEPARATOR;
        $abspath = sfConfig::get('sf_upload_dir').$relative_path.$this->getFilePath();

        if( file_exists($abspath) ) unlink($abspath);
    }

    public function delete($con = null)
    {
        parent::delete($con);

        $this->deleteImage();
    }

    public function getWebRelativePath()
    {
        $relative_path = DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.'Homepage'.DIRECTORY_SEPARATOR;

        return DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name').$relative_path.$this->getFilePath();
    }
}
