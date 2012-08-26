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
    private $members = array();
    private $cursor = 0;
    private $index = 0;
    
    public static function init($userId, $ppo, $current_member)
    {
        $cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'last_search_criteria';
        $search_crit_cache = new sfFileCache($cache_dir);
        $crit_data = $search_crit_cache->get($userId, null);
        
        if ($crit_data) {
            $criteria = unserialize($crit_data);
            $criteria->setOffset($ppo);
            $criteria->setLimit(3);
            $matches = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($criteria);
        } else {
            $matches = array();
        }
        
        return new self($matches, $ppo, $current_member);
    }
    
    public static function storeCriteria($userId, Criteria $c)
    {
        $cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'last_search_criteria';
        $search_crit_cache = new sfFileCache($cache_dir);
        $search_crit_cache->set($userId, null, serialize($c));
    }
    
    public function __construct(array $matches, $ppo, $current_member)
    {
        $this->setMatches($matches);
        $this->index  = $ppo;
        $this->setCursor($current_member);
    }
    
    protected function setMatches($matches)
    {
        foreach($matches as $match)
        {
            $member = $match->getMemberRelatedByMember2Id();
            $this->members[] = $member->getUsername();
        }
    }

    protected function setCursor($current_member)
    {
        //cast to int to set cursor = 0 if not member found
        $this->cursor = (int) array_search($current_member, $this->members);
    }
    
    public function getIndex()
    {
        return $this->index;
    }
    
    public function getNext()
    {
        return (isset($this->members[$this->cursor+1])) ? $this->members[$this->cursor+1] : null;
    }

    public function getPrevious()
    {
        return (isset($this->members[$this->cursor-1])) ? $this->members[$this->cursor-1] : null;
    }
    
    public function hasResults()
    {
        return (count($this->members) > 0) ? true : false;
    }
}
