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
    if( $this->getRequest()->getMethod() == sfRequest::POST )
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
      $user->save();
      
      //permissions
      $user_groups = $this->getRequestParameter('user_groups');
      if( !empty($user_groups) )
      {
        foreach ($user_groups as $group_id) {
          $perm = new Permissions();
          $perm->setGroupId($group_id);
          $perm->setId($user->getId());
          $perm->save();
        }        
      }
            
      $this->setFlash('msg_ok', 'User ' . $user->getUsername() . ' has been added.');
      return $this->redirect('users/list');
    } else {
      //groups for permissions
      $criteria = new Criteria();
      $criteria->addAscendingOrderByColumn(GroupsPeer::GROUP_NAME);
      $this->groups = GroupsPeer::doSelect($criteria);
    }
  }

  public function handleErrorCreate()
  {
    $criteria = new Criteria();
    $criteria->addAscendingOrderByColumn(GroupsPeer::GROUP_NAME);
    $this->groups = GroupsPeer::doSelect($criteria);    
    return sfView::SUCCESS;
  }
    
  public function executeEdit()
  {
    $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($user);
    $this->user = $user;
    
    $this->updatePermissions();
    
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
      if($this->getRequestParameter('password')) $user->setPassword($this->getRequestParameter('password'));
      $user->setFirstName($this->getRequestParameter('first_name'));
      $user->setLastName($this->getRequestParameter('last_name'));
      $user->setEmail($this->getRequestParameter('email'));
      $user->setPhone($this->getRequestParameter('phone'));
      $user->setMustChangePwd($this->getRequestParameter('must_change_pwd', 0));
      $user->setIsEnabled($this->getRequestParameter('is_enabled', 0));
  
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
    
    if( is_array($marked) && !empty($marked) )
    {
      $c = new Criteria();
      $c->add(UserPeer::ID, $marked, Criteria::IN);
      UserPeer::doDelete($c);
    }

    $this->setFlash('msg_ok', 'Selected users has been deleted.');
    return $this->redirect('users/list');
  }

  protected function updatePermissions()
  {
    $id = $this->getRequestParameter('id');
    
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
      $user_groups = $this->getRequestParameter('user_groups');
      
      sfNewSecurityQueries::deleteAllUserGroups($id);
      
      if( !empty($user_groups) )
      {
        foreach ($user_groups as $group_id) {
          $perm = new Permissions();
          $perm->setGroupId($group_id);
          $perm->setId($id);
          $perm->save();
        }        
      }
    } else {
      $criteria = new Criteria();
      $criteria->addAscendingOrderByColumn(GroupsPeer::GROUP_NAME);
      $this->groups = GroupsPeer::doSelect($criteria);
      $this->user_groups = sfNewSecurityQueries::getUserGroups($id);
    }    
  }
  
}
