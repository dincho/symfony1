<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 7, 2009 11:47:49 AM
 * 
 */

class FrontendProfilePager
{
    private $offset = 0;
    private $prev = null;
    private $next = null;
    private $currentMember = null;
    
    public static function init($userId, $offset)
    {
        $cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'last_search_criteria';
        $search_crit_cache = new sfFileCache($cache_dir);
        $crit_data = $search_crit_cache->get($userId, null);
        
        if ($crit_data) {
            $criteria = unserialize($crit_data);
            $criteria->setOffset($offset);
            $criteria->setLimit(3);
            $matches = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($criteria);
        } else {
            $matches = array();
        }
        
        return new self($matches, $offset);
    }
    
    public static function storeCriteria($userId, Criteria $c)
    {
        $cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'last_search_criteria';
        $search_crit_cache = new sfFileCache($cache_dir);
        $search_crit_cache->set($userId, null, serialize($c));
    }
    
    public function __construct(array $matches, $offset)
    {
        $this->offset = $offset;
        $this->setMatches($matches);
    }
    
    protected function setMatches($matches)
    {
        $match = null;
        $cnt = count($matches);
        
        switch ($cnt) {
            case 3: //full set of 3 results
                $this->currentMember = $matches[1]->getMemberRelatedByMember2Id(); //middle
                $this->prev = $this->offset - 1;
                $this->next = $this->offset + 1;
                
                //first record
                if ($this->prev < -1) {
                    $this->prev = null;
                    $this->currentMember = $matches[0]->getMemberRelatedByMember2Id(); //middle
                }
                break;
                
            case 2: //partial set of 2 results - last page/record
                $this->currentMember = $matches[1]->getMemberRelatedByMember2Id();
                $this->prev = $this->offset - 1;
                $this->next = null;
                break;
                
            case 1: //there should not be only 1 result, something is broken
            case 0: //no results - something broken
            default:
                $this->currentMember = null;
                $this->prev = null;
                $this->next = null;
                break;
        }
        
    }
    
    public function getOffset()
    {
        return $this->offset;
    }
    
    public function getCurrentMember()
    {
        return $this->currentMember;
    }
    
    public function getIndex()
    {
        return $this->offset;
    }
    
    public function getNext()
    {
        return $this->next;
    }

    public function getPrevious()
    {
        return $this->prev;
    }
    
    public function hasResults()
    {
        return (null !== $this->currentMember);
    }
}
