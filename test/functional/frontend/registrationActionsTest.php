<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new prTestBrowser();
$browser->initialize();

$browser->
  get('/joinNow')->
  isStatusCode(200)->
  isRequestParameter('module', 'registration')->
  isRequestParameter('action', 'joinNow')->
  click('GO!', array('email' => 'test@polishdate.com', 
                     'password' => '123qwe', 
                     'repeat_password' => '123qwe', 
                     'looking_for' => 'M_F', 
                     'username' => 'tester', 
                     'tos' => 1))->
  isRedirected()->   //member is redirected on success
  followRedirect()->
  isStatusCode(200)->
  isRequestParameter('module', 'content')->
  isRequestParameter('action', 'message')->
  responseContains('Verify your email headline')
  
;

// $browser->getRequest()->hasErrors();

// var_dump($browser->getResponse()->getContent());
