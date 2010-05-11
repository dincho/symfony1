<?php
class prMail extends sfMail
{
    //used as recepient container
    //since the phpmailer property is protected
    private $to;
    private $copy_to_web = false;

    public function __construct($mail_config_key = null)
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
