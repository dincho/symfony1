<?php

/**
 * Subclass for representing a row from the 'member_story' table.
 *
 *
 *
 * @package lib.model
 */
class MemberStory extends BaseMemberStory
{
}

$columns_map = array('from'   => MemberStoryPeer::TITLE,
                     'to'     => MemberStoryPeer::SLUG);

sfPropelBehavior::add('MemberStory', array('sfPropelActAsSluggableBehavior' => array('columns' => $columns_map, 'separator' => '_', 'permanent' => true)));
