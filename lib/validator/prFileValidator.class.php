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
    
    return parent::execute(&$value, &$error);
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
