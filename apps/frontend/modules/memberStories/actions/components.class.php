<?php
class memberStoriesComponents extends sfComponents
{

    public function executeShortList()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->setLimit(7);
        $this->stories_list = MemberStoryPeer::doSelectWithI18n($c);
    }
}
