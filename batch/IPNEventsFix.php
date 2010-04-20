<?php
define('SF_ROOT_DIR',    realpath(dirname(__file__).'/..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$events = IpnHistoryPeer::doSelect(new Criteria());

foreach ($events as $event)
{
    echo "Processing IPN notification with business field: " . $event->getParam('business') . "...";
    if( $event->getParam('business') != 'futurise@gmail.com' )
    {
        echo "Deleted!";
        $event->delete();
    } else {
        if( $event->getParam('subscr_date') )
        {
            $note_time = strtotime($event->getParam('subscr_date'));
        } elseif ( $event->getParam('payment_date') )
        {
            $note_time = strtotime($event->getParam('payment_date'));
        } elseif ($event->getParam('time_created')  )
        {
            $note_time = strtotime($event->getParam('time_created'));
        }
        
        $event->setTxnCreatedAt($note_time);
        $event->save();
        
        echo "TXN Date updated.";
    }
    
    echo "\n";
}


//deleting test subscription with missing "subscr_signup" event
$c = new Criteria();
$c->add(IpnHistoryPeer::SUBSCR_ID, 'I-P3UUKJ0VRVEC');
IpnHistoryPeer::doDelete($c);