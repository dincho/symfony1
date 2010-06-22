<?php
class systemComponents extends sfComponents 
{
  public function executeTopMenu()
  {
    $this->menu = array(array('title' => 'Dashboard', 'uri' => 'dashboard/index'),
                         array('title' => 'Members', 'uri' => 'members/list'),
                         array('title' => 'Photos', 'uri' => 'photos/list?filter=filter&sort=Member::last_photo_upload_at&type=desc'),
                         array('title' => 'Content', 'uri' => 'content/homepages?cat_id=1'),
                         array('title' => 'GEO', 'uri' => 'geo/list'),
                         array('title' => 'Subscriptions', 'uri' => 'subscriptions/list'),
                         array('title' => 'Messages', 'uri' => 'messages/list'),
                         array('title' => 'Feedback', 'uri' => 'feedback/list'),
                         array('title' => 'Flags', 'uri' => 'flags/suspended'),
                         array('title' => 'IMBRA', 'uri' => 'imbra/list'),
                         array('title' => 'Reports', 'uri' => 'reports/list'),
                         array('title' => 'Users', 'uri' => 'users/list'),
                      );

    if( !isset($this->top_menu_selected )) $this->top_menu_selected = $this->getContext()->getModuleName();
  }
  
  public function executeLeftMenu()
  {
    //counters
    $imbra_cnt_pending = $imbra_cnt_approved = $imbra_cnt_denied = $feedback_cnt_all = $feedback_cnt_paid = $feedback_cnt_bugs = $feedback_cnt_external = 0;
    if( $this->getContext()->getModuleName() == 'feedback' )
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
    }

    if( $this->getContext()->getModuleName() == 'imbra' || $this->getContext()->getModuleName() == 'imbraReplyTemplates')
    {
        $c4 = new Criteria();
        $c4->add(MemberPeer::IMBRA_PAYMENT, 'completed');
        $c4->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);
        $c4->add(MemberImbraPeer::IMBRA_STATUS_ID, 1);
        $imbra_cnt_approved = MemberImbraPeer::doCount($c4);
        
        $c4->add(MemberImbraPeer::IMBRA_STATUS_ID, 2);
        $imbra_cnt_pending = MemberImbraPeer::doCount($c4);
        
