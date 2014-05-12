<?php

class prFilteredQueryBuilder extends prSearchQueryBuilder
{
    public function getQuery($from = 0, $size = 10)
    {
        $query = array(
            'from' => $from,
            'size' => $size,
            'fields' => array(),
            'query' => array(
                'filtered' => array(
                    'query' => array(
                        'match_all' => array(),
                    ),
                    'filter' => array(
                        'and' => $this->getFilter(),
                    ),
                ),
            ),
        );

        if ($sort = $this->getSort()) {
            $query['sort'] = $sort;
        }

        return $query;
    }
}
