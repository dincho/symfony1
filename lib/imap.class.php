<?php
class IMAP
{
    private $host = '{host/notls}INBOX';
    private $user = 'username';
    private $pass = 'password';
    private $port = '143';
    
    private $stream = null;
    //private $from = 'someone@example.com'; //Mail to send from

    public function __construct()
    {
        $this->port = sfConfig::get('app_mail_port');
        $this->host = '{'. sfConfig::get('app_mail_host') .':'. $this->port .'/imap/ssl/novalidate-cert/user=autocheck@polishromance.com}INBOX';
        $this->user = sfConfig::get('app_mail_username');
        $this->pass = sfConfig::get('app_mail_password');
        
        $this->stream = imap_open($this->host,$this->user,$this->pass);
        
        if( $this->stream === false ) throw new sfException('Can not connect to mail server: ' . imap_last_error() );
        
    }
    
    public function getMessages()
    {
        $messages = array();
        $numMessages = imap_num_msg($this->stream);
        
        for ($message_id = 1; $message_id <= $numMessages; $message_id ++)
        {
            $message = new imap_message($this->stream, $message_id);
            $messages[] = $message;
        }
        
        return $messages;
    }
    
    public function __destruct()
    {
        imap_close($this->stream);
    }
}



class IMAP_Message
{
    private $ID = null;
    private $UID = null;
    private $header = null;
    private $subject = '';
    private $body = '';
    private $to = '';
    private $from = '';
    private $stream = null;
    private $system_encoding = 'UTF-8';
    private $TS = null;
    
    public function __construct($stream, $ID)
    {
        $this->stream = $stream;
        $this->setID($ID);
        $this->parseMessage();
    }
    
    public function parseMessage()
    {
        $this->setHeader(imap_header($this->stream, $this->ID));
        
        //parts ( body + attachments )
        $body = '';
        $s = imap_fetchstructure($this->stream, $this->ID);
        if (! property_exists($s, 'parts'))
        {
            $body = imap_body($this->stream, $this->ID);
            $body = $this->parsePart($body, $s);
            
        } else
        {
            foreach ($s->parts as $partno => $p)
            {
                if ($p->type == 0) //we need only text
                {
                    $part = imap_fetchbody($this->stream, $this->ID, $partno + 1);
                    $body .= $this->parsePart($part, $p);
                }
            }
        }

        $this->setBody($body);
    }
    
    public function parsePart($content = '', stdClass $part)
    {
        if ($part->encoding == 4)
            $content = quoted_printable_decode($content);
        if ($part->encoding == 3)
            $content = base64_decode($content);
        if (strtoupper($part->subtype) == 'PLAIN')
            $content = nl2br($content);
        if (strtoupper($part->subtype) == 'HTML') $content = strip_tags($content, '<p><a><br><hr><ul><li><ol><style><div>');
        
        $content = $this->convertToSystemEncoding($content, $part->parameters[0]->value);
        
        return $content;
    }
    
    public function convertToSystemEncoding($string, $string_encoding = null)
    {
        if( is_null($string_encoding) )
        {
            $string_encoding = mb_detect_encoding($string);
        }
        
        if( $string_encoding != $this->system_encoding && $string_encoding != 'default' )
        {
            $string = mb_convert_encoding($string, $this->system_encoding, $string_encoding);
        }
        
        return $string;
    }
    
    /**
     * @return integer
     */
    
    public function getTS() { return $this->TS; }
    
    /**
     * @return string
     */
    public function getBody () { return $this->body; }
    
    /**
     * @return string
     */
    public function getFrom () 
    { 
        return ( $this->getFromName() ) ? $this->getFromName() . ' <' . $this->getFromMail() . '>' : $this->getFromMail();
    }
    
    public function getFromMail()
    {
        return $this->from->mailbox . '@' . $this->from->host;
    }
    
    public function getFromName()
    {
        return (property_exists($this->from, 'personal')) ? $this->from->personal : null;
    }
    
    /**
     * @return string
     */
    public function getTo () 
    { 
        return ( $this->getToName() ) ? $this->getToName() . ' <' . $this->getToMail() . '>' : $this->getToMail();
    }
    
    public function getToMail()
    {
        return $this->to->mailbox . '@' . $this->to->host;
    }
    
    public function getToName()
    {
        return (property_exists($this->to, 'personal')) ? $this->to->personal : null;
    }
    
    /**
     * @return stdClass
     */
    public function getHeader () { return $this->header; }
    
    /**
     * @return integer
     */
    public function getID () { return $this->ID; }
    
    /**
     * @return string
     */
    public function getSubject () { return $this->subject; }
    
    /**
     * @return string
     */
    public function getUID () { return $this->uID; }
    
    /**
     * @param string $body
     */
    public function setBody ($body) { $this->body = $body; }
    
    /**
     * @param stdClass $from
     */
    public function setFrom (stdClass $from) { $this->from = $from; }
    
    /**
     * @param stdClass $header
     */
    public function setHeader (stdClass $header) 
    { 
        $this->header = $header;
        $this->TS = strtotime($header->date);
        $decode = imap_mime_header_decode($header->subject);
        $this->subject = $this->convertToSystemEncoding($decode[0]->text, $decode[0]->charset);
        $this->setFrom($header->from[0]);
        $this->setTo($header->to[0]);
        
    }
    
    /**
     * @param integer $ID
     */
    public function setID ($ID) { $this->ID = $ID; }
    
    /**
     * @param stdClass $to
     */
    public function setTo (stdClass $to) { $this->to = $to; }
    
    /**
     * @param string $UID
     */
    public function setUID ($uID) { $this->uID = $uID; }

    public function delete()
    {
        imap_delete($this->stream, $this->getID());
    }
}