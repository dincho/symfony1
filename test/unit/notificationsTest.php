<?php
include(dirname(__FILE__).'/../bootstrap/unit_propel.php');

$member1_subscription = new MemberSubscription();
$member1_subscription->setSubscriptionId(2);
$member1_subscription->setPeriod(1);
$member1_subscription->setPeriodType('M');
$member1_subscription->setEffectiveDate(time());
$member1_subscription->setStatus('active');
$member1_subscription->setEotAt(time()+30*24*60*60); //30 days

$member1 = RandomModelGenerator::generateMember();
$member1->addMemberSubscription($member1_subscription);

$member2 = RandomModelGenerator::generateMember();
 //we need the member ID to test notifications
$member1->save();
$member2->save();

$thread = new Thread();
$thread->setSubject(RandomGenerator::getSentence());

$message = new Message();
$message->setThread($thread);
$message->setMemberRelatedBySenderId($member1);
$message->setMemberRelatedByRecipientId($member2);

//tests
$t = new lime_test(27, new lime_output_color());
$t->is(Events::triggerJoin($member1), true, 'triggerJoin event executed successful');
$t->is(Events::triggerWelcome($member1, 'localhost'), true, 'triggerWelcome event executed successful');
$t->is(Events::triggerWelcomeApproved($member1), true, 'triggerWelcomeApproved event executed successful');
$t->is(Events::triggerForgotPassword($member1), true, 'triggerForgotPassword event executed successful');
$t->is(Events::triggerNewPasswordConfirm($member1), true, 'triggerNewPasswordConfirm event executed successful');
$t->is(Events::triggerNewEmailConfirm($member1), true, 'triggerNewEmailConfirm event executed successful');
$t->is(Events::triggerNewEmailConfirmed($member1), true, 'triggerNewEmailConfirmed event executed successful');
$t->is(Events::triggerAccountDeleteByMember($member1), true, 'triggerAccountDeleteByMember event executed successful');
$t->is(Events::triggerAccountDeactivation($member1), true, 'triggerAccountDeactivation event executed successful');
$t->is(Events::triggerAutoRenew($member1), true, 'triggerAutoRenew event executed successful');
$t->is(Events::triggerScamActivity($member1, 10), true, 'triggerScamActivity event executed successful');
$t->is(Events::triggerSpamActivity($member1, 10), true, 'triggerSpamActivity event executed successful');
$t->is(Events::triggerAbandonedRegistration($member1), true, 'triggerAbandonedRegistration event executed successful');
$t->is(Events::triggerFirstContact($message), true, 'triggerFirstContact event executed successful');
$r = Events::triggerTellFriend($name = "Some Name", $email = "mail@localhost", $friend_name = "friend_name", $friend_email = "friend@localhost", RandomGenerator::getSentence());
$t->is($r, true, 'triggerTellFriend event executed successful');
$t->is(Events::triggerGiftReceived($member1, $member2), true, 'triggerGiftReceived event executed successful');
$t->is(Events::triggerRegistrationReminder($member1), true, 'triggerRegistrationReminder event executed successful');
$t->is(Events::triggerLoginReminder($member1, 10), true, 'triggerLoginReminder event executed successful');
$t->is(Events::triggerAccountActivity($member1), true, 'triggerAccountActivity event executed successful');
$t->is(Events::triggerAccountActivityMessage($member1, $member2, $message), true, 'triggerAccountActivityMessage event executed successful');
$t->is(Events::triggerAccountActivitySystemMessage($member1, $message), true, 'triggerAccountActivitySystemMessage event executed successful');
$t->is(Events::triggerAccountActivityWink($member1, $member2), true, 'triggerAccountActivityWink event executed successful');
$t->is(Events::triggerAccountActivityHotlist($member1, $member2), true, 'triggerAccountActivityHotlist event executed successful');
$t->is(Events::triggerAccountActivityVisitor($member1, $member2), true, 'triggerAccountActivityVisitor event executed successful');
$t->is(Events::triggerAccountActivityRate($member1, $member2), true, 'triggerAccountActivityRate event executed successful');
$t->is(Events::triggerAccountActivityMutualRate($member1, $member2), true, 'triggerAccountActivityMutualRate event executed successful');
$t->is(Events::triggerAccountActivityPrivatePhotosGranted($member1, $member2), true, 'triggerAccountActivityPrivatePhotosGranted event executed successful');

//cleanup
$member1->delete();
$member2->delete();

