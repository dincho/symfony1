<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$member = RandomModelGenerator::generateMember();
$member->setPassword('123qwe');
$member->setMemberStatusId(MemberStatusPeer::ACTIVE);
$member->setSubscriptionId(SubscriptionPeer::FREE);
$member->setHasEmailConfirmation(true);
$member->save();

// create a new test browser
$b = new prTestBrowser();
$b->initialize();

$b
    //login
    ->get('/signin')
    ->isStatusCode(200)
    ->click('Sign In', array(
        'email'     => $member->getEmail(),
        'password'  => '123qwe',
    ))

    //subscription page
    ->get('/subscription')
    ->isStatusCode(200)
    ->isRequestParameter('module', 'subscription')
    ->isRequestParameter('action', 'index')

    //payment page
    ->get('/subscription/payment/sid/' . SubscriptionPeer::VIP)
    ->isStatusCode(200)
    ->isRequestParameter('module', 'subscription')
    ->isRequestParameter('action', 'payment')
    ->responseContains('Subscribe With PayPal')
    ->responseContains('Pay with DotPay')
;
