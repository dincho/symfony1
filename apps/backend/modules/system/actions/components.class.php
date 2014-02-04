<?php
class systemComponents extends sfComponents 
{
  public function executeTopMenu()
  {
    $this->menu = array(array('title' => 'Dashboard', 'uri' => 'dashboard/index'),
                         array('title' => 'Members', 'uri' => 'members/list'),
                         array('title' => 'IP Watch', 'uri' => 'ipwatch/index'),
                         array('title' => 'Photos', 'uri' => 'photos/list?filter=filter&sort=Member::last_photo_upload_at&type=desc'),
                         array('title' => 'Content', 'uri' => 'content/homepages?cat_id=1'),
                         array('title' => 'GEO', 'uri' => 'geo/list'),
                         array('title' => 'Subscriptions', 'uri' => 'subscriptions/list'),
                         array('title' => 'Messages', 'uri' => 'messages/list'),
                         array('title' => 'Feedback', 'uri' => 'feedback/list'),
                         array('title' => 'Flags', 'uri' => 'flags/suspended'),
                         array('title' => 'Reports', 'uri' => 'reports/list'),
                         array('title' => 'Users', 'uri' => 'users/list'),
                      );

    if( !isset($this->top_menu_selected )) $this->top_menu_selected = $this->getContext()->getModuleName();
  }
  
  public function executeLeftMenu()
  {
    if (isset($this->top_menu_selected)) {
      $module = $this->top_menu_selected;
    } else {
      $module = $this->getContext()->getModuleName();;
    }

    if (!isset($this->left_menu_selected)) {
      $this->left_menu_selected = null;
    }
    
    $submenuMethod = 'get' . ucfirst($module) . 'Submenu';
    if (method_exists($this, $submenuMethod)) {
      $this->menu = call_user_func(array($this, $submenuMethod));
    } else {
      $this->menu = array();
    }
  }

