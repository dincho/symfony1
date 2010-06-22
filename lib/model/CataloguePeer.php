<?php

/**
 * Subclass for performing query and update operations on the 'catalogue' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CataloguePeer extends BaseCataloguePeer
{
    public static function getByTargetLang($lang)
    {
        $c = new Criteria();
        $c->add(CataloguePeer::TARGET_LANG, $lang);
        return CataloguePeer::doSelectOne($c);
    }
    
    public static function getAll($crit = null)
    {
        $c = ( is_null($crit) ) ? new Criteria() : clone $crit;
        
        return self::doSelect($c);
    }
}
