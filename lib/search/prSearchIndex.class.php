<?php

use Elasticsearch\Client;

class prSearchIndex
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function updateIndex(Member $member)
    {
        $ret = $this->getClient()->index(array(
            'index' => 'polishdate',
            'type' => 'member',
            'id' => $member->getId(),
            'body' => $this->getMemberRepresentation($member),
        ));
    }

    public function search($query)
    {
        $results = $this->getClient()->search(array(
            'index' => 'polishdate',
            'type'  => 'member',
            'body'  => $query
        ));

        if (isset($results['error'])) {
            throw new Exception($results['error'], $results['status']);
        }

        $matches = array();
        foreach ($results['hits']['hits'] as $doc) {
            $matches[$doc['_id']] = $doc;
        }

        return array($matches, $results['hits']['total']);
    }

    protected function getMemberRepresentation(Member $memberObj)
    {
        $selfDescription = array();
        $memberAnswers = MemberDescAnswerPeer::getAnswersAssoc($memberObj->getId());
        foreach($memberAnswers as $questionId => $memberAnswer) {
            $idx = 'q' . $questionId;
            if ($questionId == 1) { //age
                $selfDescription[$idx] = $memberAnswer->getCustom();
                continue;
            }

            if ($questionId == 16) { //native lang
                $selfDescription[$idx] = $memberAnswer->getCustom();
                continue;
            }

            if ($questionId == 17) { //other langs
                $otherLangs = $memberAnswer->getOtherLangs();
                $selfDescription[$idx] = !empty($otherLangs);
                continue;
            }

            $selfDescription[$idx] = $memberAnswer->getDescAnswerId();
        }

        $searchCriteria = array();
        $searchCriteriaDescriptions = $memberObj->getSearchCritDescsArray();
        foreach($searchCriteriaDescriptions as $questionId => $description) {
            $idx = 'q' . $questionId;

            if (in_array($questionId, array(1, 12, 13))) { //age & other ranges
                $answers = $description->getDescAnswersArray();
                $searchCriteria[$idx] = array(
                    'answer1' => $answers[0],
                    'answer2' => $answers[1],
                    'weight' => $description->getMatchWeight() - 1
                );

                continue;
            }

            if ($questionId == 16) { //native lang
                $searchCriteria[$idx] = array(
                    'answers' => array($memberObj->getLanguage()),
                    'weight' => $description->getMatchWeight() - 1
                );

                continue;
            }

            if ($questionId == 17) { //other lang
                $searchCriteria[$idx] = array(
                    //always true, just the weight matter
                    'answers' => array(true),
                    'weight' => $description->getMatchWeight() - 1
                );

                continue;
            }

            $searchCriteria[$idx] = array(
                'answers' => $description->getDescAnswersArray(),
                'weight' => $description->getMatchWeight() - 1
            );
        }

        $openPrivacy = OpenPrivacyPeer::getVisibleByProfilesIds($memberObj->getId());
        $memberCity = $memberObj->getCity();
        $location = array(
            'lat' => $memberCity->getLatitude(),
            'lon' => $memberCity->getLongitude()
        );

        return array(
            'status_id' => $memberObj->getMemberStatusId(),
            'catalog_id' => $memberObj->getCatalogId(),
            'orientation' => $memberObj->getOrientationKey(),
            'main_photo' => (bool) $memberObj->getMainPhotoId(),
            'country' => $memberObj->getCountry(),
            'adm1_id' => $memberObj->getAdm1Id(),
            'location' => $location,
            'self_description' => $selfDescription,
            'search_criteria' => $searchCriteria,
            'open_privacy' => $openPrivacy,
            'private_dating' => $memberObj->getPrivateDating(),
        );
    }
}