  protected function getContentSubmenu()
  {
    return array(
      array('title' => 'Catalogs', 'uri' => 'catalogue/list'),
      array('title' => 'Translation Units', 'uri' => 'transUnits/list'),
      array('title' => 'Home Pages', 'uri' => 'content/homepages?cat_id=1'),
      array('title' => 'Profile Pages', 'uri' => 'content/profilepages?cat_id=1'),
      array('title' => 'Search Pages', 'uri' => 'content/searchpages'),
      array('title' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages?cat_id=1'),
      array('title' => 'System Messages', 'uri' => 'content/systemMessages?cat_id=1'),
      array('title' => 'Member Stories', 'uri' => 'memberStories/list?cat_id=1'),
      array('title' => 'Static Pages', 'uri' => 'staticPages/list'),
      array('title' => 'Assistant', 'uri' => 'content/assistant?cat_id=1'),
      array('title' => 'Upload Photos', 'uri' => 'photos/upload'),
      array('title' => 'System Notifications', 'uri' => 'notifications/list?cat_id=1'),
      array('title' => 'Desc. Questions', 'uri' => 'descQuestions/list'),
      array('title' => 'Settings', 'uri' => 'settings/list'),
      array('title' => 'Clear Global Cache', 'uri' => 'system/clearGlobalCache'),
    );
  }

  protected function getGeoSubmenu()
  {
    return array(
      array('title' => 'Recent sign up cities w/out coord.', 'uri' => 'geo/citiesWithoutCoordinates'),
      array('title' => 'Empty Countries', 'uri' => 'geo/emptyCountries'),
      array('title' => 'Empty Admin1\'s', 'uri' => 'geo/emptyAdm1'),
      array('title' => 'Empty Admin2\'s', 'uri' => 'geo/emptyAdm2'),
    );
  }

  protected function getUsersSubmenu()
  {
    return array(
      array('title' => 'Users', 'uri' => 'users/list'),
    );
  }

  protected function getReportsSubmenu()
  {
    return array(
      array('title' => 'Daily Sales', 'uri' => 'reports/dailySales'),
      array('title' => 'Member Activity', 'uri' => 'reports/memberActivity'),
      array('title' => 'Active Members', 'uri' => 'reports/activeMembers'),
      array('title' => 'Flags/ Suspensions', 'uri' => 'reports/flagsSuspensions'),
      array('title' => 'Registration', 'uri' => 'reports/registration'),
      array('title' => 'Outgoing Emails', 'uri' => 'reports/outgoingEmails'),
    );
  }

  protected function getFeedbackSubmenu()
  {
    $c = new Criteria();
    //$c->add(FeedbackPeer::IS_READ, false);
    $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX);
    $feedback_cnt_all = FeedbackPeer::doCount($c);
    
    $c1 = clone $c;
    $c1->add(FeedbackPeer::MEMBER_ID, null, Criteria::ISNOTNULL);
    $c1->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID);
    $c1->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::FREE, Criteria::NOT_EQUAL);
    $feedback_cnt_paid = FeedbackPeer::doCount($c1);

    $c2 = clone $c;
    $c2->add(FeedbackPeer::MEMBER_ID, null, Criteria::ISNULL);
    $feedback_cnt_external = FeedbackPeer::doCount($c2);

    $c3 = clone $c;
    $c3->add(FeedbackPeer::MAIL_TO, FeedbackPeer::BUGS_SUGGESIONS_ADDRESS);
    $feedback_cnt_bugs = FeedbackPeer::doCount($c3);

    return array(
      array('title' => 'All Messages (' . $feedback_cnt_all . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1'),
      array('title' => 'From Paid Members (' . $feedback_cnt_paid . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[paid]=1'),
      array('title' => 'Reported Bug/Ideas (' . $feedback_cnt_bugs . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[bugs]=1'),
      array('title' => 'External Messages (' . $feedback_cnt_external . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[external]=1'),
      array('title' => 'Sent', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=2'),
      array('title' => 'Drafts', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=3'),
      array('title' => 'Trash', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=4'),
      array('title' => 'Templates', 'uri' => 'feedbackTemplates/'),
      array('title' => 'All Outgoing Emails', 'uri' => 'feedback/outgoingMailList'),
    );
  }

  protected function getMessagesSubmenu()
  {
    return array(
      array('title' => 'Messages', 'uri' => 'messages/list?filter=filter'),
      array('title' => 'Predefined Messages', 'uri' => 'predefinedMessages/list'),
    );
  }

  protected function getFlagsSubmenu()
  {
    return array(
      array('title' => 'New Susp. by Flagging', 'uri' => 'flags/suspended?filter=filter&filters[confirmed]=0'),
      array('title' => 'Susp. By Flagging Confirmed', 'uri' => 'flags/suspended?filter=filter&filters[confirmed]=1'),
      array('title' => 'Flags', 'uri' => 'flags/list?filter=filter&filters[history]=0'),
      array('title' => 'Flaggers', 'uri' => 'flags/flaggers'),
      array('title' => 'Flag History', 'uri' => 'flags/list?filter=filter&filters[history]=1'),
    );
  }

  protected function getIpwatchSubmenu()
  {
    return array(
      array('title' => 'IP vs. Residence', 'uri' => 'ipwatch/residence'),
      array('title' => 'IP Duplicates', 'uri' => 'ipwatch/duplicates'),
      array('title' => 'IP Blacklisted', 'uri' => 'ipwatch/blacklisted'),
      array('title' => 'IP Blacklist', 'uri' => 'ipwatch/blacklist'),
      array('title' => 'IP Blocking', 'uri' => 'ipblocking/list'),
    );
  }

  public function getCatalogueSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getTransUnitsSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getStaticPagesSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getMemberStoriesSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getStatesSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getNotificationsSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getDescQuestionsSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getDescAnswersSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getSettingsSubmenu()
  {
    return $this->getContentSubmenu();
  }

  public function getFeedbackTemplatesSubmenu()
  {
    return $this->getFeedbackSubmenu();
  }

  public function getPredefinedMessagesSubmenu()
  {
    return $this->getMessagesSubmenu();
  }

  public function executeBreadcrumb()
  {
  }
  
  public function executeFormErrors()
  {
    $this->labels = array(

    );
  }
  
  public function executeMessages()
  {
    return array(
      array('title' => 'Messages', 'uri' => 'messages/list?filter=filter'),
      array('title' => 'Predefined Messages', 'uri' => 'predefinedMessages/list'),
    );
  }
  
  public function executeMembersSidebar()
  {
    $this->starred_array = array('0' => 'Not Starred', '1' => 'Starred');

    $this->sex_array = array('M_F' => 'Man looking for woman', 'F_M' => 'Woman looking for man',
                            'M_M' => 'Man looking for man', 'F_F' => 'Woman looking for woman');
    
    $c = new Criteria();
    $c->addAscendingOrderByColumn(CataloguePeer::CAT_ID);
    $this->catalogues = CataloguePeer::doSelect($c);
    $this->subscriptions = SubscriptionPeer::doSelect(new Criteria());
    $this->countries = array('PL', 'US', 'CA', 'GB', 'IE');
    $this->statuses = MemberStatusPeer::doSelect(new Criteria());
    $this->languages = array('en', 'pl', 'ar', 'zh', 'fr', 'de', 'he', 'it', 'pt', 'ru', 'es', 'sv', 'tr');
    
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/members/filters');
  }

  public function executePhotosSidebar()
  {
    $this->menu = array(array('title'  => 'Most Recent', 'uri' => 'photos/list?sort=Member::last_photo_upload_at&type=desc&filter=filter'),
                                            array('title'   => 'Pending Verification', 'uri' => 'photos/list?filter=filter&filters[pending_verification]=1&sort=no'),
                                            array('title'   => 'Male', 'uri' => 'photos/list?filter=filter&filters[sex]=M&sort=no'),
                                            array('title'   => 'Female', 'uri' => 'photos/list?filter=filter&filters[sex]=F&sort=no'),
                                            array('title'   => 'Country', 'uri' => 'photos/list?filter=filter&filters[by_country]=1&sort=no'),
                                            array('title'   => 'Popularity', 'uri' => 'photos/list?sort=MemberCounter::profile_views&type=desc&filter=filter'),
                                            array('title'   => 'Home Page', 'uri' => 'photos/homepage?cat_id=1&sort=no&filter=filter'),
                                            array('title'   => 'Member Stories', 'uri' => 'photos/memberStories?sort=no&filter=filter'),
                                            array('title'   => 'Public Search', 'uri' => 'photos/list?filter=filter&filters[public_search]=1&sort=no'),
                                            array('title'   => 'Stock Photos', 'uri' => 'photos/stockPhotos'),
                                            array('title'   => 'As Seen On Logos', 'uri' => 'photos/asSeenOnLogos'),
                                            array('title'   => 'All', 'uri' => 'photos/list?filter=filter&sort=no'),
                                           );

    $c = new Criteria();
    $c->addAscendingOrderByColumn(CataloguePeer::CAT_ID);
    $this->catalogues = array_merge(array('All'), CataloguePeer::doSelect($c));
    $this->statuses = MemberStatusPeer::doSelect(new Criteria());
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/photos/filters');
  }
}
