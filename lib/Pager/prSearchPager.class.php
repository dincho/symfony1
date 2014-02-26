<?php

class prSearchPager extends sfPager
{
    public $members = array();
    protected $offset = 0;
    protected $limit = 0;

    public function __construct(prSearchQueryBuilder $builder, $maxPerPage = 10)
    {
        $this->builder = $builder;
        parent::__construct(null, $maxPerPage);
    }
  
    public function getResults()
    {
        $query = $this->builder->getQuery($this->offset, $this->limit);
        list($members, $total) = MemberMatchPeer::getMatches($this->builder->getMember(), $query);

        $this->members = $members;

        $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
        $maxRecordLimit = $this->getMaxRecordLimit();

        $this->setNbResults($hasMaxRecordLimit ? min($total, $maxRecordLimit) : $total);
        $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }

    public function init()
    {
        $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
        $maxRecordLimit = $this->getMaxRecordLimit();

        if (($this->getPage() == 0 || $this->getMaxPerPage() == 0)) {
            $this->setLastPage(0);
        } else {
            $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
            $this->offset = $offset;

            if ($hasMaxRecordLimit) {
                $maxRecordLimit = $maxRecordLimit - $offset;
                if ($maxRecordLimit > $this->getMaxPerPage()) {
                    $this->limit = $this->getMaxPerPage();
                } else {
                    $this->limit = $maxRecordLimit;
                }
            } else {
                $this->limit = $this->getMaxPerPage();
            }
        }
    }

    protected function retrieveObject($offset)
    {
        return $this->members[$offset];
    }
}