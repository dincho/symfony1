<?php

/**
 * Subclass for performing query and update operations on the 'trans_unit' table.
 *
 * 
 *
 * @package lib.model
 */
class TransUnitPeer extends BaseTransUnitPeer
{

    public static function getByCultureAndCollection($msg_collection_id, $culture)
    {
        $c = new Criteria();
        $c->add(TransUnitPeer::MSG_COLLECTION_ID, $msg_collection_id);
        $c->addJoin(TransUnitPeer::CAT_ID, CataloguePeer::CAT_ID);
        $c->add(CataloguePeer::TARGET_LANG, $culture);
        
        return TransUnitPeer::doSelectOne($c);
    }

    public static function bulkUpdate($trans = array(), $culture)
    {
        $catalog = CataloguePeer::getByTargetLang($culture);
        foreach ($trans as $msg_coll_id => $value)
        {
            $trans_unit = TransUnitPeer::getByCultureAndCollection($msg_coll_id, $culture);
            
            if (! $trans_unit)
            {
                $base_trans_unit = TransUnitPeer::getByCultureAndCollection($msg_coll_id, 'en');
                if (! $base_trans_unit) throw new sfException('Trans unit: ' . $msg_coll_id . ' has no base unit.');
                
                $trans_unit = new TransUnit();
                $base_trans_unit->copyInto($trans_unit);
                $trans_unit->setCatId($catalog->getCatId());
                $trans_unit->setMsgCollectionId($msg_coll_id);
                $trans_unit->setDateAdded(time());
            }
            
            $trans_unit->setDateModified(time());
            $trans_unit->setTarget($value);
            $trans_unit->save();
        }
        
        $catalog->setDateModified(time());
        $catalog->save();
    }
    
    public static function createNewUnit($source, $tags = '')
    {
        $catalogs = CataloguePeer::doSelect(new Criteria());
        
        foreach ($catalogs as $catalog)
        {
            $trans_unit = new TransUnit();
            $trans_unit->setCatId($catalog->getCatId());
            $trans_unit->setSource($source);
            $trans_unit->setTags($tags);
            $trans_unit->save();
        }
    }
    
    public static function getTagsList()
    {
        $c = new Criteria();
        $c->add(TransUnitPeer::TAGS, '', Criteria::NOT_EQUAL);
        
        $units = TransUnitPeer::doSelect($c);
        
        $tags = array();
        foreach ($units as $unit)
        {
        	$tags = array_merge($tags, array_map('trim', explode(',', $unit->getTags())));
        }
        
        $tags = array_unique($tags);
        sort($tags);
        
        return $tags;
    }
}
