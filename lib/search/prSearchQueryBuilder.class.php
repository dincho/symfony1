<?php

abstract class prSearchQueryBuilder
{
    protected $member;
    protected $filter;

    public function __construct(Member $member)
    {
        $this->member = $member;
        $this->filter = array();
        $this->addCommonFilters();
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

    public function getMatchesQuery($from = 0, $size = 10)
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
            'sort' => array(
                '_score' => array(
                    'order' => 'desc',
                ),
            ),
        );
    }

    public function getMember()
    {
        return $this->member;
    }

    public function addFilterByPhoto($hasPhotos)
    {
        $hasPhotos = (bool) $hasPhotos;
        $this->filter[] = array(
                            'term' => array(
                                'main_photo' => $hasPhotos,
                            )
        );
    }

    public function addFilterByAdministrativeArea(array $countries, array $areas)
    {
        if (!empty($areas)) {
            $areas = array_map('intval', $areas);
            $this->filter[] = array(
                                'terms' => array(
                                    'adm1_id' => $areas,
                                )
            );
        } else if (!empty($countries)) {
            $this->filter[] = array(
                                'terms' => array(
                                    'country' => $countries,
                                )
            );
        }
    }

    public function addFilterByDistance($distance, $dimension, $lat, $lon)
    {
        $this->filter[] = array(
                            'geo_distance' => array(
                                'distance' => $distance . $dimension,
                                'location' => array(
                                    'lat' => $lat,
                                    'lon' => $lon,
                                ),
                            )
        );
    }

    protected function addCommonFilters()
    {
        $this->filter[] = array(
                            'term' => array(
                                'status_id' => MemberStatusPeer::ACTIVE,
                            ),
        );

        $this->filter[] = array(
                            'terms' => array(
                                'catalog_id' => $this->member->getCatalogue()->getVisibleCatalogs(),
                            ),
        );

        $this->filter[] = array(
                            'term' => array(
                                'orientation' => $this->member->getOpositeOrientation(),
                            ),
        );

        $this->filter[] = array(
                            'or' => array(
                                array(
                                    'term' => array(
                                        'private_dating' => false,
                                    ),
                                ),
                                array(
                                    'term' => array(
                                        'open_privacy' => $this->member->getId(),
                                    ),
                                ),
                            )
        );
    }

    protected function getFilter()
    {
        return $this->filter;
    }
}
