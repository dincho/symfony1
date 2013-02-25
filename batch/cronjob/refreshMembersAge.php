<?php

/**
 * age refresh batch script
 *
 * Script that runs every day at 00:01 and refreshes age field for users which have birthday
 * Usage: "php refreshMemberesAge.php [full]"
 *   full: refreshes all users' birthdays
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

require_once(realpath(dirname(__FILE__).'/../config.php'));

function _refreshMembersAgeUsage( ) {
  fprintf(STDERR, "Usage: php %s [full]\r\n", basename(__FILE__));
  exit(1);
}

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$full = false;
if( 2 == $argc) {
  if( 'full' == $argv[1] ) {
    $full = true;
  }
  else {
    _refreshMembersAgeUsage( );
  }
}
elseif( 1 != $argc ) {
  _refreshMembersAgeUsage( );
}

$c = new Criteria();
if( !$full ) {
  $today = date('y-m-d', time());
  $tomorrow = date('y-m-d', time()+86400);

  $criterion = $c->getNewCriterion( MemberPeer::BIRTHDAY, $today, Criteria::GREATER_EQUAL );
  $criterion->addAnd( $c->getNewCriterion( MemberPeer::BIRTHDAY, $tomorrow, Criteria::LESS_THAN ) );
  $c->add( $criterion );
}

$members = MemberPeer::doSelect( $c );

foreach( $members as $member ) {
  $member->refreshAge( );
  $member->save( );
}
