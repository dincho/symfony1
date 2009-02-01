<?php

/**
 * users actions.
 *
 * @package    pr
 * @subpackage users
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class usersActions extends sfActions
{

    public function preExecute()
    {
        $this->left_menu_selected = 'Users';
    }

    public function executeIndex()
    {
        return $this->forward('users', 'list');
    }

    public function executeList()
    {
        $this->users = UserPeer::doSelect(new Criteria());
    }

    public function executeShow()
    {
        $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->user);
    }

    public function executeCreate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $user = new User();
            $user->setUsername($this->getRequestParameter('username'));
            $user->setPassword($this->getRequestParameter('password'));
            $user->setFirstName($this->getRequestParameter('first_name'));
            $user->setLastName($this->getRequestParameter('last_name'));
            $user->setEmail($this->getRequestParameter('email'));
            $user->setPhone($this->getRequestParameter('phone'));
            $user->setMustChangePwd($this->getRequestParameter('must_change_pwd', 0));
            $user->setIsEnabled($this->getRequestParameter('is_enabled', 0));
            $this->updatePermissions($user);
            $user->save();
            
            $this->setFlash('msg_ok', 'User ' . $user->getUsername() . ' has been added.');
            return $this->redirect('users/list');
        }
    }

    public function handleErrorCreate()
    {
        return sfView::SUCCESS;
    }

    public function executeEdit()
    {
        $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($user);
        $this->user = $user;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('users_edit'));
            if ($this->getRequestParameter('password')) $user->setPassword($this->getRequestParameter('password'));
            $user->setFirstName($this->getRequestParameter('first_name'));
            $user->setLastName($this->getRequestParameter('last_name'));
            $user->setEmail($this->getRequestParameter('email'));
            $user->setPhone($this->getRequestParameter('phone'));
            $user->setMustChangePwd($this->getRequestParameter('must_change_pwd', 0));
            $user->setIsEnabled($this->getRequestParameter('is_enabled', 0));
            $this->updatePermissions($user);
            $user->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            return $this->redirect('users/list');
        }
    }

    public function handleErrorEdit()
    {
        $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->user);
        
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(GroupsPeer::GROUP_NAME);
        $this->groups = GroupsPeer::doSelect($criteria);
        $this->user_groups = sfNewSecurityQueries::getUserGroups($this->getRequestParameter('id'));
        
        return sfView::SUCCESS;
    }

    public function executeDelete()
    {
        $marked = $this->getRequestParameter('marked', false);
        
        if (is_array($marked) && ! empty($marked))
        {
            $c = new Criteria();
            $c->add(UserPeer::ID, $marked, Criteria::IN);
            UserPeer::doDelete($c);
        }
        
        $this->setFlash('msg_ok', 'Selected users has been deleted.');
        return $this->redirect('users/list');
    }

    protected function updatePermissions($user)
    {
        $user->setDashboardMod($this->getRequestParameter('dashboard_mod', false));
        $user->setDashboardModType($this->getRequestParameter('dashboard_mod_type', 'V'));
        $user->setMembersMod($this->getRequestParameter('members_mod', false));
        $user->setMembersModType($this->getRequestParameter('members_mod_type', 'V'));
        $user->setContentMod($this->getRequestParameter('content_mod', false));
        $user->setContentModType($this->getRequestParameter('content_mod_type', 'V'));
        $user->setSubscriptionsMod($this->getRequestParameter('subscriptions_mod', false));
        $user->setSubscriptionsModType($this->getRequestParameter('subscriptions_mod_type', 'V'));
        $user->setMessagesMod($this->getRequestParameter('messages_mod', false));
        $user->setMessagesModType($this->getRequestParameter('messages_mod_type', 'V'));
        $user->setFlagsMod($this->getRequestParameter('flags_mod', false));
        $user->setFlagsModType($this->getRequestParameter('flags_mod_type', 'V'));
        $user->setImbraMod($this->getRequestParameter('imbra_mod', false));
        $user->setImbraModType($this->getRequestParameter('imbra_mod_type', 'V'));
        $user->setReportsMod($this->getRequestParameter('reports_mod', false));
        $user->setReportsModType($this->getRequestParameter('reports_mod_type', 'V'));
        $user->setUsersMod($this->getRequestParameter('users_mod', false));
        $user->setUsersModType($this->getRequestParameter('users_mod_type', 'V'));
    }
    
    public function executeMyAccount()
    {
        $user = $this->getUser()->getProfile();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST ) 
        {
            if ($this->getRequestParameter('password')) 
            {
                $user->setPassword($this->getRequestParameter('password'));
                if ($this->getUser()->getAttribute('must_change_pwd', false))
                {
                    $user->setMustChangePwd(false);
                    $this->getUser()->setAttribute('must_change_pwd', false);
                }                 
            }
            
            $user->setFirstName($this->getRequestParameter('first_name'));
            $user->setLastName($this->getRequestParameter('last_name'));
            $user->setEmail($this->getRequestParameter('email'));
            $user->setPhone($this->getRequestParameter('phone'));
            $user->save();
            
            if(!$this->getUser()->getAttribute('must_change_pwd', false)) $this->setFlash('msg_ok', 'Your account information has been updated');
            $this->redirect('dashboard/index');
        }
        
        $this->user = $user;
    }
    
    public function handleErrorMyAccount()
    {
        $this->user = $this->getuser()->getProfile();
        return sfView::SUCCESS;
    }
}
