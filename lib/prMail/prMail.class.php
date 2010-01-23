<?php
class prMail extends sfMail
{
    //used as recepient container
    //since the phpmailer property is protected
    private $to;
    private $copy_to_web = false;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        
        //print_r($this->getMailer());exit();
        $this->mailer->SMTPDebug = sfConfig::get('app_mail_smtp_debug', false);
        $this->mailer->Host = sfConfig::get('app_mail_smtp_host', 'localhost');
        $this->mailer->Port = sfConfig::get('app_mail_smtp_port', 25);
        $this->mailer->SMTPSecure = sfConfig::get('app_mail_smtp_security', '');
        

        $this->setMailer(sfConfig::get('app_mail_mailer', 'mail'));
        $this->setUsername(sfConfig::get('app_mail_smtp_username'));
        $this->setPassword(sfConfig::get('app_mail_smtp_password'));
        
        $this->setCharset('utf-8');
        $this->setContentType('text/html');
        $this->setFrom(sfConfig::get('app_mail_from', 'from_email_not_set@PolishDate.com'));
        $this->setSender(sfConfig::get('app_mail_from', 'from_email_not_set@PolishDate.com'));
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
        if($this->copy_to_web)
        {
            $webemail = new WebEmail();
            $webemail->setSubject($this->getSubject());
            $webemail->setBody($this->getBody());
            $webemail->generateHash();
            
            $global_vars = array('{WEB_MAIL_URL}' => BASE_URL . 'en/emails/' . $webemail->getHash() . '.html');
            $body = str_replace(array_keys($global_vars), array_values($global_vars), $this->getBody());
            $this->setBody($body);
            $webemail->setBody($body); //set body again with parsed URL
            $webemail->save();
        }
        
        $this->setBody(nl2br($this->getBody()));
        
        try
        {
            //$this->mailer->Send();
        } catch ( Exception $e )
        {
            if(SF_ENVIRONMENT == 'dev') throw new sfException($e->getMessage(), $e->getCode());
            return false;
        }
        
        return true;
    }
}
