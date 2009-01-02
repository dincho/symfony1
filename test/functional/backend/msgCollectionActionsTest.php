<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

$browser->
  get('/msgCollection/index')->
  isStatusCode(200)->
  isRequestParameter('module', 'msgCollection')->
  isRequestParameter('action', 'index')->
  checkResponseElement('body', '!/This is a temporary page/')
;
