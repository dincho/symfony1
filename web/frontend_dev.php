<?php
$paypal_addreses = array('216.113.188.202', '216.113.188.203', '216.113.188.204', '66.211.170.66', '216.113.191.33');

if (!in_array(@$_SERVER['REMOTE_ADDR'], array_merge($paypal_addreses, array('127.0.0.1', '::1', '212.36.28.66', '10.0.0.7'))))
{
  header('HTTP/1.1 403 Forbidden');
  die('Access denied.');
}

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 
sfContext::getInstance()->getController()->dispatch();
