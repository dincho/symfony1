<?php

/**
 * Subclass for representing a row from the 'web_email' table.
 *
 * 
 *
 * @package lib.model
 */ 
class WebEmail extends BaseWebEmail
{
    public function save($con = null)
    {
        if( $this->isNew() && !$this->getHash())
        {
            $this->generateHash();
        }
        
        return parent::save($con);
    }
    
    public function generateHash()
    {
        $hash = sha1(SALT . $this->getSubject() . SALT . $this->getBody() . SALT . time() . SALT);
        $this->setHash($hash);
        
        return $hash;
    }
}
