<?php
class prMail extends sfMail
{
    //used to container the recepient
    //since the phpmailer property is protected
    private $to;
    private $copy_to_web = false;
    
    public function __construct()
    {
        parent::__construct();
        
        //print_r($this->getMailer());exit();
        //$this->mailer->SMTPDebug = true;
        $this->mailer->port = 25;
        //$this->mailer->SMTPSecurity = 'ssl';
        
        $this->setMailer(sfConfig::get('app_mail_mailer', 'mail'));
        $this->setHostname(sfConfig::get('app_mail_smtp_host', 'localhost'));
        $this->setUsername(sfConfig::get('app_mail_smtp_username'));
        $this->setPassword(sfConfig::get('app_mail_smtp_password'));
        
        $this->setCharset('utf-8');
        $this->setContentType('text/html');
        $this->setFrom(sfConfig::get('app_mail_from'), 'PolishRomance.com');
        $this->setSender(sfConfig::get('app_mail_from'), 'PolishRomance.com');
    }
    
    public function initialize()
    {
        parent::initialize();
    }
    
    public function CopyToWeb($bool = true)
    {
        $this->copy_to_web = $bool;
    }
    
    public function addAddress($address, $name = null)
    {
        $this->to = $address;
        parent::addAddress($address, $name);
    }
    
    public function send()
    {
        if( $this->copy_to_web )
        {
            $webemail = new WebEmail();
            $webemail->setSubject($this->getSubject());
            $webemail->setBody($this->getBody());
            $webemail->save();
            
            $body = '(If you have problems viewing this message, please <a href="'. BASE_URL .'emails/'. $webemail->getHash() .'">click here</a>)<br /><br /><br />' . $this->getBody();
            $this->setBody($body);
        }
        
        parent::send();
    }
}
?>