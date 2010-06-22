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

    public static function getByCultureAndCollection($msg_collection_id, Catalogue $catalog)
    {
        $c = new Criteria();
        $c->add(TransUnitPeer::MSG_COLLECTION_ID, $msg_collection_id);
        $c->add(TransUnitPeer::CAT_ID, $catalog->getCatId());
        
        return TransUnitPeer::doSelectOne($c);
    }

    public static function bulkUpdate($trans = array(), Catalogue $catalog)
    {

        foreach ($trans as $msg_coll_id => $value)
        {
            $trans_unit = TransUnitPeer::getByCultureAndCollection($msg_coll_id, $catalog);
            
            if (! $trans_unit)
            {
                $base_trans_unit = TransUnitPeer::getByCultureAndCollection($msg_coll_id, $catalog->getEnglishCatalogForDomain());
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
        $c->add(TransUnitPeer::CAT_ID, 1); //only one catalogue is enough, because tags are spread to all catalogs
        $c->add(TransUnitPeer::TAGS, '', Criteria::NOT_EQUAL);
        $c->addGroupByColumn(TransUnitPeer::TAGS);  
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
    
    public static function getTagsWithKeys()
    {
      $ret = array();
      foreach (self::getTagsList() as $tag)
      {
        $ret[$tag] = $tag;
      }
      
      return $ret;
    }
}
