<?php
class prMail extends sfMail
{
    //used to container the recepient
    //since the phpmailer property is protected
    //private $to;
    
    public function __construct()
    {
        parent::__construct();
        
        //print_r($this->getMailer());exit();
        $this->mailer->SMTPDebug = true;
        //$this->mailer->port = 925;
        //$this->mailer->SMTPSecurity = 'ssl';
        
        $this->setMailer('mail');
        //$this->setHostname(sfConfig::get('app_mail_smtp_host'));
        //$this->setUsername(sfConfig::get('app_mail_smtp_username'));
        //$this->setPassword(sfConfig::get('app_mail_smtp_password'));
        
        $this->setCharset('utf-8');
        $this->setContentType('text/html');
        $this->setFrom(sfConfig::get('app_mail_from'), 'PolishRomance.com');
        $this->setSender(sfConfig::get('app_mail_from'), 'PolishRomance.com');
    }
    
    public function initialize()
    {
        parent::initialize();
    }
    
    public function addAddress($address, $name = null)
    {
        //$this->to = $address;
        parent::addAddress($address, $name);
    }
    
    public function send()
    {
        //@TODO only for test purposes 
        //remove this when going to work with real emails
        $this->clearAddresses();
        $this->addAddress('dincho.todorov@bonex.us', 'Dincho Todorov');
        
/*        $body = $this->getBody();
        $body .= '<br /><br /><br /><small>This email was send to ' .$this->to . '</small>';
        $this->setBody($body);*/
        parent::send();
    }
}
?>