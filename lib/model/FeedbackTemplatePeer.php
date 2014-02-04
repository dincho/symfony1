<?php

/**
 * Subclass for performing query and update operations on the 'feedback_template' table.
 *
 * @package lib.model
 */
class FeedbackTemplatePeer extends BaseFeedbackTemplatePeer
{
    public static function getTagsList()
    {
        $c = new Criteria();
        $c->add(self::TAGS, '', Criteria::NOT_EQUAL);
        $c->addGroupByColumn(self::TAGS);
        $units = self::doSelect($c);

        $tags = array();
        foreach ($units as $unit) {
            $tags = array_merge($tags, array_map('trim', explode(',', $unit->getTags())));
        }

        $tags = array_unique($tags);
        sort($tags);

        return $tags;
    }
    
    public static function getTagsWithKeys()
    {
        $ret = array();
        foreach (self::getTagsList() as $tag) {
            $ret[$tag] = $tag;
        }

        return $ret;
    }

}
