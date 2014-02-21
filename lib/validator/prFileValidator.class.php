<?php

/**
 * @package    pr
 * @subpackage validator
 * @author     Dincho Todorov <dincho@xbuv.com>
 */
class prFileValidator extends sfFileValidator
{

  public function execute(&$value, &$error)
  { 
      $request = $this->getContext()->getRequest();
      
    // file too large (php.ini) ?
    if( isset($value['error']) && $value['error'] != UPLOAD_ERR_OK )
    {
        if( $value['error'] == UPLOAD_ERR_INI_SIZE )
        {
            $error = $this->getParameter('ini_max_size_error');
        } else {
            $error = $this->getParameter('unknown_error');
        }
        
        return false;
    }
    
    

    // file too large?
    $max_size = $this->getParameter('max_size');
    if ($max_size !== null && $max_size < $value['size'])
    {
      $error = $this->getParameter('max_size_error');

      return false;
    }

    // supported mime types formats
    $mime_types = $this->getParameter('mime_types');
    $imgData = @getimagesize($value['tmp_name']);

    if (!$imgData)
    {
        $error = $this->getParameter('mime_types_error');

        return false;
//      throw new sfException("Could not load image data for: " . $value['tmp_name']);
    }
        
    $file_mime = $imgData['mime'];
    if ($mime_types !== null && !in_array($file_mime, $mime_types))
    {
      $error = $this->getParameter('mime_types_error');

      return false;
    }

    return true;
  }


  public function initialize($context, $parameters = null)
  { 
    // initialize parent
    parent::initialize($context, $parameters);
    
        // set defaults
    $this->getParameterHolder()->set('ini_max_size_error',   (isset($parameters['ini_max_size_error'])) ? $parameters['ini_max_size_error'] : 'File is too large');
    $this->getParameterHolder()->set('unknown_error', (isset($parameters['unknown_error'])) ? $parameters['unknown_error'] :'Unable to upload the file. Please contact the support.');
    
    return true;
  }
}
