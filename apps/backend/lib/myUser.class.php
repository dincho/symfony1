<?php

class myUser extends sfBasicSecurityUser
{
    private $profile = null;

    public function getId()
    {
        return $this->getAttribute('user_id');
    }

    public function getUsername()
    {
        return $this->getAttribute('username');
    }

    public function getBC()
    {
        return prBackendBreadCrumb::getInstance();
    }

    public function getLastLogin($format = 'm/d/Y H:iA T')
    {
        return date($format, $this->getAttribute('last_login'));
    }

    /**
     * Get User`s profile
     *
     * @return User
     */
    public function getProfile()
    {
        if (is_null($this->profile))
        {
            $this->profile = UserPeer::retrieveByPK($this->getId());
        }
        
        return $this->profile;
    }

    public function signIn($logged)
    {
        $this->setAuthenticated(true);
        $this->setAttribute('username', $logged->getUsername());
        $this->setAttribute('user_id', $logged->getId());
        $this->setAttribute('last_login', $logged->getLastLogin(null)); //set last login as timestamp
        $this->setAttribute('must_change_pwd', $logged->getMustChangePwd());
        

        $credentials = array();
        
        if ($logged->getDashboardMod())
            $credentials[] = ($logged->getDashboardModType() == 'E') ? 'dashboard_edit' : 'dashboard';
        if ($logged->getMembersMod())
            $credentials[] = ($logged->getMembersModType() == 'E') ? 'members_edit' : 'members';
        if ($logged->getContentMod())
            $credentials[] = ($logged->getContentModType() == 'E') ? 'content_edit' : 'content';
        if ($logged->getSubscriptionsMod())
            $credentials[] = ($logged->getSubscriptionsModType() == 'E') ? 'subscriptions_edit' : 'subscriptions';
        if ($logged->getMessagesMod())
            $credentials[] = ($logged->getMessagesModType() == 'E') ? 'messages_edit' : 'messages';
        if ($logged->getFlagsMod())
            $credentials[] = ($logged->getFlagsModType() == 'E') ? 'flags_edit' : 'flags';
        if ($logged->getImbraMod())
            $credentials[] = ($logged->getImbraModType() == 'E') ? 'imbra_edit' : 'imbra';
        if ($logged->getReportsMod())
            $credentials[] = ($logged->getReportsModType() == 'E') ? 'reports_edit' : 'reports';
        if ($logged->getUsersMod())
            $credentials[] = ($logged->getUsersModType() == 'E') ? 'users_edit' : 'users';
        
        $this->addCredentials($credentials);
    }

    public function checkPerm($credentials = array())
    {
        $controller = sfContext::getInstance()->getController();
        if (! $this->hasCredential($credentials, false))
        {
            $controller->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
            throw new sfStopException();
        }
    }

    public function getRefererUrl()
    {
        $stack = $this->getAttributeHolder()->getAll('backend/user/referer_stack');
        return isset($stack[1]) ? $stack[1] : null;
    }
}
