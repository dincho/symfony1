<?php

/**
 * Subclass for representing a row from the 'ipn_history' table.
 *
 *
 *
 * @package lib.model
 */
class IpnHistory extends BaseIpnHistory
{
    private $params = null;
    public function getParameters()
    {
        if ( is_null($this->params)) {
            $this->params = unserialize(parent::getParameters());
        }

        return $this->params;
    }

    public function getParam($key)
    {
        $params = $this->getParameters();

        return (array_key_exists($key, $params)) ? $params[$key] : null;
    }
}
