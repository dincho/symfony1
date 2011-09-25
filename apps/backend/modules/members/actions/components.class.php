<?php
class MembersComponents extends sfComponents
{
    public function executeProfilePager()
    {
        $pager_crit = $this->getUser()->getAttribute('criteria', new Criteria(), 'backend/members/profile_pager');
        $this->pager = new ProfilePager($pager_crit, $this->member->getId());
        $this->pager->init();
    }
}