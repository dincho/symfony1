<?php

abstract class sfPaymentCallback
{
    private $params = array();
    protected $shouldValidate = true;
    protected $shouldLogNotification = true;

    public function __construct()
    {

    }

    final public function initialize(array $params)
    {
        $this->setParams($params);
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function getParam($key, $default = null)
    {
        return ( isset($this->params[$key])) ? $this->params[$key] : $default;
    }

    public function handle()
    {
        if ( $this->shouldValidate() ) {
            if( $this->validate() ) $this->processNotification();
        } else {
            $this->processNotification();
        }

        if( $this->shouldLogNotification() ) $this->logNotification();
    }

    public function setShouldValidate($bool)
    {
        $this->shouldValidate = $bool;
    }

    public function shouldValidate()
    {
        return $this->shouldValidate;
    }

    public function setShouldLogNotification($bool)
    {
        $this->shouldLogNotification = $bool;
    }

    public function shouldLogNotification()
    {
        return $this->shouldLogNotification;
    }

    abstract protected function validate();
    abstract protected function log($message, $priority = SF_LOG_INFO);
    abstract protected function logNotification();
    abstract protected function processNotification();
}
