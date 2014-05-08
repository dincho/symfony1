<?php

/**
 * Subscription statuses
 *
 * - pending - on subscription creation, no payment and any confirmation yet      
 * - confirmed - subscription is confirmed, but no payment yet, 
 *       also used for prepaid-subscriptons ( with effective date in future )
 * - active
 * - failed - when subscription payment fails, this status is used to prevent EOT
 * - canceled - subscription has been canceled
 * - eot
 * - exprired - not cofirmed subscriptions should expire after 24 hours. ( not implemented yet )
 */

include(dirname(__FILE__).'/../bootstrap/unit_propel.php');

//tests
$t = new lime_test(29, new lime_output_color());

/**
 * Test subscription confirmation
 */

//fixtures
$member = RandomModelGenerator::generateMember();
$member->setSubscriptionId(SubscriptionPeer::FREE);
$subscription = new MemberSubscription();
$subscription->setSubscriptionId(SubscriptionPeer::VIP);
$subscription->setStatus('pending');
$member->addMemberSubscription($subscription);
$member->save();

$now = new DateTime();
$nowDb = $now->format('Y-m-d H:i:s');
$subscrId = 'PP' . rand(100000, 999999);

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'subscr_signup',
    'custom' => $subscription->getId(),
    'period3' => '3 M',
    'subscr_id' => $subscrId,
    'subscr_date' => $now->format('r'),
));
$c->handle();

//refresh DB objects
$member = MemberPeer::retrieveByPK($member->getId());
$subscription = MemberSubscriptionPeer::retrieveByPK($subscription->getId());

$t->is($member->getSubscriptionId(), SubscriptionPeer::FREE, 'member subscription is not modified');
$t->is($subscription->getStatus(), 'confirmed', 'status is set to confirmed');
$t->is($subscription->getPeriod(), '3', 'period is set');
$t->is($subscription->getPeriodType(), 'M', 'period type is set');
$t->is($subscription->getPPRef(), $subscrId, 'paypal reference is set');
$t->is($subscription->getCreatedAt(null), $now->getTimestamp(), 'created datetime is set');
$t->is($subscription->getUpdatedAt(null), $now->getTimestamp(), 'update datetime is set');


/**
 * Test subscription payment
 */

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'subscr_payment',
    'custom' => $subscription->getId(),
    'subscr_id' => $subscrId,
    'mc_gross' => '9.99',
    'mc_currency' => 'USD',
    'payment_status' => 'Completed',

));
$c->handle();

//refresh DB objects
$member = MemberPeer::retrieveByPK($member->getId());
$subscription = MemberSubscriptionPeer::retrieveByPK($subscription->getId());
$payment = $subscription->getLastCompletedPayment();
$subscriptionDetails = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId(
    $subscription->getSubscriptionId(),
    $member->getCatalogId()
);

$t->is($member->getSubscriptionId(), SubscriptionPeer::VIP, 'member subscription is upgraded');
$t->is($member->getLastPaymentState(), null, 'member LastPaymentState is cleared');
$t->is($subscription->getStatus(), 'active', 'subscription status is confirmed');
$t->is($subscription->getUpdatedAt(null), $now->getTimestamp(), 'update datetime is set');
$t->is($subscription->getPeriod(), 3, 'period is correct');
$t->is($subscription->getPeriodType(), 'M', 'period type is correct');

$effDt = DateTime::createFromFormat('U', $subscription->getEffectiveDate(null));
$t->is($effDt->format('Y-m-d'), $now->format('Y-m-d'), 'effective date is set');

$eotDt = clone $now;
$interval = sprintf(
    'P%d%s',
    $subscriptionDetails->getPeriod(),
    $subscriptionDetails->getPeriodType()
);
$eotDt->add(new DateInterval($interval));
$t->is($subscription->getEotAt('Y-m-d'), $eotDt->format('Y-m-d'), 'EOT is set');

/**
 * Test subscription modify
 */

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'subscr_modify',
    'subscr_id' => $subscrId,
    'period3' => '4 W',
    'item_number' => SubscriptionPeer::PREMIUM,
    'subscr_date' => $now->format('r'),
    'mc_amount' => '19.99',
    'mc_currency' => 'USD',
));
$c->handle();

//refresh DB objects
$member = MemberPeer::retrieveByPK($member->getId());
$subscription = MemberSubscriptionPeer::retrieveByPK($subscription->getId());

