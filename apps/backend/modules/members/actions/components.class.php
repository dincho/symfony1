<?php
class MembersComponents extends sfComponents
{
    public function executeProfilePager()
    {
        $pager_crit = $this->getUser()->getAttribute('criteria', new Criteria(), 'backend/members/profile_pager');
        $this->pager = new ProfilePager($pager_crit, $this->member->getId());
        $this->pager->init();
    }

    public function executeMemberIpBlock()
    {
        $this->isIpDublicatedIp = MemberPeer::isIpDublicated($this->ip);
        $this->isIpBlacklistedIp = MemberPeer::isIpBlacklisted($this->ip);
        $this->ipLocation = Maxmind::getMaxmindLocation($this->ip);
    }

}