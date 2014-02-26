<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 7, 2009 11:47:49 AM
 * 
 */

class FrontendProfilePager extends sfPager
{
    private $offset = 0;
    private $members = array();
    private $userId = null;
    private $firstResult = false;

    public function __construct($userId)
    {
        $this->userId = $userId;
        parent::__construct('Member', $maxPerPage = 1);
    }
    
    public static function storeCriteria($userId, $c)
    {
        $cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'last_search_criteria';
        $search_crit_cache = new sfFileCache($cache_dir);
        $search_crit_cache->set($userId, null, serialize($c));
    }

    // function to be called after parameters have been set
    public function init()
    {
        $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
        $maxRecordLimit = $this->getMaxRecordLimit();

        if (($this->getPage() == 0 || $this->getMaxPerPage() == 0)) {
            $this->setLastPage(0);
        } else {
            $offset = ($this->getPage() - 1) * $this->getMaxPerPage() - 1;
            $this->firstResult = (-1 == $offset);
            $this->offset = max(0, $offset);
        }

        $this->initResults();

        $maxRecordLimit = $this->getMaxRecordLimit();
        $this->setNbResults(count($this->getResults()));

        //if there are more than one result speculate with last page
        if (count($this->getResults()) > 1) {
            $this->setLastPage($this->getPage() + 1);
        }

        if (!$this->firstResult && count($this->getResults()) != 3) {
            $this->setLastPage($this->getPage()); //hide the links
        }

        if ($maxRecordLimit) {
            $resultsTillNow = ($this->getPage() - 1) * $this->getMaxPerPage() + 1;
            if ($resultsTillNow >= $maxRecordLimit) {
                $this->setLastPage($this->getPage()); //hide the links
            }
        }
    }

    protected function initResults()
    {
        $cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'last_search_criteria';
        $cache = new sfFileCache($cache_dir);
        $cacheData = $cache->get($this->userId, null);

        if ($cacheData) {
            $obj = unserialize($cacheData);

            if ($obj instanceof Criteria) {
                $obj->setOffset($this->offset);
                $obj->setLimit(3);
                
                MemberRatePeer::getMapBuilder(); //force manual map loading because of serialized criteria
                $this->members = MemberPeer::doSelect($obj);
            } elseif ($obj instanceof prSearchQueryBuilder) {
                $query = $obj->getQuery($this->offset, 3);
                list($this->members, $total) = MemberMatchPeer::getMatches($obj->getMember(), $query);
            }
        }
    }

    // main method: returns an array of result on the given page
    public function getResults()
    {
        return $this->members;
    }

    // used internally by getCurrent()
    protected function retrieveObject($offset)
    {
        $results = $this->getResults();
        return (isset($results[$offset])) ? $results[$offset] : null;
    }

    public function getCurrent()
    {
        return $this->retrieveObject(1);
    }

    public function getNext()
    {
        if ($this->firstResult) {
            return $this->retrieveObject(1);
        }

        switch (count($this->getResults())) {
            case 3:
                return $this->retrieveObject(2);
                break;

            case 2:
                return $this->retrieveObject(1);
                break;

            default:
                return null;
                break;
        }
    }

    public function getPrevious()
    {
        if ($this->firstResult) {
            return null;
        }

        return $this->retrieveObject(0);
    }
}
