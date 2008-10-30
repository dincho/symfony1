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

    public function clearSearchCriteria()
    {
        if ($criteria = $this->getSearchCriteria())
        {
            $criteria->delete();
        }
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

    public function changeStatus($StatusId)
    {
        if ($this->getMemberStatusId() != $StatusId)
        {
            $history = new MemberStatusHistory();
            $history->setMemberStatusId($StatusId);
            $this->addMemberStatusHistory($history);
            $this->setMemberStatusId($StatusId);
            $this->setLastStatusChange(time());
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
    
    public function canSendMessageTo(BaseMember $profile)
    {
        if( false )
        {
            //1. is the other member active ?
            //2. has blocked this member ?
            //3. wants to receive messages only from paid members ?
            //4. is the subscription limit is out ?
            //5. is other member subscription accept messages ?
            
            return false;
        }
        
        return true;
    }

}
