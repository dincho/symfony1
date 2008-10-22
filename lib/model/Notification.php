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
    public function execute($global_vars, $addresses = null, $object = null, $mail_from = null)
    {
        //this must be implemented in prMail i think ... its more easy.
        //$body .= '<br /><br /><a href="http://PolishRomance.com/">PolishRomance.com</a><br /><br /><br />';
        //$body .= '<small>This message was sent by request to {EMAIL}. If you believe you received this message by error, it is safe to just ignore it.</small>';        
        $body = str_replace(array_keys($global_vars), array_values($global_vars), $this->getBody());
        
        if( !is_null($object) )
        {
            
            $matches = array();
            preg_match_all('/{(\w+)}/s', $body, $matches);
            //$params = $matches[0];
            $vars = $matches[1];
            
            foreach ($vars as $var)
            {
                $method = 'get' . sfInflector::camelize(strtolower($var));
                if( method_exists($object, $method))
                {
                    $body = str_replace('{'. $var . '}', $object->$method(), $body);
                }
            }
        }
        
        $mail = new prMail();
        if( !is_null($mail_from) )
        {
            $mail->setFrom($mail_from);
            $mail->setSender($mail_from);  
        } else {
            $mail->setFrom($this->getSendFrom());
            $mail->setSender($this->getSendFrom());            
        }

        $mail->setSubject($this->getSubject());
        $mail->setBody($body);
        
        if( $this->getToAdmins() )
        {
            $mail->addAddress($this->getSendTo());
        } else {
            $mail->addAddresses($addresses);
        }
        
        $mail->send();
        
/*        print_r($matches);
        print_r($body);
        exit();*/
    }
}
