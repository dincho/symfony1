<?php

sfPropelBehavior::registerMethods('paranoid', array(
  array('sfPropelParanoidBehavior', 'forceDelete'),
));

//@FIXME this hooks are invalid for current SF version see: ticket #5587 at trac.symfony-project.com
sfPropelBehavior::registerHooks('paranoid', array(
  ':delete:pre'                => array('sfPropelParanoidBehavior', 'preDelete'),
  'Peer:addDoSelectRS'         => array('sfPropelParanoidBehavior', 'doSelectRS'),
  'Peer:doSelectJoin'          => array('sfPropelParanoidBehavior', 'doSelectRS'),
  'Peer:doSelectJoinAll'       => array('sfPropelParanoidBehavior', 'doSelectRS'),
  'Peer:doSelectJoinAllExcept' => array('sfPropelParanoidBehavior', 'doSelectRS'),
));
