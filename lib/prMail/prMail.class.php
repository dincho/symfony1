<?php
class prMail extends sfMail
{
    public function __construct($mail_config_key = null)
    {
        $this->initialize($mail_config_key);
    }
    
    public function setBody($body)
    {
         //we send only html emails so, always convert newlines.
        parent::setBody(nl2br($body));
    }
  
    public function initialize($mail_config_key = null)
    {
        $mail_configs = sfConfig::get('app_mail_outgoing');
        
        if( !is_array($mail_configs) )
        {
            throw new sfException('Outgoing mail configuration is not set or it\'s not array');
        }
        
        $mail_config = ( isset($mail_configs[$mail_config_key]) ) ? $mail_configs[$mail_config_key] : array_shift($mail_configs);
        
        if( !is_array($mail_config) )
        {
            throw new sfException('Outgoing mail configuration cannot be obtained or it is not an array');
        }
        
        $this->mailer = new PHPMailer(true);
        $this->mailer->SMTPDebug = $mail_config['smtp_debug'];
        $this->mailer->Host = $mail_config['smtp_host'];
        $this->mailer->Port = $mail_config['smtp_port'];
        $this->mailer->SMTPSecure = $mail_config['smtp_security'];
        

        $this->setMailer($mail_config['mailer']);
        $this->setUsername($mail_config['smtp_username']);
        $this->setPassword($mail_config['smtp_password']);
        
        $this->setCharset('utf-8');
        $this->setContentType('text/html');
        $this->setFrom($mail_config['from']);
        $this->setSender($mail_config['from']);
        
        //print_r($this->mailer);exit();        
    }
    
    public function addBccRecipients(array $recipients)
    {
        foreach ($recipients as $recipient) {
            parent::addBcc($recipient);
        }
    }
    
    public function addCcRecipients(array $recipients)
    {
        foreach ($recipients as $recipient) {
            parent::addCc($recipient);
        }
    }    
    
    public function send()
    {
        if( sfConfig::get('app_mail_enabled') )
        {
          try
          {
              $this->mailer->Send();
              return true;
          } catch ( Exception $e )
          {
              if( sfConfig::get('app_mail_error_exception') ) throw new sfException($e->getMessage(), $e->getCode());
          }
        }
        
        return false;
    }
}
