<?php
class sfNewSecurityGroupsActions extends sfActions
{
  public function preExecute()
  {
    $this->current_module = 'users';
    $this->left_menu_selected = 'Groups';
    $this->getUser()->getBC()->replaceFirst(array('name' => 'Groups', 'uri' => '@list_groups'));
  }

  public function executeIndex()
  {
    $this->forward('sfNewSecurityGroups', 'list');
  }
    
  public function executeList()
  {
    $criteria = new Criteria();
    $criteria->addAscendingOrderByColumn(GroupsPeer::GROUP_NAME);
    $groups = GroupsPeer::doSelect($criteria);
    $this->groups = $groups;
  }

  public function executeShow()
  {
    $id = $this->getRequestParameter("id");
    
    $group = GroupsPeer::retrieveByPK($id);
    
    $group_actions = array();
    $perms = $group->getGroupAndActions();
    foreach ($perms as $perm)
        $group_actions[] = $perm->getAction();
        
    $this->group = $group;
    $this->group_actions = $group_actions;
  }
  
  public function executeCreate()
  {
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
      $group_name = $this->getRequestParameter("group_name");
      $group_description = $this->getRequestParameter("group_description");
      $group_actions = $this->getRequestParameter("group_actions");
      
      $group = new Groups();
      $group->setGroupName($group_name);
      $group->setGroupDescription($group_description);
      $group->save();
      
      foreach ($group_actions as $action) {
          $perm = new GroupAndAction();
          $perm->setGroupId($group->getId());
          $perm->setAction($action);
          $perm->save();
      }
      
      $this->setFlash('msg_ok', 'Group ' . $group->getGroupName() . ' has been created.');
      return $this->redirect("@list_groups");  
    } else {
      $dir = sfConfig::get("sf_app_dir")."/modules";
      $this->dirs = sfDirectoryActions::listDirs($dir);      
    }
  }
  
  public function executeNew()
  {
    $group_name = $this->getRequestParameter("group_name");
    $group_description = $this->getRequestParameter("group_description");
    $group_actions = $this->getRequestParameter("group_actions");
    
    $group = new Groups();
    $group->setGroupName($group_name);
    $group->setGroupDescription($group_description);
    $group->save();
    
    foreach ($group_actions as $action) {
        $perm = new GroupAndAction();
        $perm->setGroupId($group->getId());
        $perm->setAction($action);
        $perm->save();
    }
    
    return $this->redirect("@list_groups");
  }
  
  public function executeEdit()
  {
    $id = $this->getRequestParameter("id");
    $group = GroupsPeer::retrieveByPK($id);
    $this->forward404Unless($group);
    
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
      $group_name = $this->getRequestParameter("group_name");
      $group_description = $this->getRequestParameter("group_description");
      $group_actions = $this->getRequestParameter("group_actions");
      
      $group->setGroupName($group_name);
      $group->setGroupDescription($group_description);
      $group->save();
      
      $conn = Propel::getConnection();
      $conn->begin();
      $perms = $group->getGroupAndActions();
      foreach ($perms as $perm)
          $perm->delete($conn);
      
      $group = GroupsPeer::retrieveByPK($id);
      foreach ($group_actions as $action) {
          $perm = new GroupAndAction();
          $perm->setGroupId($group->getId());
          $perm->setAction($action);
          $perm->save($conn);
      }
      $conn->commit();
      
      $this->setFlash('msg_ok', 'Your changes has been saved.');
      return $this->redirect("@list_groups");      
    } else {
      $this->group = $group;
      $group_actions = array();
      $perms = $group->getGroupAndActions();
      foreach ($perms as $perm)
          $group_actions[] = $perm->getAction();
      $this->group_actions = $group_actions;
      
      $dir = sfConfig::get("sf_app_dir")."/modules";
      $this->dirs = sfDirectoryActions::listDirs($dir);      
    }
  }
  
  public function executeUpdate()
  {
    $id = $this->getRequestParameter("group_id");
    $group_name = $this->getRequestParameter("group_name");
    $group_description = $this->getRequestParameter("group_description");
    $group_actions = $this->getRequestParameter("group_actions");
    
    $group = GroupsPeer::retrieveByPK($id);
    $group->setGroupName($group_name);
    $group->setGroupDescription($group_description);
    $group->save();
    
    $conn = Propel::getConnection();
    $conn->begin();
    $perms = $group->getGroupAndActions();
    foreach ($perms as $perm)
        $perm->delete($conn);
    
    $group = GroupsPeer::retrieveByPK($id);
    foreach ($group_actions as $action) {
        $perm = new GroupAndAction();
        $perm->setGroupId($group->getId());
        $perm->setAction($action);
        $perm->save($conn);
    }
    $conn->commit();
    
    return $this->redirect("@list_groups");
  }
  
  public function executeDelete()
  {
    $marked = $this->getRequestParameter('marked', false);
    
    if( is_array($marked) && !empty($marked) )
    {
      $c = new Criteria();
      $c->add(GroupsPeer::ID, $marked, Criteria::IN);
      GroupsPeer::doDelete($c);
      
      $this->setFlash('msg_ok', 'Selected groups has been deleted.');
    }
    
    return $this->redirect("@list_groups");
  }
}