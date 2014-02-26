<?php

class prKeywordQueryBuilder extends prSearchQueryBuilder
{
    protected $queryString;

    public function __construct(Member $member, $queryString)
    {
        parent::__construct($member);
        $this->setSort('score');
        $this->queryString = $queryString;
    }

    public function getQuery($from = 0, $size = 10)
    {
        return array(
            'from' => $from,
            'size' => $size,
            'fields' => array(),
            'query' => array(
                'filtered' => array(
                    'query' => array(
                        'query_string' => array(
                            'query' => $this->queryString,
                            'fields' => array(
                                'username',
                                'essay_headline',
                                'essay_body',
                            )
                        ),
                    ),
                    'filter' => array(
                        'and' => $this->getFilter(),
                    ),
                ),
            )
        );
    }
}