<?php

abstract class prScoreQueryBuilder extends prSearchQueryBuilder
{
    public function __construct(Member $member)
    {
        parent::__construct($member);
        $this->setSort('score');
    }

    abstract protected function getFunctions();

    public function getQueryForMembers(array $members)
    {
        //pluck ids
        $memberIds = array();
        foreach ($members as $member) {
            $memberIds[] = $member->getId();
        }

        return array(
            'size' => count($memberIds),
            'fields' => array(
                'orientation',
                'status_id',
                'catalog_id',
            ),
            'query' => array(
                'function_score' => array(
                    'filter' => array(
                        'ids' => array(
                            'values' => $memberIds,
                        )
                    ),
                    'functions' => $this->getFunctions(),
                    'score_mode' => 'sum',
                    'boost_mode' => 'replace',
                ),
            ),
        );
    }

    public function getQuery($from = 0, $size = 10)
    {
        return array(
            'from' => $from,
            'size' => $size,
            'fields' => array(
                'orientation',
                'status_id',
                'catalog_id',
            ),
            'query' => array(
                'function_score' => array(
                    'filter' => array(
                        'and' => $this->getFilter(),
                    ),
                    'functions' => $this->getFunctions(),
                    'score_mode' => 'sum',
                    'boost_mode' => 'replace',
                ),
            ),
            'sort' => $this->getSort(),
        );
    }
}