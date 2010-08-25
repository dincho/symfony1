<?php

/**
 * Subclass for representing a row from the 'notification' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Notification extends BaseNotification
{
    public function execute($global_vars, $addresses = null, $object = null, $mail_from = null, Catalogue $catalog = null)
    {
        $content = $this->getBody() . $this->getFooter();
        $content = str_replace(array_keys($global_vars), array_values($global_vars), $content);

        $subject = $this->getSubject();
        $subject = str_replace(array_keys($global_vars), array_values($global_vars), $subject);
        
        if( !is_null($object) )
        {
            
            $matches = array();
            preg_match_all('/{(\w+)}/s', $content, $matches);
            //$params = $matches[0];
            $vars = $matches[1];
            
            foreach ($vars as $var)
            {
                $method = 'get' . sfInflector::camelize(strtolower($var));
                if( method_exists($object, $method))
                {
                    $content = str_replace('{'. $var . '}', $object->$method(), $content);
                } else{
                    /*
                        @TODO add log entry if notification tries to use unknow object method
                    */
                }
            }
        }
        
        $message = new PrMailMessage();
        $message->setMailConfig($this->getMailConfig());
        
        if( !is_null($mail_from) )
        {
            $message->setMailFrom($mail_from);
            $message->setSender($mail_from);
        } else {
            $message->setMailFrom($this->getSendFrom());
            $message->setSender($this->getSendFrom());
        }
        
        $message->setSubject($subject);
        $message->setBody($content);
        
        if( $this->getToAdmins() )
        {
            $message->addRecipient($this->getSendTo());
        } else {
            $message->addRecipients(array($addresses));
            $message->createWebCopy($catalog);
        }
        
        if( $this->getBcc() ) $message->addBcc($this->getBcc());
        return $message->saveAndSend();
    }
}
