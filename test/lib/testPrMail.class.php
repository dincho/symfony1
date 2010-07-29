<?php
class testPrMail extends prMail
{
    public function send()
    {
        $this->setBody(nl2br($this->getBody()));
        
        return true;
    }
}