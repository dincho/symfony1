<?php
class DotPay
{
    private
        $accountId    = null,
        $amount       = 0,
        $currency     = 'EUR',
        $description  = '',
        $lang         = 'en',
        $returnURL    = '',
        $returnType   = 0,
        $callbackURL  = '',
        $data         = null,
        $firstname    = '',
        $lastname     = '',
        $email        = ''
        
    ;
    
    public function __construct($accountId = null, $lang = 'en')
    {
        $this->accountId = $accountId;
        $this->lang = $lang;
    }
    
    
    public function generateURL($url)
    {
        $params = array('id'            => $this->accountId,
                        'amount'        => $this->amount,
                        'currency'      => $this->currency,
                        'description'   => $this->description,
                        'lang'          => $this->lang,
                        'URL'           => $this->returnURL,
                        'type'          => $this->returnType,
                        'URLC'          => $this->callbackURL,
                        'control'       => $this->data,
                        'firstname'     => $this->firstname,
                        'lastname'      => $this->lastname,
                        'email'         => $this->email, 
        );
        
        return $url.'?'.http_build_query($params);
    }
    
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }
    
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setReturnURL($returnURL)
    {
        $this->returnURL = $returnURL;
    }

    public function getReturnURL()
    {
        return $this->returnURL;
    }
    
    public function setCallbackURL($callbackURL)
    {
        $this->callbackURL = $callbackURL;
    }

    public function getCallbackURL()
    {
        return $this->callbackURL;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
    
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }
    
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}