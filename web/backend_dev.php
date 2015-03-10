<?php
if (!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 
        '46.10.100.36', //VMLabs office
        '176.12.56.76', //Dincho's Home
        '172.28.128.1', //Vagrant host
    )))
{
  die('You are not allowed to access this file.');
}

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 
sfContext::getInstance()->getController()->dispatch();
