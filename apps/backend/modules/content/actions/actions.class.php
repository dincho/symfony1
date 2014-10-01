<?php

/**
 * content actions.
 *
 * @package    PolishRomance
 * @subpackage content
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class contentActions extends sfActions
{
    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1) {
          $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved', false);
        }

        $this->catalog = CataloguePeer::retrieveByPK($this->getRequestParameter('cat_id'));
        // $this->forward404Unless($this->catalog);
    }

    public function executeList()
    {
        $this->forward('content', 'homepages');
    }

    public function executeHomepages()
    {
        $this->left_menu_selected = 'Home Pages';

        $c = new Criteria();
        $c->add(TransUnitPeer::MSG_COLLECTION_ID, 1); //headline
        $this->trans = TransUnitPeer::doSelectJoinAll($c);
    }

    public function executeHomepage()
    {
        $this->left_menu_selected = 'Home Pages';

        $c = new Criteria();
        $c->add(HomepageMemberStoryPeer::CAT_ID, $this->catalog->getCatId());
        $homepage_story = HomepageMemberStoryPeer::doSelectOne($c);

        if (!$homepage_story) {
            $homepage_story = new HomepageMemberStory();
            $homepage_story->setCatId($this->catalog->getCatId());
        }

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            //update member stories
            $homepage_story->setMemberStories(implode(',', $this->getRequestParameter('member_stories', array())));
            $homepage_story->save();

            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->catalog);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/homepages?cat_id=' . $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::HOMEPAGE, $this->catalog);
        $c = new Criteria();
        $c->add(MemberStoryPeer::CAT_ID, $this->catalog->getCatId());
        $this->member_stories = MemberStoryPeer::doSelect($c);
        $this->homepage_stories = explode(',', $homepage_story->getMemberStories());

    }

    public function executeProfilepages()
    {
        $this->left_menu_selected = 'Profile Pages';
        $this->catalogues = CataloguePeer::doSelect(new Criteria());
    }

    public function executeProfilepage()
    {

        $this->left_menu_selected = 'Profile Pages';

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {

            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()),
                array('profile_max_photos', 'profile_num_recent_activities', 'profile_display_video'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/profilepages?cat_id=' . $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::PROFILE, $this->catalog);
    }

    public function executeSearchpages()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
    }

    public function executeSearchMostRecent()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit Most Recent', 'uri' => 'content/searchMostRecent?cat_id=1'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()), array('search_rows_most_recent'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_MOST_RECENT, $this->catalog);
    }

    public function executeSearchCustom()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit Custom (by Criteria)', 'uri' => 'content/searchCustom?cat_id=1'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()), array('search_rows_custom'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_CUSTOM, $this->catalog);
    }

    public function executeSearchReverse()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit Reverse'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()), array('search_rows_reverse'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_REVERSE, $this->catalog);
    }

    public function executeSearchMatches()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit Matches'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()), array('search_rows_matches'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_MATCHES, $this->catalog);
    }

    public function executeSearchKeyword()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit by Keyword'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()), array('search_rows_keyword'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_KEYWORD, $this->catalog);
    }

    public function executeSearchProfileId()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit Profile ID'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_PROFILE_ID, $this->catalog);
    }

    public function executeSearchPublic()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages?cat_id=1'));
        $bc->add(array('name' => 'Edit Public'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()), array('search_rows_public'));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_PUBLIC, $this->catalog);
    }

    public function executeRegpages()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
    }

    public function executeRegJoinNow()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Join Now'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages');
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_JOIN, $this->catalog);
    }

    public function executeRegReg()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Registration'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages');
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_REG, $this->catalog);
    }

    public function executeRegSelf()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Self-Description'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages');
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_SELF, $this->catalog);
    }

    public function executeRegEssay()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Essay'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages');
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_ESSAY, $this->catalog);
    }

    public function executeRegPhotos()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Photos'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages');
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_PHOTOS, $this->catalog);
    }

    public function executeRegSearch()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Search'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));

            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages');
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_SEARCH, $this->catalog);
    }

    public function executeSystemMessages()
    {
        $this->left_menu_selected = 'System Messages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'System Messages', 'uri' => 'content/systemMessages'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->catalog);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/systemMessages?cat_id=' . $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SYSTEM_MESSAGES, $this->catalog);
    }

    public function executeSystemMessage()
    {
        $this->left_menu_selected = 'System Messages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'System Messages', 'uri' => 'content/systemMessages?cat_id=' . $this->catalog->getCatId()));

        $headline = TransUnitPeer::getByCultureAndCollection($this->getRequestParameter('headline_id'), $this->catalog->getCatId());
        $content = TransUnitPeer::getByCultureAndCollection($this->getRequestParameter('content_id'), $this->catalog->getCatId());
        $this->forward404Unless($headline && $content);

        $bc->add(array('name' => $headline->getSource()));

        $this->uri = 'content/systemMessage?cat_id=' . $this->catalog->getCatId()
                            . '&headline_id=' . $headline->getMsgCollectionId()
                            . '&content_id=' . $content->getMsgCollectionId();

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));

            $headline->setTarget($this->getRequestParameter('headline'));
            $headline->save();

            $content->setTarget($this->getRequestParameter('content'));
            $content->save();

            $catIds = $this->getRequestParameter('affected_catalogs', array());

            if (!empty($catIds)) {
                foreach ($catIds as $catId) {
                    $headline = TransUnitPeer::getByCultureAndCollection($this->getRequestParameter('headline_id'), $catId);
                    $content = TransUnitPeer::getByCultureAndCollection($this->getRequestParameter('content_id'), $catId);

                    $headline->setTarget($this->getRequestParameter('headline'));
                    $headline->save();

                    $content->setTarget($this->getRequestParameter('content'));
                    $content->save();
                }
            }

            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect($this->uri);
        }

        $this->headline = $headline;
        $this->content = $content;
    }

    public function executeAssistant()
    {
        $this->left_menu_selected = 'Assistant';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Assistant', 'uri' => 'content/assistant'));
        $bc->add(array('name' => 'Edit Assistant'));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->updateTUs($this->getRequestParameter('affected_catalogs', array()));

            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/assistant?cat_id=' .  $this->catalog->getCatId());
        }

        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::ASSISTANT, $this->catalog);
        $this->photo = StockPhotoPeer::getAssistantPhotoByCatalog($this->catalog);
    }

    // Makes the update for all of the selected catalogues
    private function updateTUs($catIds, array $settings = null)
    {
        $catalogs = CataloguePeer::getCatalogsByIds($catIds);
        $catalogs[] = $this->catalog;

        foreach ($catalogs as $catalog) {
            if ($settings) {
                sfSettingPeer::updateFromRequest($settings, $catalog);
            }
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $catalog);
        }
    }
}
