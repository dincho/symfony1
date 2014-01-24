<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new prTestBrowser();
$b->initialize();

//zong
$b->post('/callbacks/zong', array(
  ))
  ->isStatusCode(200)
  ->isRequestParameter('module', 'callbacks')
  ->isRequestParameter('action', 'zong')
  ->responseContains(':OK')
;

//dotpay
$b->post('/callbacks/dotpay', array(
  ))
  ->isStatusCode(200)
  ->isRequestParameter('module', 'callbacks')
  ->isRequestParameter('action', 'dotpay')
;

$b->test()->is($b->getResponse()->getContent(), 'OK');

//paypal
$b->post('/callbacks/paypal', array(
  ))
  ->isStatusCode(200)
  ->isRequestParameter('module', 'callbacks')
  ->isRequestParameter('action', 'paypal')
;