$t->is($member->getSubscriptionId(), SubscriptionPeer::PREMIUM, 'member subscription is upgraded');
$t->is($subscription->getSubscriptionId(), SubscriptionPeer::PREMIUM, 'MemberSubscription is upgarded');
$t->is($subscription->getUpdatedAt(null), $now->getTimestamp(), 'update datetime is set');
$t->is($subscription->getPeriod(), 4, 'period is correct');
$t->is($subscription->getPeriodType(), 'W', 'period type is correct');

/**
 * Test subscription failed
 */

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'subscr_failed',
    'subscr_id' => $subscrId,
));
$c->handle();

//refresh DB objects
$subscription = MemberSubscriptionPeer::retrieveByPK($subscription->getId());

$t->is($subscription->getStatus(), 'failed', 'subscription status is failed');

/**
 * Test subscription max failed payments when it's about current subscription
 */

$t->is(
    $member->getSubscriptionId(),
    SubscriptionPeer::PREMIUM,
    'precondition: member subscription is premium'
);

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'recurring_payment_suspended_due_to_max_failed_payment',
    'recurring_payment_id' => $subscrId,
));
$c->handle();

//refresh DB objects
$member = MemberPeer::retrieveByPK($member->getId());
$subscription = MemberSubscriptionPeer::retrieveByPK($subscription->getId());

$t->is($subscription->getStatus(), 'eot', 'subscription status is eot');
$t->is($member->getSubscriptionId(), SubscriptionPeer::FREE, 'member subscription is free');

/**
 * Test subscription max failed payments when member already upgarded to another
 * e.g. delayed notification
 */

/**
 * one failed subscription
 */
$subscrId = 'PP' . rand(10000, 99999);
$subscription = new MemberSubscription();
$subscription->setSubscriptionId(SubscriptionPeer::VIP);
$subscription->setStatus('pending');
$subscription->setPPRef($subscrId);
$member->addMemberSubscription($subscription);

$member_payment = new MemberPayment();
$member_payment->setMemberSubscription($subscription);
$member_payment->setMember($member);
$member_payment->setPaymentType('subscription');
$member_payment->setPaymentProcessor('paypal');
$member_payment->setAmount('10.99');
$member_payment->setCurrency('USD');
$member_payment->setStatus('Completed');
$member_payment->save();

$member_payment->applyToSubscription();
$member->save();

$yesterday = clone $now;
$yesterday->sub(new DateInterval('P1D'));
$subscription->setEffectiveDate($yesterday->format('Y-m-d'));
$subscription->setStatus('failed');
$subscription->save();

/**
 * an active subscription
 */

$activeSubscription = new MemberSubscription();
$activeSubscription->setSubscriptionId(SubscriptionPeer::PREMIUM);
$activeSubscription->setStatus('pending');
$activeSubscription->setPPRef('PP' . rand(10000, 99999));
$member->addMemberSubscription($activeSubscription);

$member_payment = new MemberPayment();
$member_payment->setMemberSubscription($activeSubscription);
$member_payment->setMember($member);
$member_payment->setPaymentType('subscription');
$member_payment->setPaymentProcessor('paypal');
$member_payment->setAmount('10.99');
$member_payment->setCurrency('USD');
$member_payment->setStatus('Completed');
$member_payment->save();

$member_payment->applyToSubscription();
$member->save();

$t->is(
    $member->getSubscriptionId(),
    SubscriptionPeer::PREMIUM,
    'precondition: member subscription is premium'
);

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'recurring_payment_suspended_due_to_max_failed_payment',
    'recurring_payment_id' => $subscrId,
));
$c->handle();

//refresh DB objects
$member = MemberPeer::retrieveByPK($member->getId());
$activeSubscription = MemberSubscriptionPeer::retrieveByPK($activeSubscription->getId());
$subscription = MemberSubscriptionPeer::retrieveByPK($subscription->getId());

$t->is($activeSubscription->getStatus(), 'active', 'current subscription status is active');
$t->is($subscription->getStatus(), 'eot', 'old subscription status is eot');
$t->is($member->getSubscriptionId(), SubscriptionPeer::PREMIUM, 'member subscription is not modified');


/**
 * Test subscription cancel
 */

$c = new sfPaypalPaymentCallback();
$c->setShouldValidate(false);
$c->initialize(array(
    'txn_type' => 'subscr_cancel',
    'subscr_id' => $activeSubscription->getPPRef(),
));
$c->handle();

//refresh DB objects
$activeSubscription = MemberSubscriptionPeer::retrieveByPK($activeSubscription->getId());
$t->is($activeSubscription->getStatus(), 'canceled', 'subscription status is canceled');

// //cleanup
$member->delete();
