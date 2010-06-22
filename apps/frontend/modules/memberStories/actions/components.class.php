<?php
class memberStoriesComponents extends sfComponents
{

    public function executeShortList()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::CAT_ID, $this->getUser()->getCatalogId());
        $c->setLimit(7);
        $this->stories_list = MemberStoryPeer::doSelect($c);
    }

    public function executeHomepageList()
    {
        $c = new Criteria();
        $c->add(HomepageMemberStoryPeer::CAT_ID, $this->getUser()->getCatalogId());
        $home_member_story = HomepageMemberStoryPeer::doSelectOne($c);
        
        $home_story_list = ($home_member_story) ? explode(',', $home_member_story->getMemberStories()) : array();
        
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::ID, $home_story_list, Criteria::IN);
        $this->stories_list = MemberStoryPeer::doSelect($c);
    }
}
