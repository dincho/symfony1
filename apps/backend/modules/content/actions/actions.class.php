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
        $this->culture = $this->getRequestParameter('culture', 'en');
    }
    
    public function executeList()
    {
        $this->forward('content', 'homepages');
    }
    
    public function executeHomepages()
    {
        $c = new Criteria();
        $c->add(TransUnitPeer::MSG_COLLECTION_ID, 1); //headline
        $this->trans = TransUnitPeer::doSelectJoinAll($c);
    }
        
    public function executeHomepage()
    {
        $this->left_menu_selected = 'Home Pages';
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/homepages?culture=' . $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::HOMEPAGE, $this->culture);
    }

    public function executeProfilepages()
    {
        
    }
        
    public function executeProfilepage()
    {
        $this->left_menu_selected = 'Profile Pages';
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('profile_max_photos', 'profile_num_recent_messages', 'profile_display_video'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/profilepages?culture=' . $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::PROFILE, $this->culture);
    }

    public function executeSearchpages()
    {
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));        
    }
        
    public function executeSearchMostRecent()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit Most Recent', 'uri' => 'content/searchMostRecent'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('search_rows_most_recent'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_MOST_RECENT, $this->culture);
    }
        
    public function executeSearchCustom()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit Custom (by Criteria)', 'uri' => 'content/searchCustom'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('search_rows_custom'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_CUSTOM, $this->culture);
    }
        
    public function executeSearchReverse()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit Reverse'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('search_rows_reverse'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_REVERSE, $this->culture);
    }
        
    public function executeSearchMatches()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit Matches'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('search_rows_matches'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_MATCHES, $this->culture);
    }
        
    public function executeSearchKeyword()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit by Keyword'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('search_rows_keyword'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_KEYWORD, $this->culture);
    }
        
    public function executeSearchProfileId()
    {
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit Profile ID'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_PROFILE_ID, $this->culture);
    }
        
    public function executeSearchPublic()
    {
        $this->setFlash('msg_error', 'Not implemented yet.');
        $this->redirect('content/searchpages');
        
        $this->left_menu_selected = 'Search Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Search Pages', 'uri' => 'content/searchpages'));
        $bc->add(array('name' => 'Edit Public'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            sfSettingPeer::updateFromRequest(array('search_rows_public'));
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/searchpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::SEARCH_PUBLIC, $this->culture);
    }
    
    public function executeRegpages()
    {
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));        
    }    
        
    public function executeRegJoinNow()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Join Now'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_JOIN, $this->culture);
    }
        
    public function executeRegReg()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Registration'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_REG, $this->culture);
    }
        
    public function executeRegSelf()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Self-Description'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_SELF, $this->culture);
    }
    
    public function executeRegEssay()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Essay'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_ESSAY, $this->culture);
    }
    
    public function executeRegPhotos()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Photos'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_PHOTOS, $this->culture);
    }
    
    public function executeRegSearch()
    {
        $this->left_menu_selected = 'Reg/Sign Up Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages'));
        $bc->add(array('name' => 'Edit Search'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/regpages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::REGISTRATION_SEARCH, $this->culture);
    }
    
    public function executeImbrapages()
    {
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'IMBRA Pages', 'uri' => 'content/imbrapages'));        
    }

    public function executeImbraApp()
    {
        $this->left_menu_selected = 'IMBRA Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'IMBRA Pages', 'uri' => 'content/imbrapages'));
        $bc->add(array('name' => 'Edit IMBRA Application Template'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            TransUnitPeer::bulkUpdate($this->getRequestParameter('trans', array()), $this->culture);
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/imbrapages?culture=' .  $this->culture);
        }
        
        $this->trans = TransCollectionPeer::getCollection(TransCollectionPeer::IMBRA_APP, $this->culture);
    }    

    public function executeImbraReport()
    {
        $this->left_menu_selected = 'IMBRA Pages';
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => 'IMBRA Pages', 'uri' => 'content/imbrapages'));
        $bc->add(array('name' => 'Edit IMBRA Report Template'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('content/imbrapages?culture=' .  $this->culture);
        }
        
        $this->imbra_questions = ImbraQuestionPeer::doSelectWithI18n(new Criteria(), $this->culture);
    }    
}
