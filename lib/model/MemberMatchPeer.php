<?php

/**
 *
 * 
 *
 * @package lib.model
 */ 
class MemberMatchPeer
{
    const SORT_SCORE = 1;
    const SORT_REVERSE_SCORE = 2;
    const SORT_COMBINED = 3;

    public static function updateMemberIndex(Member $memberObj, Elasticsearch\Client $client = null)
    {
        if (!$client) {
            $client = new Elasticsearch\Client();
        }
        
        $index = new prSearchIndex($client);
        $index->updateIndex($memberObj);
    }

    public static function getMatches(Member $member, $query)
    {
        $index = new prSearchIndex(new Elasticsearch\Client());
        list($matchDocuments, $total) = $index->search($query);

        if (0 == count($matchDocuments)) {
            return array(array(), 0);
        }
        
        //pluck by ID property of all members
        $memberIds = array();
        foreach ($matchDocuments as $doc) {
            $memberIds[] = $doc['_id'];
        }

        //get the member objects order by original match order
        $fields = $memberIds;
        array_unshift($fields, MemberPeer::ID);

        $c = new Criteria();
        $c->add(MemberPeer::ID, $memberIds, Criteria::IN);
        $c->addAscendingOrderByColumn('FIELD(' . implode(',', $fields) . ')');
        $members = MemberPeer::doSelect($c);

        return array(
            self::populateMemberMatches($member, $members),
            $total
        );
    }

    public static function populateMemberMatches(Member $memberObj, array $members)
    {
        $index = new prSearchIndex(new Elasticsearch\Client());

        $builder = new prReverseQueryBuilder($memberObj);
        $query = $builder->getQueryForMembers($members);
        list($reverseMatches, ) = $index->search($query);

        $builder = new prStraightQueryBuilder($memberObj);
        $query = $builder->getQueryForMembers($members);
        list($straightMatches, ) = $index->search($query);

        foreach ($members as $member) {
            $match = new MemberMatch();
            if (isset($straightMatches[$member->getId()])) {
                $match->setScore($straightMatches[$member->getId()]['_score']);
            }

            if (isset($reverseMatches[$member->getId()])) {
                $match->setReverseScore($reverseMatches[$member->getId()]['_score']);
            }

            $member->setMemberMatch($match);
        }

        return $members;
    }

    public static function getMatch(Member $memberObj, Member $matchingMember)
    {
        $members = self::populateMemberMatches($memberObj, array($matchingMember));
        return $members[0]->getMemberMatch();
    }

    public static function addGlobalCriteria(Criteria $c, Member $member)
    {
        //don not show unavailable profiles
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        //only oposite orientation
        $c->add(MemberPeer::SEX, $member->getLookingFor());
        $c->add(MemberPeer::LOOKING_FOR, $member->getSex());
        
        //filter only visible catalogs
        $catalog = $member->getCatalogue();
        $c->add(MemberPeer::CATALOG_ID, $catalog->getVisibleCatalogs(), Criteria::IN);

        // does not seems to work
        $privacyJoin = sprintf('%s AND %s = %d', 
            OpenPrivacyPeer::PROFILE_ID,
            OpenPrivacyPeer::MEMBER_ID,
            $member->getId()
        );

        $privacyCheck = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", 
            MemberPeer::PRIVATE_DATING,
            OpenPrivacyPeer::ID
        );

        $c->addJoin(MemberPeer::ID, $privacyJoin, Criteria::LEFT_JOIN);
        $c->add(OpenPrivacyPeer::ID, $privacyCheck, Criteria::CUSTOM);
    }
}
