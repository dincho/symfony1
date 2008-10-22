<?php
class myUser extends sfBasicSecurityUser
{
    private $profile = null;

    public function getId()
    {
        return $this->getAttribute('member_id');
    }

    public function getUsername()
    {
        return $this->getAttribute('username');
    }

    public function getBC()
    {
        return prFrontendBreadCrumb::getInstance();
    }

    /**
     * Get User`s profile
     *
     * @return Member
     */
    public function getProfile()
    {
        if (is_null($this->profile))
        {
            $this->profile = MemberPeer::retrieveByPK($this->getId());
        }
        return $this->profile;
    }
    
    public function SignIn($member)
    {
        $this->setAuthenticated(true);
        $this->addCredential('member');
        $this->setAttribute('username', $member->getUsername());
        $this->setAttribute('member_id', $member->getId());
        $this->setAttribute('status_id', $member->getMemberStatusId());
        $this->setAttribute('must_change_pwd', $member->getMustChangePwd());        
    }
    
    public function SignOut()
    {
        $this->getAttributeHolder()->clear();
        $this->clearCredentials();
        $this->setAuthenticated(false);        
    }
    
    public function getRefererUrl()
    {
        $stack = $this->getAttributeHolder()->getAll('frontend/member/referer_stack');
        return isset($stack[1]) ? $stack[1] : null;
    }
}
