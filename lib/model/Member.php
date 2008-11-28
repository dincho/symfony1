<?php
/**
 * Subclass for representing a row from the 'member' table.
 *
 * 
 *
 * @package lib.model
 */
class Member extends BaseMember
{

    //we do not need 0 as value, null is good
    public function getZip()
    {
        return ( parent::getZip() != 0 ) ? parent::getZip() : null;
    }
    
    public function setPassword($v, $hash_it = true)
    {
        $new_val = ($hash_it) ? sha1(SALT . $v . SALT) : $v;
        parent::setPassword($new_val);
    }
    
    public function setNewPassword($v)
    {
        parent::setNewPassword(sha1(SALT . $v . SALT));
    }
    
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getReviewedBy()
    {
        if ($this->getReviewedById())
        {
            return UserPeer::retrieveByPK($this->getReviewedById());
        }
    }

    public function clearDescAnswers()
    {
        $select = new Criteria();
        $select->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());
        MemberDescAnswerPeer::doDelete($select);
    }

    /*
   * @return MemberImbra
   */
    public function getLastImbra($approved = false)
    {
        $c = new Criteria();
        $c->add(MemberImbraPeer::MEMBER_ID, $this->getId());
        $c->addDescendingOrderByColumn(MemberImbraPeer::CREATED_AT);
        if( $approved ) $c->add(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::APPROVED);
        $c->setLimit(1);
        
        return MemberImbraPeer::doSelectOne($c);
    }

    public function getMemberImbras($crit = null, $con = null)
    {
        $c = (is_null($crit)) ? new Criteria() : $crit;
        $c->addDescendingOrderByColumn(MemberImbraPeer::CREATED_AT);
        return parent::getMemberImbras($c, $con);
    }

    public function changeStatus($StatusId, $kill_session = true)
    {
        if ($this->getMemberStatusId() != $StatusId)
        {
            if( ($this->getMemberStatusId() == MemberStatusPeer::PENDING ) && $StatusId == MemberStatusPeer::ACTIVE )
            {
                Events::triggerWelcomeApproved($this);
            }
            
            $history = new MemberStatusHistory();
            $history->setMemberStatusId($StatusId);
            $this->addMemberStatusHistory($history);
            $this->setMemberStatusId($StatusId);
            $this->setLastStatusChange(time());
            
            if( $StatusId != MemberStatusPeer::DEACTIVATED && $kill_session ) $this->killSession();
        }
    }
    
    public function changeSubscription($subscription_id)
    {
        if ($this->getSubscriptionId() != $subscription_id)
        {
            $this->setSubscriptionId($subscription_id);
        }
    }
    
    /**
     * Alias of getMemberCounter
     *
     * @return MemberCounter
     * @param string $key
     */
    public function getCounter($key = null)
    {
        if( is_null($key) )
        {
            return $this->getMemberCounter();
        } else {
            $method = 'get' . $key;
            return $this->getMemberCounter()->$method();            
        }
        
    }
    
    public function incCounter($key = null)
    {
        if( !is_null($key) )
        {
            $getmethod = 'get' . $key;
            $setmethod = 'set' . $key;
            
            $counter = $this->getMemberCounter();
            $new_val = $counter->$getmethod() + 1;
            
            call_user_func(array($counter, $setmethod), $new_val);
            call_user_func(array($counter, 'save'));
        }
    }
    
    public function clearCounter($key = null)
    {
        if( !is_null($key) )
        {
            $setmethod = 'set' . $key;
            $counter = $this->getMemberCounter();
            
            call_user_func(array($counter, $setmethod), 0);
            call_user_func(array($counter, 'save'));
        }
    }
    
    public function isStarred()
    {
        return $this->getIsStarred();
    }
    
    public function getMainPhoto()
    {
        if ( !is_null($this->getMainPhotoId()) )
        {
            return $this->getMemberPhoto();
        } else {
            $photo = new MemberPhoto();
            $photo->setMember($this);
            $photo->no_photo = true;
            return $photo;
        }
    }
    
    public function getGAddress()
    {
        $address_info[] = $this->getCity();
        //if( $this->getStateId() ) $address_info[] = $this->getState()->getISOCode();
        $address_info[] = $this->getCountry();
        
        return implode(', ', $address_info);
    }
    
    public function getAge()
    {
        list($b_Y, $b_m, $b_d) = explode('-', $this->getBirthday());
        list($now_Y, $now_m, $now_d) = explode('-', date('Y-m-d', time()));
        $age = $now_Y - $b_Y - 1;
        if( $now_m >= $b_m && $now_d >= $b_d ) 
        {
            $age++;
        }
        
        return $age;
    }
    
    public function getZodiac()
    {
        list($Y, $m, $d) = explode('-', $this->getBirthday());
        return new Zodiac($d, $m);
    }
    
    public function getYoutubeVidUrl()
    {
        return ($this->getYoutubeVid() ) ? 'http://www.youtube.com/watch?v=' . $this->getYoutubeVid() : null;
    }
    
    public function hasBlockFor($member_id)
    {
        $c = new Criteria();
        $c->add(BlockPeer::MEMBER_ID, $this->getId());
        $c->add(BlockPeer::PROFILE_ID, $member_id);
        
        $cnt = BlockPeer::doCount($c);
        
        return ( $cnt > 0) ? true : false;
    }
    
    public function mustFillIMBRA()
    {
        return ( is_null($this->getUsCitizen()) && $this->getCountry() == 'US' && !$this->getLastImbra() );
    }
    
    public function getNbUnreadMessages()
    {
        $c = new Criteria();
        $c->add(MessagePeer::TO_MEMBER_ID, $this->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $c->add(MessagePeer::IS_READ, false);
        
        return MessagePeer::doCount($c);
    }
    
    public function getNbSendMessagesToday()
    {
        $c = new Criteria();
        $c->add(MessagePeer::FROM_MEMBER_ID, $this->getId());
        $c->add(MessagePeer::SENT_BOX, true);
        $c->add(MessagePeer::CREATED_AT, 'DATE(' . MessagePeer::CREATED_AT .') = CURRENT_DATE()', Criteria::CUSTOM);
        
        return MessagePeer::doCount($c);        
    }
    
    public function updateMatches()
    {
        $connection = Propel::getConnection();
        $query = 'CALL update_matches(%d, %d)';
        $query = sprintf($query, $this->getId(), 21);
        $statement = $connection->prepareStatement($query);
        $statement->executeQuery();
        
        return true;
    }
    
    public function isLoggedIn()
    {
        $c = new Criteria();
        $c->add(SessionStoragePeer::USER_ID, $this->getId());
        $c->add(SessionStoragePeer::USER_ID, 0, Criteria::NOT_EQUAL);
        $nb_sessions = SessionStoragePeer::doCount($c);

        return ( $nb_sessions > 0 ) ? true : false;
    }
    
    public function killSession()
    {
        $c = new Criteria();
        $c->add(SessionStoragePeer::USER_ID, $this->getId());
        $c->add(SessionStoragePeer::USER_ID, 0, Criteria::NOT_EQUAL);
        $c->setLimit(1);
        SessionStoragePeer::doDelete($c);
    }
    
    public function getSearchCritDescsArray()
    {
        $ret = array();
        foreach ($this->getSearchCritDescs() as $desc)
        {
            $ret[$desc->getDescQuestionId()] = $desc;
        }
        
        return $ret;
    }
    
    public function clearSearchCriteria()
    {
        $c = new Criteria();
        $c->add(SearchCritDescPeer::MEMBER_ID, $this->getId());
        SearchCritDescPeer::doDelete($c);
    }
    
    public function hasSearchCriteria()
    {
        return ( $this->countSearchCritDescs() > 1 ) ? true : false; 
    }
    
    public function getFrontendProfileUrl()
    {
        return sfContext::getInstance()->getRequest()->getUriPrefix() . '/en/profile/' . $this->getUsername();
    }
    
    public function resetFlags()
    {
        //move non-trashed messages to trash mailbox
        $select = new Criteria();
        $select->add(FlagPeer::MEMBER_ID, $this->getId());
        $select->add(FlagPeer::IS_HISTORY, false);
        
        $update = new Criteria();
        $update->add(FlagPeer::IS_HISTORY, true);
        BasePeer::doUpdate($select, $update, Propel::getConnection());
        
        $this->clearCounter('CurrentFlags');
    }
}
