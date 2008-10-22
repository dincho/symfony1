<?php
/*
 * This file is part of the sfPropelActAsSortableBehavior package.
 * 
 * (c) 2007 Francois Zaninotto <francois.zaninotto@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Unit tests for the sfPropelActAsSortableBehavior plugin.
 *
 * Despite running unit tests, we use the functional tests bootstrap to take advantage of propel
 * classes autoloading...
 * 
 * In order to run the tests in your context, you have to copy this file in a symfony test directory
 * and configure it appropriately (see the "configuration" section at the beginning of the file)
 *  
 * @author   Francois Zaninotto <francois.zaninotto@symfony-project.com>
 */

// configuration
// -- an existing application name
$app = 'frontend';

// -- the model class the tests should use
$sortable_class = 'sfSimpleForumCategory';
$sortable_field = 'rank';

// -- path to the symfony project where the plugin resides
$sf_path = dirname(__FILE__).'/../../../..';
 
// bootstrap
include($sf_path . '/test/bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$con = Propel::getConnection();

$sortable_peer_class = $sortable_class.'Peer';

// cleanup database
call_user_func(array($sortable_peer_class, 'doDeleteAll'));

// register behavior on test object
sfPropelBehavior::add($sortable_class, array('act_as_sortable' => array('column' => $sortable_field)));




// Now we can start to test
$t = new lime_test(48, new lime_output_color());

$t->diag('new methods');
$t->ok(is_callable($sortable_class, 'getPosition'), 'Behavior adds a new getPosition() method to the object class');
$t->ok(is_callable($sortable_class, 'setPosition'), 'Behavior adds a new setPosition() method to the object class');
$t->ok(is_callable($sortable_class, 'swapWith'), 'Behavior adds a new swapWith() method to the object class');
$t->ok(is_callable($sortable_class, 'getNext'), 'Behavior adds a new getNext() method to the object class');
$t->ok(is_callable($sortable_class, 'getPrevious'), 'Behavior adds a new getPrevious() method to the object class');
$t->ok(is_callable($sortable_class, 'isFirst'), 'Behavior adds a new isFirst() method to the object class');
$t->ok(is_callable($sortable_class, 'isLast'), 'Behavior adds a new isLast() method to the object class');
$t->ok(is_callable($sortable_class, 'moveUp'), 'Behavior adds a new moveUp() method to the object class');
$t->ok(is_callable($sortable_class, 'moveDown'), 'Behavior adds a new moveDown() method to the object class');

$t->diag('sfPropelActAsSortableBehavior::getMaxPosition()');
$t->is(sfPropelActAsSortableBehavior::getMaxPosition($sortable_peer_class), 0, 'sfPropelActAsSortableBehavior::getMaxPosition($peer_class) returns 0 when there is no record');
call_user_func(array($sortable_peer_class, 'doDeleteAll'));
$item1 = new $sortable_class();
$item1->save();
$item2 = new $sortable_class();
$item2->save();
$item3 = new $sortable_class();
$item3->save();
$t->is(sfPropelActAsSortableBehavior::getMaxPosition($sortable_peer_class), 3, 'sfPropelActAsSortableBehavior::getMaxPosition($peer_class) returns the current maximum rank');

$t->diag('sfPropelActAsSortableBehavior::retrieveByPosition()');
$item = sfPropelActAsSortableBehavior::retrieveByPosition($sortable_peer_class, 2);
$t->is($item->getPosition(), 2, 'sfPropelActAsSortableBehavior::retrieveByPosition($peer_class, $rank) returns the object of rank $rank');

$t->diag('sfPropelActAsSortableBehavior::doSelectOrderByPosition()');
call_user_func(array($sortable_peer_class, 'doDeleteAll'));
$t->is_deeply(sfPropelActAsSortableBehavior::doSelectOrderByPosition($sortable_peer_class), array(), 'sfPropelActAsSortableBehavior::doSelectOrderByPosition($peer_class) returns an empty array when there is no record');
$item1 = new $sortable_class();
$item1->setPosition(2);
$item1->save();
$id1 = $item1->getId();
$item2 = new $sortable_class();
$item2->setPosition(3);
$item2->save();
$id2 = $item2->getId();
$item3 = new $sortable_class();
$item3->setPosition(1);
$item3->save();
$id3 = $item3->getId();
$items = sfPropelActAsSortableBehavior::doSelectOrderByPosition($sortable_peer_class);
$t->is($items[0]->getId(), $id3, 'sfPropelActAsSortableBehavior::doSelectOrderByPosition($peer_class) returns objects ordered by position');
$t->is($items[1]->getId(), $id1, 'sfPropelActAsSortableBehavior::doSelectOrderByPosition($peer_class) returns objects ordered by position');
$t->is($items[2]->getId(), $id2, 'sfPropelActAsSortableBehavior::doSelectOrderByPosition($peer_class) returns objects ordered by position');

$t->diag('sfPropelActAsSortableBehavior::doSort()');
$t->is(sfPropelActAsSortableBehavior::doSort($sortable_peer_class, array(
  $id1 => 3,
  $id2 => 2,
  $id3 => 1,
  )), true, 'sfPropelActAsSortableBehavior::doSort($peer_class, $order) returns true when successful');
$items = sfPropelActAsSortableBehavior::doSelectOrderByPosition($sortable_peer_class);
$t->is($items[0]->getId(), $id3, 'sfPropelActAsSortableBehavior::doSort($peer_class, $order) reorders objects');
$t->is($items[1]->getId(), $id2, 'sfPropelActAsSortableBehavior::doSort($peer_class, $order) reorders objects');
$t->is($items[2]->getId(), $id1, 'sfPropelActAsSortableBehavior::doSort($peer_class, $order) reorders objects');

$t->diag('setPosition() and getPosition()');
call_user_func(array($sortable_peer_class, 'doDeleteAll'));
$item = new $sortable_class();
$item->setPosition(123);
$t->is($item->getByname($sortable_field, BasePeer::TYPE_FIELDNAME), 123, 'setPosition() sets position on the field passed to the behavior constructor');
$t->is($item->getPosition(), 123, 'getPosition() gets position on the field passed to the behavior constructor');

$t->diag('save()');
call_user_func(array($sortable_peer_class, 'doDeleteAll'));
$item1 = new $sortable_class();
$item1->save();
$id1 = $item1->getId();
$t->is($item1->getPosition(), 1, 'save() sets the rank to the current max rank plus one');
$item2 = new $sortable_class();
$item2->save();
$id2 = $item2->getId();
$t->is($item2->getPosition(), 2, 'save() sets the rank to the current max rank plus one');
$item3 = new $sortable_class();
$item3->save();
$id3 = $item3->getId();
$t->is($item3->getPosition(), 3, 'save() sets the rank to the current max rank plus one');
$item4 = new $sortable_class();
$item4->setRank(12);
$item4->save();
$t->is($item4->getPosition(), 12, 'save() does not override the rank if it is already set');
$item4->delete();

$t->diag('getNext() and getPrevious()');
$t->is($item2->getNext()->getId(), $id3, 'getNext() returns the next object in rank order');
$t->isa_ok($item3->getNext(), 'NULL', 'getNext() returns null when called on the object of highest rank');
$t->is($item2->getPrevious()->getId(), $id1, 'getPrevious() returns the previous object in rank order');
$t->isa_ok($item1->getPrevious(), 'NULL', 'getPrevious() returns null when called on the object of first rank');

$t->diag('isFirst() and isLast()');
$t->is($item1->isFirst(), true, 'isFirst() returns true for the first object in order');
$t->is($item2->isFirst(), false, 'isFirst() returns false for other objects');
$t->is($item3->isFirst(), false, 'isFirst() returns false for other objects');
$t->is($item3->isLast(), true, 'isLast() returns true for the last object in order');
$t->is($item1->isLast(), false, 'isLast() returns false for other objects');
$t->is($item1->isLast(), false, 'isLast() returns false for other objects');

$t->diag('moveUp() and moveDown()');
$t->is($item1->moveUp(), false, 'moveUp() returns false when called on the object of lowest rank');
$t->is_deeply($item2->moveUp(), array(2, 1), 'moveUp() returns an array of swapped positions when called successfully');
$t->is(sfPropelActAsSortableBehavior::retrieveByPosition($sortable_peer_class, 1)->getId(), $id2, 'moveUp() moves the object up (decreases the rank)');
$t->is(sfPropelActAsSortableBehavior::retrieveByPosition($sortable_peer_class, 2)->getId(), $id1, 'moveUp() moves the previous object down');
$t->is($item3->moveDown(), false, 'moveDown() returns false when called on the object of highest rank');
$t->is_deeply(sfPropelActAsSortableBehavior::retrieveByPosition($sortable_peer_class, 2)->moveDown(), array(2, 3), 'moveDown() returns an array of swapped positions when called successfully');
$t->is(sfPropelActAsSortableBehavior::retrieveByPosition($sortable_peer_class, 3)->getId(), $id1, 'moveDown() moves the object down (increases the rank)');
$t->is(sfPropelActAsSortableBehavior::retrieveByPosition($sortable_peer_class, 2)->getId(), $id3, 'moveDown() moves the next object up');

$t->diag('delete()');
call_user_func(array($sortable_peer_class, 'doDeleteAll'));
$item1 = new $sortable_class();
$item1->save();
$id1 = $item1->getId();
$item2 = new $sortable_class();
$item2->save();
$id2 = $item2->getId();
$item3 = new $sortable_class();
$item3->save();
$id3 = $item3->getId();
$item2->delete();
$item3 = call_user_func(array($sortable_peer_class, 'retrieveByPk'), $id3);
$t->is($item3->getPosition(), 2, 'delete() decreases the rank of the following records by one');
$item1 = call_user_func(array($sortable_peer_class, 'retrieveByPk'), $id1);
$t->is($item1->getPosition(), 1, 'delete() does no decrease the rank of the previous records in the order');
$item1->delete();
$item3->delete();

$t->diag('swapWith()');
call_user_func(array($sortable_peer_class, 'doDeleteAll'));
$item1 = new $sortable_class();
$item1->save();
$item2 = new $sortable_class();
$item2->save();
$item3 = new $sortable_class();
$item3->save();
$item2->swapWith($item1);
$t->is($item1->getPosition(), 2, 'swapWith() exchanges the rank of two adjacent records');
$t->is($item2->getPosition(), 1, 'swapWith() exchanges the rank of two adjacent records');