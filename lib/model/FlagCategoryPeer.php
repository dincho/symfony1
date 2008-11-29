<?php

/**
 * Subclass for performing query and update operations on the 'flag_category' table.
 *
 * 
 *
 * @package lib.model
 */ 
class FlagCategoryPeer extends BaseFlagCategoryPeer
{
    public static function getAssoc()
    {
        $cats = self::doSelect(new Criteria());
        
        $ret = array();
        foreach ($cats as $cat)
        {
            $ret[$cat->getId()] = $cat;
        }
        
        return $ret;
    }
}
