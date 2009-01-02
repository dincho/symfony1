<?php

/**
 * Subclass for performing query and update operations on the 'trans_collection' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TransCollectionPeer extends BaseTransCollectionPeer
{
    const HOMEPAGE = 1;
    const PROFILE  = 2;
    const SEARCH_MOST_RECENT = 3;
    const SEARCH_CUSTOM = 4;
    const SEARCH_REVERSE = 5;
    const SEARCH_MATCHES = 6;
    const SEARCH_KEYWORD = 7;
    const SEARCH_PROFILE_ID = 8;
    const SEARCH_PUBLIC = 9;
    const REGISTRATION_JOIN = 15;
    const REGISTRATION_REG = 10;
    const REGISTRATION_SELF = 11;
    const REGISTRATION_ESSAY = 12;
    const REGISTRATION_PHOTOS = 13;
    const REGISTRATION_SEARCH = 14;
    const IMBRA_APP = 16;
    
    public static function getCollection($id, $culture)
    {
        $c = new Criteria();
        $c->addJoin(TransUnitPeer::CAT_ID, CataloguePeer::CAT_ID);
        $c->addJoin(TransUnitPeer::MSG_COLLECTION_ID, MsgCollectionPeer::ID);
        $c->addJoin(MsgCollectionPeer::TRANS_COLLECTION_ID, TransCollectionPeer::ID);
        $c->add(CataloguePeer::TARGET_LANG, $culture);
        $c->add(TransCollectionPeer::ID, $id);
        
        $trans = TransUnitPeer::doSelect($c);
        
        $ret = array();
        foreach ($trans as $tran)
        {
            $ret[$tran->getMsgCollectionId()] = $tran;
        }
        
        return $ret;
    }
}