        $c4->add(MemberImbraPeer::IMBRA_STATUS_ID, 3);
        $imbra_cnt_denied = MemberImbraPeer::doCount($c4);
    }
    if( $this->getContext()->getModuleName() == 'feedback' || $this->getContext()->getModuleName() == 'feedbackTemplates')
    {        
        $c = new Criteria();
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
    }
    
    $this->menu = array();
    $full_menu = array('content'  => array(//array('title' => 'Translation Catalogue', 'uri' => 'catalogue/list'),
                                           array('title' => 'Translation Units', 'uri' => 'transUnits/list'),
                                           array('title' => 'Home Pages', 'uri' => 'content/homepages?cat_id=1'),
                                           array('title' => 'Profile Pages', 'uri' => 'content/profilepages?cat_id=1'),
                                           array('title' => 'Search Pages', 'uri' => 'content/searchpages'),
                                           array('title' => 'Reg/Sign Up Pages', 'uri' => 'content/regpages?cat_id=1'),
                                           array('title' => 'System Messages', 'uri' => 'content/systemMessages?cat_id=1'),
                                           array('title' => 'Member Stories', 'uri' => 'memberStories/list?cat_id=1'),
                                           array('title' => 'Static Pages', 'uri' => 'staticPages/list'),
                                           array('title' => 'Best Videos Templates', 'uri' => 'content/bestVideo?cat_id=1'),
                                           array('title' => 'IMBRA Pages', 'uri' => 'content/imbrapages'),
                                           array('title' => 'Assistant', 'uri' => 'content/assistant?cat_id=1'),
                                           array('title' => 'Upload Photos', 'uri' => 'photos/upload'),
                                           array('title' => 'System Notifications', 'uri' => 'notifications/list?cat_id=1'),
                                           array('title' => 'Desc. Questions', 'uri' => 'descQuestions/list'),
                                           array('title' => 'Settings', 'uri' => 'settings/list'),
                                           array('title' => 'IP Blocking', 'uri' => 'ipblocking/list'),
                                           array('title' => 'Clear Global Cache', 'uri' => 'system/clearGlobalCache'),
                                           ),
                        'photos'    => array(array('title'  => 'Most Recent', 'uri' => 'photos/list?sort=Member::last_photo_upload_at&type=desc&filter=filter'),
                                            array('title'   => 'Male', 'uri' => 'photos/list?filter=filter&filters[sex]=M&sort=no'),
                                            array('title'   => 'Female', 'uri' => 'photos/list?filter=filter&filters[sex]=F&sort=no'),
                                            array('title'   => 'Country', 'uri' => 'photos/list?filter=filter&filters[by_country]=1&sort=no'),
                                            array('title'   => 'Popularity', 'uri' => 'photos/list?sort=MemberCounter::profile_views&type=desc&filter=filter'),
                                            array('title'   => 'Home Page', 'uri' => 'photos/homepage?cat_id=1&sort=no&filter=filter'),
                                            array('title'   => 'Member Stories', 'uri' => 'photos/memberStories?sort=no&filter=filter'),
                                            array('title'   => 'Public Search', 'uri' => 'photos/list?filter=filter&filters[public_search]=1&sort=no'),
                                            array('title'   => 'Stock Photos', 'uri' => 'photos/stockPhotos'),
                                            array('title'   => 'All', 'uri' => 'photos/list?filter=filter&sort=no'),
                                           ),                                                                 
                        'geo'       => array(array('title' => 'Recent sign up cities w/out coord.', 'uri' => 'geo/citiesWithoutCoordinates'),
                                            array('title' => 'Empty Countries', 'uri' => 'geo/emptyCountries'),
                                            array('title' => 'Empty Admin1\'s', 'uri' => 'geo/emptyAdm1'),
                                            array('title' => 'Empty Admin2\'s', 'uri' => 'geo/emptyAdm2'),
                                           ),
                        'users'     => array(array('title' => 'Users', 'uri' => 'users/list'),
                                           ),
                        'imbra'     => array(array('title' => 'Pending (' . $imbra_cnt_pending . ')', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=2'),
                                           array('title' => 'Approved (' . $imbra_cnt_approved . ')', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=1'),
                                           array('title' => 'Denied (' . $imbra_cnt_denied . ')', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=3'),
                                           array('title' => 'Reply Templates', 'uri' => 'imbraReplyTemplates/list'),
                                           ),
                        'reports'   => array(array('title' => 'Daily Sales', 'uri' => 'reports/dailySales'),
                                           array('title' => 'Member Activity', 'uri' => 'reports/memberActivity'),
                                           array('title' => 'Active Members', 'uri' => 'reports/activeMembers'),
                                           array('title' => 'Flags/ Suspensions', 'uri' => 'reports/flagsSuspensions'),
                                           array('title' => 'IMBRA', 'uri' => 'reports/imbra'),
                                           array('title' => 'Registration', 'uri' => 'reports/registration'),
                                           ),
                        'feedback'  => array(array('title' => 'All Messages (' . $feedback_cnt_all . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1'),
                                           array('title' => 'From Paid Members (' . $feedback_cnt_paid . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[paid]=1'),
                                           array('title' => 'Reported Bug/Ideas (' . $feedback_cnt_bugs . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[bugs]=1'),
                                           array('title' => 'External Messages (' . $feedback_cnt_external . ')', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[external]=1'),
                                           array('title' => 'Sent', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=2'),
                                           array('title' => 'Drafts', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=3'),
                                           array('title' => 'Trash', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=4'),
                                           array('title' => 'Templates', 'uri' => 'feedbackTemplates/'),
                                           ),
                        'messages' => array(array('title' => 'Messages', 'uri' => 'messages/list?filter=filter'),
                                            array('title' => 'Predefined Messages', 'uri' => 'predefinedMessages/list'),
                                           ),
                        'flags'    => array(array('title' => 'New Susp. by Flagging', 'uri' => 'flags/suspended?filter=filter&filters[confirmed]=0'),
                                           array('title' => 'Susp. By Flagging Confirmed', 'uri' => 'flags/suspended?filter=filter&filters[confirmed]=1'),
                                           array('title' => 'Flags', 'uri' => 'flags/list?filter=filter&filters[history]=0'),
                                           array('title' => 'Flaggers', 'uri' => 'flags/flaggers'),
                                           array('title' => 'Flag Rules', 'uri' => 'flagCategories/edit'),
                                           array('title' => 'Flag History', 'uri' => 'flags/list?filter=filter&filters[history]=1'),
                                           ),                                           
                        'members'  => array(array('title' => 'All Members', 'uri' => 'members/list?filter=filter'),
                                           array('title' => 'Male Members', 'uri' => 'members/list?filter=filter&filters[sex]=m'),
                                           array('title' => 'Female Members', 'uri' => 'members/list?filter=filter&filters[sex]=f'),
                                           array('title' => 'Standard Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::FREE),
                                           array('title' => 'Premium Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::PREMIUM),
                                           array('title' => 'VIP Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::VIP),
                                           array('title' => 'Polish Members', 'uri' => 'members/list?filter=filter&filters[country]=PL'),
                                           array('title' => 'Foreign (US) Members', 'uri' => 'members/list?filter=filter&filters[country]=US'),
                                           array('title' => 'Foreign (Non-US) Members', 'uri' => 'members/list?filter=filter&filters[country]=NON-US'),
                                           array('title' => 'Suspended Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::SUSPENDED),
                                           array('title' => 'Flagged Members', 'uri' => 'members/list?filter=filter&filters[flagged]=1'),
                                           array('title' => 'Deleted Members', 'uri' => 'members/list?filter=filter&filters[canceled]=1'),
                                           array('title' => 'Starred Members', 'uri' => 'members/list?filter=filter&filters[is_starred]=1'),
                                           array('title' => 'Deactivated Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DEACTIVATED),
                                           array('title' => 'Auto Deactivated Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DEACTIVATED_AUTO),
                                           array('title' => 'Abandoned Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::ABANDONED),
                                           array('title' => 'Pending Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::PENDING),
                                           array('title' => 'Denied Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DENIED),
                                           array('title' => 'Not activated yet', 'uri' => 'members/list?filter=filter&filters[no_email_confirmation]=1'),
                                           ),
                      );
    //duplicates                  
    $full_menu['imbraReplyTemplates'] = $full_menu['imbra'];
    $full_menu['catalogue'] = $full_menu['content'];
    $full_menu['transUnits'] = $full_menu['content'];
    $full_menu['staticPages'] = $full_menu['content'];
    $full_menu['memberStories'] = $full_menu['content'];
    $full_menu['states'] = $full_menu['content'];
    $full_menu['notifications'] = $full_menu['content'];
    $full_menu['descQuestions'] = $full_menu['content'];
    $full_menu['descAnswers'] = $full_menu['content'];
    $full_menu['settings'] = $full_menu['content'];
    $full_menu['feedbackTemplates'] = $full_menu['feedback'];
    $full_menu['flagCategories'] = $full_menu['flags'];
    $full_menu['predefinedMessages'] = $full_menu['messages'];
    

    $module = ( isset($this->top_menu_selected )) ? $this->top_menu_selected : $this->getContext()->getModuleName();
    if( !isset($this->left_menu_selected) ) $this->left_menu_selected = null;
    
    if(array_key_exists($module, $full_menu))
    {
      $this->menu = $full_menu[$module];
    }
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

  }
  
  public function executeMembersSidebar()
  {
    $this->sex_array = array('M_F' => 'Man looking for woman', 'F_M' => 'Woman looking for man',
                            'M_M' => 'Man looking for man', 'F_F' => 'Woman looking for woman');
    
    $c = new Criteria();
    $c->addAscendingOrderByColumn(SubscriptionPeer::AMOUNT);
    $this->subscriptions = SubscriptionPeer::doSelect($c);
    $this->countries = array('PL', 'US', 'CA', 'GB', 'IE');
    $this->statuses = MemberStatusPeer::doSelect(new Criteria());
    $this->languages = array('en', 'pl', 'ar', 'zh', 'fr', 'de', 'he', 'it', 'pt', 'ru', 'es', 'sv', 'tr');
    
    
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/members/filters');
  }
}
?>