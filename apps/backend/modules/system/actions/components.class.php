<?php
class systemComponents extends sfComponents 
{
  public function executeTopMenu()
  {
    $this->menu = array(array('title' => 'Dashboard', 'uri' => 'dashboard/index'),
                         array('title' => 'Members', 'uri' => 'members/list'),
                         array('title' => 'Content', 'uri' => 'staticPages/list'),
                         array('title' => 'Subscriptions', 'uri' => 'subscriptions/list'),
                         array('title' => 'Messages', 'uri' => 'messages/list'),
                         array('title' => 'Feedback', 'uri' => 'feedback/list'),
                         array('title' => 'Flags', 'uri' => 'flags/list'),
                         array('title' => 'IMBRA', 'uri' => 'imbra/list'),
                         array('title' => 'Reports', 'uri' => 'reports/list'),
                         array('title' => 'Users', 'uri' => 'users/list'),
                      );

    if( !isset($this->top_menu_selected )) $this->top_menu_selected = $this->getContext()->getModuleName();
  }
  
  public function executeLeftMenu()
  {
    $this->menu = array();
    $full_menu = array( 'members'  => array(array('title' => 'All Members', 'uri' => 'members/index'),
                                           array('title' => 'Male Members', 'uri' => 'members/index'),
                                           array('title' => 'Female Members', 'uri' => 'members/index'),
                                           array('title' => 'Free Members', 'uri' => 'members/index'),
                                           array('title' => 'Paid Members', 'uri' => 'members/index'),
                                           array('title' => 'VIP Members', 'uri' => 'members/index'),
                                           array('title' => 'Comp Members', 'uri' => 'members/index'),
                                           array('title' => 'Polish Members', 'uri' => 'members/index'),
                                           array('title' => 'Foreign (US) Members', 'uri' => 'members/index'),
                                           array('title' => 'Foreign (Non-US) Members', 'uri' => 'members/index'),
                                           array('title' => 'Suspended Members', 'uri' => 'members/index'),
                                           array('title' => 'Flagged Members', 'uri' => 'members/index'),
                                           array('title' => 'Deleted Members', 'uri' => 'members/index'),
                                           array('title' => 'Statred Members', 'uri' => 'members/index'),
                                           array('title' => 'Non Activated Members', 'uri' => 'members/index'),
                                           array('title' => 'Abardoned Registration', 'uri' => 'members/index'),
                                           ),
                        'content'  => array(array('title' => 'Translation Catalogue', 'uri' => 'catalogue/list'),
                                           array('title' => 'Translation Units', 'uri' => 'transUnits/list'),
                                           array('title' => 'Static Pages', 'uri' => 'staticPages/list'),
                                           array('title' => 'Member Stories', 'uri' => 'memberStories/list'),
                                           array('title' => 'Areas', 'uri' => 'areas/edit'),
                                           array('title' => 'System Notifications', 'uri' => 'notifications/list'),
                                           array('title' => 'Desc. Questions', 'uri' => 'descQuestions/list'),
                                           array('title' => 'Settings', 'uri' => 'settings/list'),
                                           ),
                        'users'    => array(array('title' => 'Users', 'uri' => 'users/list'),
                                           ),
                        'imbra'    => array(array('title' => 'Pending', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=2'),
                                           array('title' => 'Approved', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=1'),
                                           array('title' => 'Denied', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=3'),
                                           array('title' => 'Reply Templates', 'uri' => 'imbraReplyTemplates/list'),
                                           ),
                        'feedback' => array(array('title' => 'All Messages', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1'),
                                           array('title' => 'From Paid Members', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[paid]=1'),
                                           array('title' => 'Reported Bug/Ideas', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[bugs]=1'),
                                           array('title' => 'External Messages', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1&filters[external]=1'),
                                           array('title' => 'Sent', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=2'),
                                           array('title' => 'Drafts', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=3'),
                                           array('title' => 'Trash', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=4'),
                                           array('title' => 'Templates', 'uri' => 'feedbackTemplates/list'),
                                           ),
                        'messages' => array(array('title' => 'Messages', 'uri' => 'messages/list?filter=filter'),
                                           ),
                        'flags'    => array(array('title' => 'New Susp. by Flagging', 'uri' => 'flags/suspended?filter=filter&filters[confirmed]=0'),
                                           array('title' => 'Susp. By Flagging Confirmed', 'uri' => 'flags/suspended?filter=filter&filters[confirmed]=1'),
                                           array('title' => 'Flags', 'uri' => 'flags/list?filter=filter&filters[history]=0'),
                                           array('title' => 'Flaggers', 'uri' => 'flags/flaggers'),
                                           array('title' => 'Flag Categories', 'uri' => 'flagCategories/edit'),
                                           array('title' => 'Flag History', 'uri' => 'flags/list?filter=filter&filters[history]=1'),
                                           ),                                           
                        'members' => array(array('title' => 'All Members', 'uri' => 'members/list?filter=filter'),
                                           array('title' => 'Male Members', 'uri' => 'members/list?filter=filter&filters[sex]=m'),
                                           array('title' => 'Female Members', 'uri' => 'members/list?filter=filter&filters[sex]=f'),
                                           array('title' => 'Free Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::FREE),
                                           array('title' => 'Paid Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::PAID),
                                           array('title' => 'VIP Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::VIP),
                                           array('title' => 'Comp Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::COMP),
                                           array('title' => 'Polish Members', 'uri' => 'members/list?filter=filter&filters[country]=PL'),
                                           array('title' => 'Foreign (US) Members', 'uri' => 'members/list?filter=filter&filters[country]=US'),
                                           array('title' => 'Foreign (Non-US) Members', 'uri' => 'members/list?filter=filter&filters[country]=NON-US'),
                                           array('title' => 'Suspended Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::SUSPENDED),
                                           array('title' => 'Flagged Members', 'uri' => 'members/list?filter=filter&filters[flagged]=1'),
                                           array('title' => 'Deleted Members', 'uri' => 'members/list?filter=filter&filters[canceled]=1'),
                                           array('title' => 'Starred Members', 'uri' => 'members/list?filter=filter&filters[is_starred]=1'),
                                           array('title' => 'Not Activated Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DEACTIVATED),
                                           array('title' => 'Abandoned Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::ABANDONED),
                                           array('title' => 'Pending Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::PENDING),
                                           array('title' => 'Denied Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DENIED),
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
}
?>