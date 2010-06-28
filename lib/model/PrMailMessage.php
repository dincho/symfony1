<?php

/**
 * Subclass for representing a row from the 'PR_mail_message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PrMailMessage extends BasePrMailMessage
{

    public function setBody($v)
    {
        parent::setBody(nl2br($v));
    }
        
    public function setRecipients($v)
    {
        if(!is_array($v)) $v = array($v);
        parent::setRecipients(serialize($v));
    }
    
    public function getRecipients($unserialize = true)
    {
        if( !is_null(parent::getRecipients()) ) 
        {
            return ($unserialize) ? unserialize(parent::getRecipients()) : parent::getRecipients();
        } else {
            return array();
        }
    }
    
    public function setBcc($v)
    {
        if(!is_array($v)) $v = array($v);
        parent::setBcc(serialize($v));
    }
    
    public function getBcc($unserialize = true)
    {
        if( !is_null(parent::getBcc()) ) 
        {
            return ($unserialize) ? unserialize(parent::getBcc()) : parent::getBcc();
        } else {
            return array();
        }
    }
    
    public function setCc($v)
    {
        if(!is_array($v)) $v = array($v);
        parent::setCc(serialize($v));
    }
    
    public function getCc($unserialize = true)
    {
        if( !is_null(parent::getCc()) ) 
        {
            return ($unserialize) ? unserialize(parent::getCc()) : parent::getCc();
        } else {
            return array();
        }
    }

    public function addRecipient($address)
    {
        $recipients = $this->getRecipients();
        $recipients[] = $address;
        $this->setRecipients($recipients);
    }
    
    public function addRecipients($addresses)
    {
        $recipients = $this->getRecipients();
        $this->setRecipients(array_merge($recipients, $addresses));
    }
    
    public function addBcc($bcc)
    {
        $recipients = $this->getBcc();
        $recipients[] = $bcc;
        $this->setBcc($recipients);
    }
   
    public function saveAndSend()
    {
        $this->save();
        return $this->send();
    }
    
    public function send()
    {
        if( $this->isNew() ) throw new sfException("New object (messages) cannot be send! Use saveAndSend method, or save the object first!");
        if( !in_array($this->getStatus(), array(PrMailMessagePeer::STATUS_PENDING, PrMailMessagePeer::STATUS_FAILED)) ) throw new sfException("You can send only pending and failed messages (resent)");
        
        if( sfConfig::get('app_mail_use_queue') )
        {
            $gmc = new GearmanClient();
            $gmc->addServer('127.0.0.1', 4730);
            $handle = $gmc->doBackground('MailQueue_Send', $this->getId());
            
            if ( $gmc->returnCode() == GEARMAN_SUCCESS )
            {            
                $this->setStatus(PrMailMessagePeer::STATUS_SCHEDULED);
                $this->save();
                return true;
            } else {
                if( sfConfig::get('app_mail_error_exception') ) throw new sfException("Unable to schedule gearman job!", $gmc->returnCode());
                return false;
            }
            
        } else {
            return $this->sendMail();
        }
    }
    
    public function sendMail()
    {
        $this->setStatus(PrMailMessagePeer::STATUS_SENDING);
        $this->save();
            
        $mailer = new prMail($this->getMailConfigId());
        $mailer->setSubject($this->getSubject());
        $mailer->setBody($this->getBody());
        $mailer->setFrom($this->getMailFrom());
        $mailer->setSender($this->getSender());
        $mailer->addAddresses($this->getRecipients());
        $mailer->addBccRecipients($this->getBcc());
        $mailer->addCcRecipients($this->getCc());
        $status = $mailer->send();
        
        if( $status )
        {
            $this->setStatus(PrMailMessagePeer::STATUS_SENT);
        } else {
            $this->setStatus(PrMailMessagePeer::STATUS_FAILED);
        }
        
        $this->save();
        return $status;
    }
    
    public function createWebCopy(Catalogue $catalog)
    {
        $webemail = new WebEmail();
        $webemail->setSubject($this->getSubject());
        $webemail->setBody($this->getBody());
        $webemail->generateHash();
    
        $webemail_url  = LinkPeer::create('@web_email?hash=' . $webemail->getHash())->getUrl($catalog);
        $global_vars = array('{WEB_MAIL_URL}' => $webemail_url);
        $body = str_replace(array_keys($global_vars), array_values($global_vars), $this->getBody());
        $this->setBody($body);
        
        $webemail->setBody($body); //set body again with parsed URL
        $webemail->save();
    }
    
}
