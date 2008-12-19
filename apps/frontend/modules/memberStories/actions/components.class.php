<?php
class memberStoriesComponents extends sfComponents
{

    public function executeShortList()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::CULTURE, $this->getUser()->getCulture());
        $c->setLimit(7);
        $this->stories_list = MemberStoryPeer::doSelect($c);
    }
}
