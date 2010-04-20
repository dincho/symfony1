<?php

/**
 * IPNReplay batch script
 *
 * Replay ( simulate incoming notification ) all db records/history
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();


$paypal = new sfPaypalPaymentCallback();
$paypal->setShouldValidate(false);
$paypal->setShouldLogNotification(false);


$c = new Criteria();
$c->add(IpnHistoryPeer::TXN_TYPE, array('subscr_signup', 'subscr_cancel', 'subscr_payment'), Criteria::IN);
$c->addAscendingOrderByColumn(IpnHistoryPeer::TXN_CREATED_AT);
$c->addAscendingOrderByColumn( sprintf("FIELD(%s,%s)", IpnHistoryPeer::TXN_TYPE, "'subscr_signup', 'subscr_payment', 'subscr_cancel'") );
$history_records = IpnHistoryPeer::doSelect($c);

foreach( $history_records as $history)
{
    $paypal->initialize(new sfWebRequest(), $history->getParameters());
    $paypal->handle();
}