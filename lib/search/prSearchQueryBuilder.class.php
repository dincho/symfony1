<?php

abstract class prSearchQueryBuilder
{
    protected $member;
    protected $filter;
    protected $sort;

    public function __construct(Member $member)
    {
        $this->member = $member;
        $this->filter = array();
        $this->addCommonFilters();
    }

    abstract public function getQuery($from = 0, $size = 10);

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
        } elseif (!empty($countries)) {
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

    public function addFilterById($id)
    {
        $this->filter[] = array(
            'ids' => array(
                'values' => array($id),
            )
        );
    }

    public function setSort($sort)
    {
        switch ($sort) {
            case 'last_login':
                $this->sort = array(
                    'last_login' => array(
                        'order' => 'desc',
                    ),
                );
            break;

            case 'most_recent':
                $this->sort = array(
                    '_script' => array(
                        //VIP (id 2) should be sorted before premium (id 3), so replace VIP with 4
                        'script' => "(doc['subscription_id'].value == 2 ? 4 : doc['subscription_id'].value)",
                        'type' => 'number',
                        'order' => 'desc',
                    ),
                    'created' => array(
                        'order' => 'desc',
                    ),
                );
            break;

            case 'score':
            default:
                $this->sort = array(
                    '_score' => array(
                        'order' => 'desc',
                    ),
                );
            break;
        }
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

        $this->addPurposeFilter();
    }

    protected function addPurposeFilter()
    {
        $purpose = $this->member->getPurpose();

        //both selected - see all profiles
        if (in_array('CR', $purpose) && in_array('M', $purpose)) {
            return;
        }

        //only Marriage selected - see only Marriage
        if (in_array('M', $purpose)) {
            $this->filter[] = array(
                                'terms' => array(
                                    'purpose' => array('M'),
                                ),
            );

            return;
        }

        //CR or none selected (rest cases) - see only CR
        $this->filter[] = array(
                            'terms' => array(
                                'purpose' => array('CR'),
                            ),
        );
    }

    protected function getFilter()
    {
        return $this->filter;
    }

    protected function getSort()
    {
        return $this->sort;
    }
}
