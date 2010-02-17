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
  
    private $subscription_info = null;
    
    public function setPassword($v, $hash_it = true)
    {
        $new_val = ($hash_it) ? sha1(SALT . $v . SALT) : $v;
        parent::setPassword($new_val);
    }
    
    public function setNewPassword($v, $hash_it = true)
    {
        $new_val = ($hash_it) ? sha1(SALT . $v . SALT) : $v;
        parent::setNewPassword($new_val);
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

    public function setEssayHeadline($v)
    {
        $e = 'utf-8';
        $v = mb_strtolower($v, $e);
        $fc = mb_strtoupper(mb_substr($v, 0, 1, $e), $e);
        $v = $fc.mb_substr($v, 1, mb_strlen($v, $e), $e);

        parent::setEssayHeadline($v);
    }
        
    public function clearDescAnswers()
    {
        $select = new Criteria();
        $select->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());
        MemberDescAnswerPeer::doDelete($select);
    }

    public function initNewMember()
    {
        //some default values
        $this->setLastProfileView(time());
        $this->setLastHotlistView(time());
        $this->setLastWinksView(time());
        $this->setLastActivityNotification(time());
        $this->setEmailNotifications(0);
        
        //init member counter
        $counter = new MemberCounter();
        $counter->setHotlist(0); //just save to work, we need the ID.
        $counter->save();

        $this->setMemberCounter($counter);
    }
    
    public function parseLookingFor($var)
    {
        $sex_looking = explode('_', $var);
        $this->setSex($sex_looking[0]);
        $this->setLookingFor($sex_looking[1]);
    }
    
    public function getOrientation()
    {
        return $this->getSex() . '_' . $this->getLookingFor();
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
        if ($this->getMemberStatusId() != $StatusId )
        {
            if( ($this->getMemberStatusId() == MemberStatusPeer::PENDING ) && $StatusId == MemberStatusPeer::ACTIVE )
            {
                Events::triggerWelcomeApproved($this);
                $this->updateMatches();
            }
            
            $old_status_id = $this->getMemberStatusId();
            if( $old_status_id == MemberStatusPeer::SUSPENDED || 
                $old_status_id == MemberStatusPeer::SUSPENDED_FLAGS ||
                $old_status_id == MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED )
              {
                  $this->incCounter('unsuspensions');
              }
              
              //last history
              $c = new Criteria();
              $c->add(MemberStatusHistoryPeer::MEMBER_ID, $this->getId());
              $c->addDescendingOrderByColumn(MemberStatusHistoryPeer::ID);
              $c->setLimit(1);
              $last_history = MemberStatusHistoryPeer::doSelectOne($c);
              
              
            $history = new MemberStatusHistory();
            $history->setMemberStatusId($StatusId);
            $history->setFromStatusId($old_status_id);
            $history->setFromDate(($last_history) ? $last_history->getCreatedAt(null) : null);
            $this->addMemberStatusHistory($history);
            $this->setMemberStatusId($StatusId);
            $this->setLastStatusChange(time());
            
            if( $StatusId != MemberStatusPeer::DEACTIVATED && $old_status_id != MemberStatusPeer::DEACTIVATED && $kill_session ) $this->killSession();
        }
    }
    
    public function getLastSubscriptionHistory()
    {
        $c = new Criteria();
        $c->addDescendingOrderByColumn(SubscriptionHistoryPeer::ID);
        $c->add(SubscriptionHistoryPeer::MEMBER_ID, $this->getId());
        $c->setLimit(1);
        return SubscriptionHistoryPeer::doSelectOne($c);        
    }
    
    public function changeSubscription($subscription_id)
    {
        if ($this->getSubscriptionId() != $subscription_id )
        {
            $last_history = $this->getLastSubscriptionHistory();
            
            $history = new SubscriptionHistory();
            $history->setSubscriptionId($subscription_id);
            $history->setMemberStatusId($this->getMemberStatusId());
            $history->setFromDate(($last_history) ? $last_history->getCreatedAt(null) : null );

            $this->setSubscriptionId($subscription_id);
            $this->addSubscriptionHistory($history);
            $this->setLastSubscriptionChange(time());
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
    
    public function incCounter($key = null, $n = 1)
    {
        if( !is_null($key) )
        {
            $getmethod = 'get' . $key;
            $setmethod = 'set' . $key;
            
            $counter = $this->getMemberCounter();
            $new_val = $counter->$getmethod() + $n;
            
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
        if( $this->getAdm1Id() ) $address_info[] = $this->getAdm1()->getName();
        $address_info[] = $this->getCountry();
        
        return implode(', ', $address_info);
    }
    
    public function getAge()
    {
        return ( is_null($this->getBirthday()) ) ? null : Tools::getAgeFromDateString($this->getBirthday());
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

    public function hasInHotlist($member_id)
    {
        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $this->getId());
        $c->add(HotlistPeer::PROFILE_ID, $member_id);
        
        $cnt = HotlistPeer::doCount($c);
        
        return ( $cnt > 0) ? true : false;
    }
    
    public function hasWinkTo($member_id)
    {
        $c = new Criteria();
        $c->add(WinkPeer::MEMBER_ID, $this->getId());
        $c->add(WinkPeer::PROFILE_ID, $member_id);
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNULL);
        $c->add(WinkPeer::SENT_BOX, true);
        
        $cnt = WinkPeer::doCount($c);
        
        return ( $cnt > 0) ? true : false;
    }
    
    public function hasOpenPrivacyFor($profile_id)
    {
        $c = new Criteria();
        $c->add(OpenPrivacyPeer::MEMBER_ID, $this->getId());
        $c->add(OpenPrivacyPeer::PROFILE_ID, $profile_id);
        
        $cnt = OpenPrivacyPeer::doCount($c);
        
        return ( $cnt > 0) ? true : false;
    }
        
    public function mustFillIMBRA()
    {
        return ( !sfConfig::get('app_settings_imbra_disable') && is_null($this->getUsCitizen()) && $this->getCountry() == 'US' && !$this->getLastImbra() );
    }
    
    public function mustPayIMBRA()
    {
        return ( $this->getImbraPayment() != 'completed' && $this->getLastImbra() );
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
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->add(MessagePeer::SENDER_ID, $this->getId());
        $c->add(MessagePeer::CREATED_AT, 'DATE(' . MessagePeer::CREATED_AT .') = CURRENT_DATE()', Criteria::CUSTOM);
        $c->addJoin(MessagePeer::THREAD_ID, ThreadPeer::ID);
        $c->addGroupByColumn(ThreadPeer::ID);
        
        return ThreadPeer::doCount($c);
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
        $c->add(SessionStoragePeer::SESS_TIME, time()-sfConfig::get('sf_timeout'), Criteria::GREATER_THAN); //not timedout
        $logged_in = SessionStoragePeer::doCount($c);

        return ($logged_in > 0) ? true : false;
    }
    
    public function killSession()
    {
        $c = new Criteria();
        $crit = $c->getNewCriterion(SessionStoragePeer::USER_ID, $this->getId());
        $crit->addAnd($c->getNewCriterion(SessionStoragePeer::USER_ID, 0, Criteria::NOT_EQUAL));
        $c->add($crit);
        $c->setLimit(1);
        SessionStoragePeer::doDelete($c);
    }
    
    public function clearDroppedSessions($current_session_id)
    {
      $c = new Criteria();
      $crit = $c->getNewCriterion(SessionStoragePeer::USER_ID, $this->getId());
      $crit->addAnd($c->getNewCriterion(SessionStoragePeer::SESS_ID, $current_session_id, Criteria::NOT_EQUAL));
      $c->add($crit);
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
        return MemberPeer::getFrontendProfileUrl($this->getUsername());
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
    
    public function getMemberPhotos($count = null, $con = null)
    {
        $c = new Criteria();
        if( !is_null($count))
        {
            $c->setLimit($count);
        }
        
        return parent::getMemberPhotos($c, $con);
    }
    
    public function clearCounters()
    {
        $counter = $this->getMemberCounter();
        $counter->setSentWinks(0);
        $counter->setReadMessages(0);
        $counter->setReplyMessages(0);
        $counter->setSentMessages(0);
        $counter->setAssistantContacts(0);
        $counter->save();
    }

    public function getSubscriptionInfo()
    {
        if( !is_null($this->subscription_info) ) return $this->subscription_info; //cache
        
        $info = array('EOT' => null, 'NEXT_PAYMENT_DATE' => null, 'NEXT_PAYMENT_AMOUNT' => null);
        $c = new Criteria();
        $c->add(IpnHistoryPeer::SUBSCR_ID, $this->getLastPaypalSubscrId());
        $c->add(IpnHistoryPeer::TXN_TYPE, 'subscr_signup');
        $ipn_history = IpnHistoryPeer::doSelectOne($c);
        
        if( !$ipn_history ) 
        {
          $this->subscription_info = $info;
          return $info;
        }
        
        $subscribed_at = $ipn_history->getCreatedAt(null);
        
        $period_types_map = array('D' => 3, 'W' => 4, 'M' => 5, 'Y' => 7);
        $eot = new sfDate($subscribed_at);
        
        if( !is_null($ipn_history->getParam('period1')) )
        {
          list($period, $period_type) = explode(' ', $ipn_history->getParam('period1'));
          $period_type = $period_types_map[$period_type];
          $info['EOT'] =  $eot->add($period, $period_type); //period 1
          $info['NEXT_PAYMENT_AMOUNT'] = (float) $ipn_history->getParam('mc_amount1');
        }
        
        if( $eot->get() < time() ) //passed period 1, add period 2
        {
            if( !is_null($ipn_history->getParam('period2')) )
            {
              list($period, $period_type) = explode(' ', $ipn_history->getParam('period2'));
              $period_type = $period_types_map[$period_type];
              $info['EOT'] = $eot->add($period, $period_type); //period 2
              $info['NEXT_PAYMENT_AMOUNT'] = (float) $ipn_history->getParam('mc_amount2');
            }
            
            if ( $eot->get() < time() ) //period 3/normal
            {
                if( !is_null($ipn_history->getParam('period3')) )
                {
                  $eot = new sfDate($this->getLastPaypalPaymentAt(null));
                  list($period, $period_type) = explode(' ', $ipn_history->getParam('period3'));
                  $period_type = $period_types_map[$period_type];
                  $info['EOT'] = $eot->add($period, $period_type); //period 3
                  $info['NEXT_PAYMENT_AMOUNT'] = (float) $ipn_history->getParam('mc_amount3');
                }
            }
        }
        
        $this->subscription_info = $info;
        return $info;
    }
    
    public function getEotDate($object_return = false)
    {
      
        $info = $this->getSubscriptionInfo();
        return ($object_return) ? $info['EOT'] : $info['EOT']->get();
    }
    
    public function getNextPaymentDate()
    {
      return $eot = $this->getEotDate(true)->get();
    }
    
    public function getNextPaymentAmount()
    {
      $info = $this->getSubscriptionInfo();
      return $info['NEXT_PAYMENT_AMOUNT'];
    }
    
    public function getLastIP($long = false)
    {
        if( $long ) return parent::getLastIp();
        return (parent::getLastIp()) ? long2ip(parent::getLastIp()) : null;
    }
    
    public function getRegistrationIP($long = false)
    {
        if( $long ) return parent::getRegistrationIP();
        return (parent::getRegistrationIP()) ? long2ip(parent::getRegistrationIP()) : null;
    }
    
    public function getContinueRegistrationUrl()
    {
        if ( is_null($this->getOriginalFirstName()) ) //1. Step 1 - registration
        {
            $url = 'registration/index';
        } elseif (! $this->getBirthDay()) //2. Step 2 - self description 
        {
            $url = 'registration/selfDescription';
        } elseif (! $this->getEssayHeadline()) //3. Step - essay 
        {
            $url = 'registration/essay';
        } elseif ( is_null($this->getYoutubeVid()) ) //Step 4 - Photos
        {
            $url = 'registration/photos';
        }elseif ( $this->mustFillIMBRA() ) //Step 5 - IMBRA (if US citizen)
        {
            $url = 'IMBRA/index';
        } elseif ( $this->mustPayIMBRA()) //Step 6 - IMBRA payment (if US citizen)
        {
            $url = 'IMBRA/payment';
        } else {
            throw new sfException('Unknown registration step');
        }

        return $url;
    }
    
    public function isActive()
    {
        return ($this->getMemberStatusId() == MemberStatusPeer::ACTIVE);
    }
    
    public function getOrientationString()
    {   
        ( $this->getSex() == 'M' ) ? $orientation ='Man' : $orientation='Woman';
        $orientation.=" looking for ";
        ( $this->getLookingfor() == 'M' ) ? $orientation .='man' : $orientation .='woman';
        
        return $orientation;
    }
    
    /* Subscription shortcuts */
    public function isSubscriptionFree()
    {
        return ($this->getSubscriptionId() == SubscriptionPeer::FREE);
    }
    
    public function isSubscriptionPaid()
    {
        return ($this->getSubscriptionId() == SubscriptionPeer::PAID);
    }
    
    public function getAdm1()
    {
        $adm1 = GeoPeer::retrieveByPK($this->getAdm1Id());
        return $adm1;
    }
    
    public function getAdm2()
    {
        $adm2 = GeoPeer::retrieveByPK($this->getAdm2Id());
        return $adm2;
    }
    
    public function getCity()
    {
        $city = GeoPeer::retrieveByPK($this->getCityId());
        return $city;
    }
    
    public function clearCache()
    {
      // Clear the cache for actions related to this user
      $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
      $cache_dir = $sf_root_cache_dir.'/frontend/*/template/*/all';
      
      //for some reason the staging need one more * at the end
      //$cache_dir = $sf_root_cache_dir.'/frontend/*/template/*/all/*/';
      
      sfToolkit::clearGlob($cache_dir.'/*/*/profile/'.$this->getUsername() .'*'); //others views this 
      sfToolkit::clearGlob($cache_dir.'/*/myProfile*/content/_breadcrumb/'.$this->getId().'.cache'); //myProfile view
      sfToolkit::clearGlob($cache_dir.'/*/myProfile*/profile/_descMap/'.$this->getId().'.cache');
    }
    
    public function getCulture($default = 'en')
    {
      return in_array($this->getLanguage(), array('en', 'pl')) ? $this->getLanguage() : $default;
    }
    
    public function getRecentConversationWith(BaseMember $member)
    {
      $c = new Criteria();
      $crit = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $this->getId());
      $crit->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $member->getId()));
      $crit->addAnd($c->getNewCriterion(MessagePeer::SENT_BOX, true));
    
      $crit2 = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $member->getId());
      $crit2->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $this->getId()));
      $crit2->addAnd($c->getNewCriterion(MessagePeer::SENT_BOX, false));
    
      $c->add($crit);
      $c->addOr($crit2);
      $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
      $c->setLimit(sfConfig::get('app_settings_profile_num_recent_messages'));
      return MessagePeer::doSelect($c);
    }
    
    public function getMatchWith(BaseMember $member)
    {
      $c = new Criteria();
      $c->add(MemberMatchPeer::MEMBER1_ID, $member->getId());
      $c->add(MemberMatchPeer::MEMBER2_ID, $this->getId());
      return MemberMatchPeer::doSelectOne($c);
    }
    
    public function markOldWinksFrom(BaseMember $member)
    {
      $c1 = new Criteria();
      $c1->add(WinkPeer::PROFILE_ID, $this->getId());
      $c1->add(WinkPeer::MEMBER_ID, $member->getId());
      $c1->add(WinkPeer::SENT_BOX, false);
      $c1->add(WinkPeer::IS_NEW, true);
      
      $c2 = new Criteria();
      $c2->add(WinkPeer::IS_NEW, false);
      BasePeer::doUpdate($c1, $c2, Propel::getConnection(WinkPeer::DATABASE_NAME));
    }
    
    public function markOldHotlistFrom(BaseMember $member)
    {
      $c1 = new Criteria();
      $c1->add(HotlistPeer::PROFILE_ID, $this->getId());
      $c1->add(HotlistPeer::MEMBER_ID, $member->getId());
      $c1->add(HotlistPeer::IS_NEW, true);
      
      $c2 = new Criteria();
      $c2->add(HotlistPeer::IS_NEW, false);
      BasePeer::doUpdate($c1, $c2, Propel::getConnection(HotlistPeer::DATABASE_NAME));
    }
    
    public function markOldViewsFrom(BaseMember $member)
    {
      $c1 = new Criteria();
      $c1->add(ProfileViewPeer::PROFILE_ID, $this->getId());
      $c1->add(ProfileViewPeer::MEMBER_ID, $member->getId());
      $c1->add(ProfileViewPeer::IS_NEW, true);
      
      $c2 = new Criteria();
      $c2->add(ProfileViewPeer::IS_NEW, false);
      BasePeer::doUpdate($c1, $c2, Propel::getConnection(ProfileViewPeer::DATABASE_NAME));
    }
    
    public function addOpenPrivacyFor($profile_id)
    {
        if( !$this->hasOpenPrivacyFor($profile_id) )
        {
            $open = new OpenPrivacy();
            $open->setMemberId($this->getId());
            $open->setProfileId($profile_id);
            $open->save();
            
            return true;
        }
        
        return false;
    }
    
    public function addOpenPrivacyForIfNeeded($profile_id)
    {
        if( $this->getPrivateDating() )
        {
            return $this->addOpenPrivacyFor($profile_id);
        }
        
        return false;
    }
    
    public function getMostAccurateAreaInfoId()
    {
        if( $this->getCity()->getInfo() ) return $this->getCityId();
        if( $this->getAdm2Id() && $this->getAdm2()->getInfo() ) return $this->getAdm2Id();
        if( $this->getAdm1Id() && $this->getAdm1()->getInfo() ) return $this->getAdm1Id();
        
        $geo_country = GeoPeer::retrieveCountryByISO($this->getCountry());
        if( $geo_country && $geo_country->getInfo() ) return $geo_country->getId();
        
        //default no geo feature with info field
        return $this->getCityId();
    }
    
    public function getLastActivityWith($member_id)
    {
        if( !$member_id ) return array();
        
        $customObject = new CustomQueryObject();
        
        $sql = '(SELECT ms.sender_id AS member_id, "mailed" AS activity, UNIX_TIMESTAMP(ms.created_at) AS dtime, IF(ms.sender_deleted_at, NULL, ms.thread_id) AS action_id FROM message AS ms WHERE ms.type = 1 AND ms.sender_id = %MEMBER_ID% AND ms.recipient_id = %PROFILE_ID% )
                UNION
                (SELECT ms.sender_id, "mailed", UNIX_TIMESTAMP(ms.created_at), IF(ms.recipient_deleted_at, NULL, ms.thread_id) FROM message AS ms WHERE ms.type = 1 AND ms.sender_id = %PROFILE_ID% AND ms.recipient_id = %MEMBER_ID% )
                UNION
                (SELECT w.member_id, "winked", UNIX_TIMESTAMP(w.created_at), NULL FROM wink AS w WHERE ((w.member_id = %MEMBER_ID% AND w.profile_id = %PROFILE_ID%) OR (w.member_id = %PROFILE_ID% AND w.profile_id = %MEMBER_ID% )) AND w.sent_box = 1 )
                UNION
                (SELECT h.member_id, "hotlisted", UNIX_TIMESTAMP(h.created_at), NULL FROM hotlist AS h WHERE (h.member_id = %MEMBER_ID% AND h.profile_id = %PROFILE_ID%) OR (h.member_id = %PROFILE_ID% AND h.profile_id = %MEMBER_ID%) )
                UNION
                (SELECT v.member_id, "visited", UNIX_TIMESTAMP(v.updated_at), NULL FROM profile_view AS v WHERE (v.member_id = %MEMBER_ID% AND v.profile_id = %PROFILE_ID%) OR (v.member_id = %PROFILE_ID% AND v.profile_id = %MEMBER_ID%) )
                ORDER BY dtime DESC LIMIT %LIMIT%';
                
        $sql = strtr($sql, array('%MEMBER_ID%' => $member_id, '%PROFILE_ID%' => $this->getId(), '%LIMIT%' =>  sfConfig::get('app_settings_profile_num_recent_activities', 5))); 
                                
        $objects = $customObject->query($sql);
        return $objects;
    }
    
    public function retrieveThreadById($id)
    {
        $c  =  new Criteria();
        $c->add(ThreadPeer::ID, $id);
        
        $c->addJoin(ThreadPeer::ID, MessagePeer::THREAD_ID);
        $c->addGroupByColumn(ThreadPeer::ID);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
                
        $crit = $c->getNewCriterion(MessagePeer::RECIPIENT_ID, $this->getId());
        $crit->addAnd($c->getNewCriterion(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL));

        $crit2 = $c->getNewCriterion(MessagePeer::SENDER_ID, $this->getId());
        $crit2->addAnd($c->getNewCriterion(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL));
    
        $crit->addOr($crit2);
        $c->addAnd($crit);
        
        return ThreadPeer::doSelectOne($c);
    }
    
    public function getTimezone()
    {
        return ( $this->getCityId() ) ? $this->getCity()->getTimezone() : 'UTC';
    }
}
