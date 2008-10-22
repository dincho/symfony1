<?php
class sfNewSecurityUser extends sfBasicSecurityUser
{
    private $actions;
    private $groups;
    
    public function __construct() {
        $this->actions = null;
        $this->groups = null;
    }
    
    public function login($user_id) {
        parent::setAuthenticated(true);
        
        // Setting the ID for the user session
        $class = sfConfig::get("app_new_sec_class");
        $id = sfConfig::get("app_new_sec_id");
        $this->setAttribute($id, $user_id, "{$class}_sfNewSecurityPlugin");
        
        // Setting the TEXT PARAMS (user name) for the user session
        $user = sfNewSecurityQueries::getUser($user_id);
        $this->setAttribute("name", $user["name"], "{$class}_sfNewSecurityPlugin");
        
        // Setting the CREDENTIALS for the user session
        $this->actions = sfNewSecurityQueries::getUserActions($user_id);
        $this->groups = sfNewSecurityQueries::listUserGroups($user_id);
        $this->setAttribute("actions", $this->actions, "sfNewSecurityPlugin");
        $this->setAttribute("groups", $this->groups, "sfNewSecurityPlugin");
    }
    
    public function logout() {
        parent::setAuthenticated(false);
        $this->clearCredentials();
    }
    
    public function addCredential($group_name) {
        $class = sfConfig::get("app_new_sec_class");
        $id = sfConfig::get("app_new_sec_id");
        $user_id = $this->getAttribute($id, null, $class);
        $group_id = sfNewSecurityQueries::getGroupIdByName($group_name);
        $groups = $this->getCredentials();
        $group_actions = sfNewSecurityQueries::getGroupActions($group_id);
        
        if (!in_array($group_name, $groups) && !array_key_exists($group_id))
            $groups[$group_id] = $group_name;
        $this->groups = $groups;
        $this->setAttribute("groups", $this->groups, "sfNewSecurityPlugin");
        sfNewSecurityQueries::addUserGroup($user_id, $group_id);
        
        $actions = $this->getAttribute("actions", null, "sfNewSecurityPlugin");
        foreach ($group_actions as $group_action)
            if (!in_array($group_action, $action))
                $action[] = $group_action;
        $this->actions = $actions;
        $this->setAttribute("actions", $this->actions, "sfNewSecurityPlugin");
    }
    
    public function addCredentials() {
        $group_names = func_get_args();
        foreach ($group_names as $group_name)
            $this->addCredential($group_name);
    }
    
    public function getCredentials() {
        if (empty($this->groups))
            $this->groups = $this->getAttribute("groups", array(), "sfNewSecurityPlugin");
        
        return $this->groups;
    }
    
    public function hasCredential($credential) {
        return in_array($credential, $this->getCredentials());
    }
    
    public function clearCredentials() {
        $this->getAttributeHolder()->clear();
    }
}