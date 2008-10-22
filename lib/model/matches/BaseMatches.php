<?php
/**
 * Subclass for representing a row from the 'matches' table.
 *
 * 
 *
 * @package lib.model
 */
class BaseMatches
{
    protected $member1_id;
    protected $member2_id;
    protected $score;
    protected $reverse_score;
    protected $combined_score;
    protected $aMemberRelatedByMember1Id;
    protected $aMemberRelatedByMember2Id;

    public function getMember1Id()
    {
        return $this->member1_id;
    }

    public function getMember2Id()
    {
        return $this->member2_id;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getReverseScore()
    {
        return $this->reverse_score;
    }

    public function getCombinedScore()
    {
        return $this->combined_score;
    }

    public function setMember1Id($v)
    {
        if ($v !== null && ! is_int($v) && is_numeric($v))
        {
            $v = (int) $v;
        }
        if ($this->member1_id !== $v)
        {
            $this->member1_id = $v;
            $this->modifiedColumns[] = MatchesPeer::MEMBER1_ID;
        }
        if ($this->aMemberRelatedByMember1Id !== null && $this->aMemberRelatedByMember1Id->getId() !== $v)
        {
            $this->aMemberRelatedByMember1Id = null;
        }
    }

    public function setMember2Id($v)
    {
        if ($v !== null && ! is_int($v) && is_numeric($v))
        {
            $v = (int) $v;
        }
        if ($this->member2_id !== $v)
        {
            $this->member2_id = $v;
            $this->modifiedColumns[] = MatchesPeer::MEMBER2_ID;
        }
        if ($this->aMemberRelatedByMember2Id !== null && $this->aMemberRelatedByMember2Id->getId() !== $v)
        {
            $this->aMemberRelatedByMember2Id = null;
        }
    }

    public function setScore($v)
    {
        if ($v !== null && ! is_int($v) && is_numeric($v))
        {
            $v = (int) $v;
        }
        if ($this->score !== $v)
        {
            $this->score = $v;
            $this->modifiedColumns[] = MatchesPeer::SCORE;
        }
    }

    public function setReverseScore($v)
    {
        if ($v !== null && ! is_int($v) && is_numeric($v))
        {
            $v = (int) $v;
        }
        if ($this->reverse_score !== $v)
        {
            $this->reverse_score = $v;
            $this->modifiedColumns[] = MatchesPeer::REVERSE_SCORE;
        }
    }

    public function setMemberRelatedByMember2Id($v)
    {
        if ($v === null) {
            $this->setMember2Id(NULL);
        } else {
            $this->setMember2Id($v->getId());
        }
        $this->aMemberRelatedByMember2Id = $v;
    }
    
    public function getMemberRelatedByMember2Id($con = null)
    {
        if ($this->aMemberRelatedByMember2Id === null && ($this->member2_id !== null)) {
                        include_once 'lib/model/om/BaseMemberPeer.php';

            $this->aMemberRelatedByMember2Id = MemberPeer::retrieveByPK($this->member2_id, $con);
        }
        return $this->aMemberRelatedByMember2Id;
    }
        
    
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        try
        {
            $this->member1_id = $rs->getInt($startcol + 0);
            $this->member2_id = $rs->getInt($startcol + 1);
            $this->score = $rs->getInt($startcol + 2);
            $this->reverse_score = $rs->getInt($startcol + 3);
            $this->combined_score = $rs->getInt($startcol + 4);
            $this->modifiedColumns = array();
            return $startcol + 5;
        } catch (Exception $e)
        {
            throw new PropelException("Error populating Matches object", $e);
        }
    }
}
