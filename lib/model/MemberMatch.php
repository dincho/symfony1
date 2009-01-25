<?php

/**
 * Subclass for representing a row from the 'member_match' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberMatch extends BaseMemberMatch
{
    protected $reverse_pct = 0;
    public $last_action = null;
    
    
    public function getReversePct()
    {
        return $this->reverse_pct;
    }

    public function setReversePct($v)
    {
        if ($v !== null && !is_int($v) && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->reverse_pct !== $v || $v === 0) {
            $this->reverse_pct = $v;
            $this->modifiedColumns[] = MemberMatchPeer::REVERSE_PCT;
        }
    }
     
    public function getCombinedMatch()
    {
        return round(($this->getPct() + $this->getReversePct()) / 2);
    }
    
    public function hydrate(ResultSet $rs, $startcol = 1, $offset = 0)
    {
        try {

            $this->id = $rs->getInt($startcol + 0);

            $this->member1_id = $rs->getInt($startcol + 1);

            $this->member2_id = $rs->getInt($startcol + 2);

            $this->pct = $rs->getInt($startcol + 3);
            
            $this->reverse_pct = $rs->getInt($startcol + 4 + $offset);
            
            $this->last_action = $rs->getString($startcol + 5 + $offset);
            

            $this->resetModified();

            $this->setNew(false);

            return $startcol + 3; 
        } catch (Exception $e) {
            throw new PropelException("Error populating MemberMatch object", $e);
        }
    }   
}
