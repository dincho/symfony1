<?php

/**
 * Subclass for representing a row from the 'thread' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Thread extends BaseThread
{
    public function isRead()
    {
        return ($this->unread == 0);
    }
    
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $r = parent::hydrate($rs, $startcol);
        $last_loc = BaseThreadPeer::NUM_COLUMNS - BaseThreadPeer::NUM_LAZY_LOAD_COLUMNS;

        $this->object_id = $rs->getInt($last_loc);
        
        return $r+1;
    }
    
    
}
