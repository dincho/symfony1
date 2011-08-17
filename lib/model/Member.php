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
    
    //cache
    private $_unread_messages_count = null;
    
    private $_all_messages_count = null;
    
    private $city = null;
    
    private $_current_member_subscription = false;
    
    private $subscriptionDetails = null;
    
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
    
    public function setBirthday($val)
    {
        if( $val != $this->getBirthday() ) $this->setAge(Tools::getAgeFromDateString($val));
        return parent::setBirthday($val);
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
    

    public function setPurpose($v)
    {
        parent::setPurpose(serialize($v));
    }
    
    public function getPurpose()
    {
        return (parent::getPurpose()) ? unserialize(parent::getPurpose()) : array();
    }
    
    public function setLanguage($v)
    {
        if( $this->getLanguage() != $v && $this->getCatalogId() )
        {
            $current_catalog = $this->getCatalogue();
            
            //find out a catalog in the some domain with new language
            $c = new Criteria();
            $c->add(CataloguePeer::DOMAIN, $current_catalog->getDomain());
            $c->add(CataloguePeer::TARGET_LANG, $v);
            $new_catalog = CataloguePeer::doSelectOne($c);
            
            if( $new_catalog )
            {
                $this->setCatalogId($new_catalog->getCatId());
            } elseif( $current_catalog->getTargetLang() != 'en' ) //there is no catalog with this language in the domain, so set it to english catalog if not so
            {
                $c1 = clone $c;
                $c->add(CataloguePeer::TARGET_LANG, 'en');
                $en_catalog = CataloguePeer::doSelectOne($c);
                
                if( $en_catalog )
                {
                    $this->setCatalogId($en_catalog->getCatId());
                }
            }
        }
        
        parent::setLanguage($v);
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
            if( $StatusId == MemberStatusPeer::ACTIVE )
            {
                if( $this->getMemberStatusId() == MemberStatusPeer::PENDING ) Events::triggerWelcomeApproved($this);
                
                //non active members are excluded from matches
                //so regenerate the results
                $this->updateMatches();
                $this->updateReverseMatches();
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
            
            if( !in_array($StatusId, array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)) 
                && !in_array($old_status_id, array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)) && $kill_session ) $this->killSession();
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
    
    public function changeSubscription($subscription_id, $changed_by = 'unknown')
    {
        if ($this->getSubscriptionId() != $subscription_id )
        {
            $last_history = $this->getLastSubscriptionHistory();
            
            $history = new SubscriptionHistory();
            $history->setSubscriptionId($subscription_id);
            $history->setMemberStatusId($this->getMemberStatusId());
            $history->setFromDate(($last_history) ? $last_history->getCreatedAt(null) : null );
            $history->setChangedBy($changed_by);

            if($subscription_id == SubscriptionPeer::FREE)
            {
              $this->clearCounter('DeactivationCounter');
            }
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
    
    public function getNbSentMessages()
    {
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->add(MessagePeer::SENDER_ID, $this->getId());
        
        return MessagePeer::doCount($c);
    }
    
    public function getNbSentMessagesToday()
    {
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->add(MessagePeer::SENDER_ID, $this->getId());
        $c->add(MessagePeer::CREATED_AT, 'DATE(' . MessagePeer::CREATED_AT .') = CURRENT_DATE()', Criteria::CUSTOM);
        $c->addJoin(MessagePeer::THREAD_ID, ThreadPeer::ID);
        $c->addGroupByColumn(ThreadPeer::ID);
        
        return ThreadPeer::doCount($c);
    }
    
    // straight
    
    public function updateStraightMatches()
    {
        if( sfConfig::get('app_matches_use_queue') )
        {
            $gmc = new GearmanClient();
            $gmc->addServer('127.0.0.1', 4730);
            $handle = @$gmc->doBackground('MatchQueue_Straight', $this->getId());
            
            if ( $gmc->returnCode() == GEARMAN_SUCCESS )
            {
                return true;
            } else {
                if( sfConfig::get('app_matches_error_exception') ) throw new sfException("(MatchQueue_Straight) Unable to schedule gearman job!", $gmc->returnCode());
                return false;
            }
            
        } else {
            $connection = Propel::getConnection();
            $query = 'CALL update_straight_matches(%d, %d)';
            $query = sprintf($query, $this->getId(), sfConfig::get('app_matches_max_weight'));
            $statement = $connection->prepareStatement($query);
            $statement->executeQuery();
        }
        
        return true;
    }
    
    public function updateReverseMatches()
    {
        if( sfConfig::get('app_matches_use_queue') )
        {
            $gmc = new GearmanClient();
            $gmc->addServer('127.0.0.1', 4730);
            $handle = @$gmc->doBackground('MatchQueue_Reverse', $this->getId());
            
            if ( $gmc->returnCode() == GEARMAN_SUCCESS )
            {
                return true;
            } else {
                if( sfConfig::get('app_matches_error_exception') ) throw new sfException("(MatchQueue_Reverse) Unable to schedule gearman job!", $gmc->returnCode());
                return false;
            }
            
        } else {
            $connection = Propel::getConnection();
            $query = 'CALL update_reverse_matches(%d, %d)';
            $query = sprintf($query, $this->getId(), sfConfig::get('app_matches_max_weight'));
            $statement = $connection->prepareStatement($query);
            $statement->executeQuery();
        }

        return true;
    }
    
    public function updateMatches()
    {
        $this->updateStraightMatches();
        $this->updateReverseMatches();
    }
    
    // public function updateMatches()
    // {
    //     $connection = Propel::getConnection();
    //     $query = 'CALL update_matches(%d, %d)';
    //     $query = sprintf($query, $this->getId(), 21);
    //     $statement = $connection->prepareStatement($query);
    //     $statement->executeQuery();
    //     
    //     return true;
    // }
    
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
    
    public function getMemberPhotos($crit = null, $con = null, $count = null)
    {
        $c = ( is_null($crit) ) ? new Criteria() : $crit;
        $c->addAscendingOrderByColumn(MemberPhotoPeer::SORT_ORDER);
        $c->addAscendingOrderByColumn(MemberPhotoPeer::ID);
        
        if( !is_null($count))
        {
            $c->setLimit($count);
        }
        
        return parent::getMemberPhotos($c, $con);
    }
    
    public function getPublicMemberPhotos($crit = null, $con = null, $count = null)
    {
        $c = ( is_null($crit) ) ? new Criteria() : $crit;
        $c->add(MemberPhotoPeer::IS_PRIVATE, false);
        
        return self::getMemberPhotos($c, $con, $count);
    }
    
    public function getPrivateMemberPhotos($crit = null, $con = null, $count = null)
    {
        $c = ( is_null($crit) ) ? new Criteria() : $crit;
        $c->add(MemberPhotoPeer::IS_PRIVATE, true);
        
        return self::getMemberPhotos($c, $con, $count);
    }    
    
    public function countPublicMemberPhotos($crit = null, $con = null)
    {
        $c = ( is_null($crit) ) ? new Criteria() : $crit;
        $c->add(MemberPhotoPeer::IS_PRIVATE, false);
        
        return parent::countMemberPhotos($c, false, $con);
    }
    
    public function countPrivateMemberPhotos($crit = null, $con = null)
    {
        $c = ( is_null($crit) ) ? new Criteria() : $crit;
        $c->add(MemberPhotoPeer::IS_PRIVATE, true);
        
        return parent::countMemberPhotos($c, false, $con);
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
        return ($this->getSubscriptionId() != SubscriptionPeer::FREE);
    }
    
    public function getAdm1()
    {
      return ($this->getCity()) ? $this->getCity()->getGeoRelatedByAdm1Id() : null;
    }
    
    public function getAdm2()
    {
      return ($this->getCity()) ? $this->getCity()->getGeoRelatedByAdm2Id() : null;
    }
    
    public function getCityOld()
    {
      return GeoPeer::retrieveByPK($this->getCityId());
    }
    
    public function getCity()
    {
      if( !is_null($this->getCityId()) && is_null($this->city) )
      {
        $c = new Criteria();
        $c->add(GeoPeer::ID, $this->getCityId());
      
        $this->city = GeoPeer::doSelectOneJoinAllFeatures($c);
      }
      
      return $this->city;
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
      
      //non-culture containing urls
      sfToolkit::clearGlob($cache_dir.'/*/profile/'.$this->getUsername() .'*'); //others views this 
      sfToolkit::clearGlob($cache_dir.'/myProfile*/content/_breadcrumb/'.$this->getId().'.cache'); //myProfile view
      sfToolkit::clearGlob($cache_dir.'/myProfile*/profile/_descMap/'.$this->getId().'.cache');
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
    
    public function markOldProtoFrom(BaseMember $member)
    {
      $c1 = new Criteria();
      $c1->add(PrivatePhotoPermissionPeer::PROFILE_ID, $this->getId());
      $c1->add(PrivatePhotoPermissionPeer::MEMBER_ID, $member->getId());
      $c1->add(PrivatePhotoPermissionPeer::STATUS, 'A');
      $c1->add(PrivatePhotoPermissionPeer::TYPE, 'P');
      $c1->add(PrivatePhotoPermissionPeer::IS_NEW, true);
      
      $c2 = new Criteria();
      $c2->add(PrivatePhotoPermissionPeer::IS_NEW, false);
      BasePeer::doUpdate($c1, $c2, Propel::getConnection(PrivatePhotoPermissionPeer::DATABASE_NAME));
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
    
    public function getMostAccurateAreaInfo($catalog_id)
    {
        if( $details = $this->getCity()->getDetails($catalog_id) ) return $details;
        if( $this->getAdm2Id() && $details = $this->getAdm2()->getDetails($catalog_id) ) return $details;
        if( $this->getAdm1Id() && $details = $this->getAdm1()->getDetails($catalog_id) ) return $details;
        
        $geo_country = GeoPeer::retrieveCountryByISO($this->getCountry());
        if( $geo_country && $details = $geo_country->getDetails($catalog_id) ) return $details;
        
        //default no geo feature with info field
        return null;
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
    
    public function deleteHomepagePhotos()
    {
        $c = new Criteria();
        $c->add(HomepageMemberPhotoPeer::MEMBER_ID, $this->getId());
        $photos = HomepageMemberPhotoPeer::doSelect($c);
        
        foreach($photos as $photo) $photo->delete();
    }
    
    public function hasUnreadMessagesFromFreeFemales()
    {
        $c = new Criteria();
        $c->add(MessagePeer::RECIPIENT_ID, $this->getId());
        $c->add(MessagePeer::UNREAD, true);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->addJoin(MessagePeer::SENDER_ID, MemberPeer::ID);
        $c->add(MemberPeer::SEX, 'F');
        $c->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::FREE);
        
        return ( MessagePeer::doCount($c) > 0 );
    }
    
    public function getUnreadMessagesCriteria($crit = null)
    {
        $c = ( !is_null($crit) ) ? clone $crit : new Criteria();
        
        $c->add(MessagePeer::RECIPIENT_ID, $this->getId());
        $c->add(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->add(MessagePeer::UNREAD, true);
        $c->addGroupByColumn(MessagePeer::THREAD_ID);
        
        return $c;
    }
    
    public function getUnreadMessagesCount()
    {
        if( is_null($this->_unread_messages_count) )
        {
            $rs = MessagePeer::doSelectRS($this->getUnreadMessagesCriteria());
            $this->_unread_messages_count = $rs->getRecordCount();
        }
        
        return $this->_unread_messages_count;
    }
    
    public function getAllMessagesCriteria($crit = null)
    {
        $c = ( !is_null($crit) ) ? clone $crit : new Criteria();
        
        $c->add(MessagePeer::RECIPIENT_ID, $this->getId());
        $c->add(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->addGroupByColumn(MessagePeer::THREAD_ID);
        
        return $c;
    }
    
    public function getAllMessagesCount()
    {
        if( is_null($this->_all_messages_count) )
        {
            $rs = MessagePeer::doSelectRS($this->getAllMessagesCriteria());
            $this->_all_messages_count = $rs->getRecordCount();
        }
        
        return $this->_all_messages_count;
    }

    public function hasAuthPhoto()
    {
         $c = new Criteria();
         $c->add(MemberPhotoPeer::AUTH, 'A');
         $c->add(MemberPhotoPeer::MEMBER_ID, $this->getId());
         
         return (MemberPhotoPeer::doCount($c) > 0);
    }
    
    public function getCurrentMemberSubscription()
    {
      if( $this->_current_member_subscription === false )
      {
        $days = sfConfig::get('app_settings_extend_eot', 0);
      
        $c = new Criteria();
        $c->add(MemberSubscriptionPeer::MEMBER_ID, $this->getId());
        $c->add(MemberSubscriptionPeer::EOT_AT, 'DATE('.MemberSubscriptionPeer::EOT_AT . ' + INTERVAL ' . $days . ' DAY) >= CURDATE() AND CURDATE() >= DATE('.MemberSubscriptionPeer::EFFECTIVE_DATE.')', Criteria::CUSTOM);
        $c->add(MemberSubscriptionPeer::STATUS, array('active', 'canceled', 'failed'), Criteria::IN);
        $this->_current_member_subscription = MemberSubscriptionPeer::doSelectOne($c);
      }
      
      return $this->_current_member_subscription;
    }
    
    public function getLastEotAt()
    {
      $c = new Criteria();
      $c->addDescendingOrderByColumn(MemberSubscriptionPeer::EOT_AT);
      $ms =  MemberSubscriptionPeer::doSelectOne($c);
      
      return ($ms) ? $ms->getEotAt() : time();
    }
    
    public function getNextMemberSubscription()
    {
      if( $current_subscription = $this->getCurrentMemberSubscription() )
      {
        $c = new Criteria();
        $c->add(MemberSubscriptionPeer::MEMBER_ID, $this->getId());
        $c->add(MemberSubscriptionPeer::STATUS, array('confirmed', 'canceled'), Criteria::IN);
        $c->add(MemberSubscriptionPeer::EFFECTIVE_DATE, $current_subscription->getEffectiveDate(null), Criteria::GREATER_THAN);
        $c->addDescendingOrderByColumn(MemberSubscriptionPeer::EFFECTIVE_DATE);
        return MemberSubscriptionPeer::doSelectOne($c);
      }
      
      return null;
    }

    public function getMostRecentSubscription()
    {
        if( $next_member_subscription = $this->getNextMemberSubscription() )
        {
          $subscription_id = $next_member_subscription->getSubscriptionId();
        } elseif ( $current_member_subscription = $this->getCurrentMemberSubscription() )
        {
          $subscription_id = $current_member_subscription->getSubscriptionId();
        } else {
          $subscription_id = $this->getSubscriptionId();
        }
        
        return SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId($subscription_id, $this->getCatalogId());
    }
    
    public function getOrientationKey()
    {
      return $this->getSex().'4'.$this->getLookingFor();
    }
    
    public function isFree()
    {
      return ( $this->getSubscriptionId() == SubscriptionPeer::FREE );
    }
    
    //if you wonder why we need this method but not using !isFree(), 
    //it's just for better method calls wording
    public function isPaid()
    {
      return !$this->isFree();
    }

    public function getMemberRateWith(BaseMember $rater, $return_object = false)
    {
      $c = new Criteria();
      $c->add(MemberRatePeer::MEMBER_ID, $this->getId());
      $c->addAnd(MemberRatePeer::RATER_ID, $rater->getId());
      $memberRate = MemberRatePeer::doSelectOne($c);
      
      if( $return_object ) return $memberRate;
      
      return ($memberRate) ? $memberRate->getRate() : 0;
    }
    
    public function hasPrivatePhotosPermsFor(BaseMember $member)
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $member->getId());
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'A');
        
        return (bool) PrivatePhotoPermissionPeer::doCount($c);
    }

    public function hasGrantedOpenPrivacyPermsFor(BaseMember $member)
    {
        $c = new Criteria();
        $c->add(OpenPrivacyPeer::MEMBER_ID, $this->getId());
        $c->add(OpenPrivacyPeer::PROFILE_ID, $member->getId());
        
        return (bool) OpenPrivacyPeer::doCount($c);
    }

    public function openPrivacyPermsCount()
    {
        $c = new Criteria();
        $c->add(OpenPrivacyPeer::MEMBER_ID, $this->getId());
        
        return OpenPrivacyPeer::doCount($c);
    }
    
    public function getTop5PrivacyPermsProfiles()
    {
        $c = new Criteria();
        $c->add(OpenPrivacyPeer::MEMBER_ID, $this->getId());
        $c->addJoin(MemberPeer::ID, OpenPrivacyPeer::PROFILE_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addDescendingOrderByColumn(OpenPrivacyPeer::CREATED_AT);
        $c->setLimit(5);

        return MemberPeer::doSelectJoinMemberPhoto($c);
    }

    public function hasGrantPrivatePhotosPermsFor(BaseMember $member)
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $member->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'A');
        
        return (bool) PrivatePhotoPermissionPeer::doCount($c);
    }
    
    public function hasPrivatePhotoRequestTo(BaseMember $member)
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $member->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'R');
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'R');
        
        return (bool) PrivatePhotoPermissionPeer::doCount($c);
    }
    
    public function getNumberOfTodaysPrivatePhotoRequest()
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'R');
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'R');
        $c->add(PrivatePhotoPermissionPeer::UPDATED_AT, 'DATE('.PrivatePhotoPermissionPeer::UPDATED_AT.') = DATE(CURDATE())', Criteria::CUSTOM) ;
        
        return PrivatePhotoPermissionPeer::doCount($c);
    }
    
    public function getPrivatePhotoAccessGiven()
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        
        return PrivatePhotoPermissionPeer::doCount($c);    
    }

    public function getPrivatePhotoAccessReceived()
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        
        return PrivatePhotoPermissionPeer::doCount($c);    
    }

    public function getPrivatePhotoRequestReceived()
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'R');
        
        return PrivatePhotoPermissionPeer::doCount($c);    
    }

    public function getPrivatePhotoRequestSent()
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $this->getId());
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'R');
        
        return PrivatePhotoPermissionPeer::doCount($c);    
    }

    public function getSubscriptionDetails()
    {
        if( is_null($this->subscriptionDetails) )
        {
            $this->subscriptionDetails = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId($this->getSubscriptionId(), $this->getCatalogId());
        } 
        
        return $this->subscriptionDetails;
    }
    
    public function changeCatalog($catalog_id)
    {
        if( $this->getCatalogId() != $catalog_id )
        {
            $this->setCatalogId($catalog_id);
            $this->killSession();
            $this->updateMatches();
        }
    }

    public function IsFlaggedBy($flagger_id)
    {
        $c = new Criteria();
        $c->add(FlagPeer::FLAGGER_ID, $flagger_id);
        $c->add(FlagPeer::MEMBER_ID, $this->getId());

        return (bool) FlagPeer::doCount($c);
    }

    public function getUnreadFeedback()
    {
        $c = new Criteria();
        $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX);
        $c->add(FeedbackPeer::IS_READ, 0);
        $c->add(FeedbackPeer::MEMBER_ID, $this->getId());

        return FeedbackPeer::doCount($c);
    }
    
    public function getAllFeedback()
    {
        $c = new Criteria();
        $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX . ', ' . FeedbackPeer::SENT , Criteria::IN);
        $c->add(FeedbackPeer::MEMBER_ID, $this->getId());

        return FeedbackPeer::doCount($c);
    }

}
