<?php

class geo2seoComponents extends sfComponents
{
    public function executeProfiles()
    {
        $c = new Criteria();
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $c->add(MemberPeer::PUBLIC_SEARCH, true);
        $c->add(MemberPeer::SEX, 'F');
        $c->add(MemberPeer::LOOKING_FOR, 'M');
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        
        $rows = sfConfig::get('app_settings_geo2seo_public_profiles_rows', 4);
        $limit = $rows * 3; //3 boxes/profiles per row
        $c->setLimit($limit);
        
        $this->members = MemberPeer::doSelectJoinAll($c);
    }
}