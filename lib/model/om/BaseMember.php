<?php


abstract class BaseMember extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_status_id;


	
	protected $username;


	
	protected $password;


	
	protected $new_password;


	
	protected $must_change_pwd = false;


	
	protected $first_name;


	
	protected $last_name;


	
	protected $email;


	
	protected $tmp_email;


	
	protected $confirmed_email;


	
	protected $sex;


	
	protected $looking_for;


	
	protected $reviewed_by_id;


	
	protected $reviewed_at;


	
	protected $is_starred = false;


	
	protected $country;


	
	protected $state_id;


	
	protected $district;


	
	protected $city;


	
	protected $zip;


	
	protected $nationality;


	
	protected $language;


	
	protected $birthday;


	
	protected $dont_display_zodiac = false;


	
	protected $us_citizen = true;


	
	protected $email_notifications = 0;


	
	protected $dont_use_photos = false;


	
	protected $contact_only_full_members = false;


	
	protected $youtube_vid;


	
	protected $essay_headline;


	
	protected $essay_introduction;


	
	protected $search_criteria_id;


	
	protected $subscription_id;


	
	protected $sub_auto_renew = true;


	
	protected $member_counter_id;


	
	protected $last_activity;


	
	protected $last_status_change;


	
	protected $last_flagged;


	
	protected $last_login;


	
	protected $created_at;

	
	protected $aMemberStatus;

	
	protected $aUser;

	
	protected $aState;

	
	protected $aSearchCriteria;

	
	protected $aSubscription;

	
	protected $aMemberCounter;

	
	protected $collMemberNotes;

	
	protected $lastMemberNoteCriteria = null;

	
	protected $collMemberDescAnswers;

	
	protected $lastMemberDescAnswerCriteria = null;

	
	protected $collMemberPhotos;

	
	protected $lastMemberPhotoCriteria = null;

	
	protected $collMemberImbras;

	
	protected $lastMemberImbraCriteria = null;

	
	protected $collProfileViewsRelatedByMemberId;

	
	protected $lastProfileViewRelatedByMemberIdCriteria = null;

	
	protected $collProfileViewsRelatedByProfileId;

	
	protected $lastProfileViewRelatedByProfileIdCriteria = null;

	
	protected $collBlocksRelatedByMemberId;

	
	protected $lastBlockRelatedByMemberIdCriteria = null;

	
	protected $collBlocksRelatedByProfileId;

	
	protected $lastBlockRelatedByProfileIdCriteria = null;

	
	protected $collSubscriptionHistorys;

	
	protected $lastSubscriptionHistoryCriteria = null;

	
	protected $collMemberStatusHistorys;

	
	protected $lastMemberStatusHistoryCriteria = null;

	
	protected $collMessagesRelatedByFromMemberId;

	
	protected $lastMessageRelatedByFromMemberIdCriteria = null;

	
	protected $collMessagesRelatedByToMemberId;

	
	protected $lastMessageRelatedByToMemberIdCriteria = null;

	
	protected $collHotlistsRelatedByMemberId;

	
	protected $lastHotlistRelatedByMemberIdCriteria = null;

	
	protected $collHotlistsRelatedByProfileId;

	
	protected $lastHotlistRelatedByProfileIdCriteria = null;

	
	protected $collWinksRelatedByMemberId;

	
	protected $lastWinkRelatedByMemberIdCriteria = null;

	
	protected $collWinksRelatedByProfileId;

	
	protected $lastWinkRelatedByProfileIdCriteria = null;

	
	protected $collFeedbacks;

	
	protected $lastFeedbackCriteria = null;

	
	protected $collFlagsRelatedByMemberId;

	
	protected $lastFlagRelatedByMemberIdCriteria = null;

	
	protected $collFlagsRelatedByFlaggerId;

	
	protected $lastFlagRelatedByFlaggerIdCriteria = null;

	
	protected $collSuspendedByFlags;

	
	protected $lastSuspendedByFlagCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMemberStatusId()
	{

		return $this->member_status_id;
	}

	
	public function getUsername()
	{

		return $this->username;
	}

	
	public function getPassword()
	{

		return $this->password;
	}

	
	public function getNewPassword()
	{

		return $this->new_password;
	}

	
	public function getMustChangePwd()
	{

		return $this->must_change_pwd;
	}

	
	public function getFirstName()
	{

		return $this->first_name;
	}

	
	public function getLastName()
	{

		return $this->last_name;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getTmpEmail()
	{

		return $this->tmp_email;
	}

	
	public function getConfirmedEmail()
	{

		return $this->confirmed_email;
	}

	
	public function getSex()
	{

		return $this->sex;
	}

	
	public function getLookingFor()
	{

		return $this->looking_for;
	}

	
	public function getReviewedById()
	{

		return $this->reviewed_by_id;
	}

	
	public function getReviewedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->reviewed_at === null || $this->reviewed_at === '') {
			return null;
		} elseif (!is_int($this->reviewed_at)) {
						$ts = strtotime($this->reviewed_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [reviewed_at] as date/time value: " . var_export($this->reviewed_at, true));
			}
		} else {
			$ts = $this->reviewed_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getIsStarred()
	{

		return $this->is_starred;
	}

	
	public function getCountry()
	{

		return $this->country;
	}

	
	public function getStateId()
	{

		return $this->state_id;
	}

	
	public function getDistrict()
	{

		return $this->district;
	}

	
	public function getCity()
	{

		return $this->city;
	}

	
	public function getZip()
	{

		return $this->zip;
	}

	
	public function getNationality()
	{

		return $this->nationality;
	}

	
	public function getLanguage()
	{

		return $this->language;
	}

	
	public function getBirthday()
	{

		return $this->birthday;
	}

	
	public function getDontDisplayZodiac()
	{

		return $this->dont_display_zodiac;
	}

	
	public function getUsCitizen()
	{

		return $this->us_citizen;
	}

	
	public function getEmailNotifications()
	{

		return $this->email_notifications;
	}

	
	public function getDontUsePhotos()
	{

		return $this->dont_use_photos;
	}

	
	public function getContactOnlyFullMembers()
	{

		return $this->contact_only_full_members;
	}

	
	public function getYoutubeVid()
	{

		return $this->youtube_vid;
	}

	
	public function getEssayHeadline()
	{

		return $this->essay_headline;
	}

	
	public function getEssayIntroduction()
	{

		return $this->essay_introduction;
	}

	
	public function getSearchCriteriaId()
	{

		return $this->search_criteria_id;
	}

	
	public function getSubscriptionId()
	{

		return $this->subscription_id;
	}

	
	public function getSubAutoRenew()
	{

		return $this->sub_auto_renew;
	}

	
	public function getMemberCounterId()
	{

		return $this->member_counter_id;
	}

	
	public function getLastActivity($format = 'Y-m-d H:i:s')
	{

		if ($this->last_activity === null || $this->last_activity === '') {
			return null;
		} elseif (!is_int($this->last_activity)) {
						$ts = strtotime($this->last_activity);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_activity] as date/time value: " . var_export($this->last_activity, true));
			}
		} else {
			$ts = $this->last_activity;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLastStatusChange($format = 'Y-m-d H:i:s')
	{

		if ($this->last_status_change === null || $this->last_status_change === '') {
			return null;
		} elseif (!is_int($this->last_status_change)) {
						$ts = strtotime($this->last_status_change);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_status_change] as date/time value: " . var_export($this->last_status_change, true));
			}
		} else {
			$ts = $this->last_status_change;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLastFlagged($format = 'Y-m-d H:i:s')
	{

		if ($this->last_flagged === null || $this->last_flagged === '') {
			return null;
		} elseif (!is_int($this->last_flagged)) {
						$ts = strtotime($this->last_flagged);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_flagged] as date/time value: " . var_export($this->last_flagged, true));
			}
		} else {
			$ts = $this->last_flagged;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{

		if ($this->last_login === null || $this->last_login === '') {
			return null;
		} elseif (!is_int($this->last_login)) {
						$ts = strtotime($this->last_login);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_login] as date/time value: " . var_export($this->last_login, true));
			}
		} else {
			$ts = $this->last_login;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberPeer::ID;
		}

	} 
	
	public function setMemberStatusId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_status_id !== $v) {
			$this->member_status_id = $v;
			$this->modifiedColumns[] = MemberPeer::MEMBER_STATUS_ID;
		}

		if ($this->aMemberStatus !== null && $this->aMemberStatus->getId() !== $v) {
			$this->aMemberStatus = null;
		}

	} 
	
	public function setUsername($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = MemberPeer::USERNAME;
		}

	} 
	
	public function setPassword($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = MemberPeer::PASSWORD;
		}

	} 
	
	public function setNewPassword($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->new_password !== $v) {
			$this->new_password = $v;
			$this->modifiedColumns[] = MemberPeer::NEW_PASSWORD;
		}

	} 
	
	public function setMustChangePwd($v)
	{

		if ($this->must_change_pwd !== $v || $v === false) {
			$this->must_change_pwd = $v;
			$this->modifiedColumns[] = MemberPeer::MUST_CHANGE_PWD;
		}

	} 
	
	public function setFirstName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->first_name !== $v) {
			$this->first_name = $v;
			$this->modifiedColumns[] = MemberPeer::FIRST_NAME;
		}

	} 
	
	public function setLastName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->last_name !== $v) {
			$this->last_name = $v;
			$this->modifiedColumns[] = MemberPeer::LAST_NAME;
		}

	} 
	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = MemberPeer::EMAIL;
		}

	} 
	
	public function setTmpEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tmp_email !== $v) {
			$this->tmp_email = $v;
			$this->modifiedColumns[] = MemberPeer::TMP_EMAIL;
		}

	} 
	
	public function setConfirmedEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->confirmed_email !== $v) {
			$this->confirmed_email = $v;
			$this->modifiedColumns[] = MemberPeer::CONFIRMED_EMAIL;
		}

	} 
	
	public function setSex($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sex !== $v) {
			$this->sex = $v;
			$this->modifiedColumns[] = MemberPeer::SEX;
		}

	} 
	
	public function setLookingFor($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->looking_for !== $v) {
			$this->looking_for = $v;
			$this->modifiedColumns[] = MemberPeer::LOOKING_FOR;
		}

	} 
	
	public function setReviewedById($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reviewed_by_id !== $v) {
			$this->reviewed_by_id = $v;
			$this->modifiedColumns[] = MemberPeer::REVIEWED_BY_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

	} 
	
	public function setReviewedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [reviewed_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->reviewed_at !== $ts) {
			$this->reviewed_at = $ts;
			$this->modifiedColumns[] = MemberPeer::REVIEWED_AT;
		}

	} 
	
	public function setIsStarred($v)
	{

		if ($this->is_starred !== $v || $v === false) {
			$this->is_starred = $v;
			$this->modifiedColumns[] = MemberPeer::IS_STARRED;
		}

	} 
	
	public function setCountry($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->country !== $v) {
			$this->country = $v;
			$this->modifiedColumns[] = MemberPeer::COUNTRY;
		}

	} 
	
	public function setStateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->state_id !== $v) {
			$this->state_id = $v;
			$this->modifiedColumns[] = MemberPeer::STATE_ID;
		}

		if ($this->aState !== null && $this->aState->getId() !== $v) {
			$this->aState = null;
		}

	} 
	
	public function setDistrict($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->district !== $v) {
			$this->district = $v;
			$this->modifiedColumns[] = MemberPeer::DISTRICT;
		}

	} 
	
	public function setCity($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->city !== $v) {
			$this->city = $v;
			$this->modifiedColumns[] = MemberPeer::CITY;
		}

	} 
	
	public function setZip($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->zip !== $v) {
			$this->zip = $v;
			$this->modifiedColumns[] = MemberPeer::ZIP;
		}

	} 
	
	public function setNationality($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nationality !== $v) {
			$this->nationality = $v;
			$this->modifiedColumns[] = MemberPeer::NATIONALITY;
		}

	} 
	
	public function setLanguage($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->language !== $v) {
			$this->language = $v;
			$this->modifiedColumns[] = MemberPeer::LANGUAGE;
		}

	} 
	
	public function setBirthday($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->birthday !== $v) {
			$this->birthday = $v;
			$this->modifiedColumns[] = MemberPeer::BIRTHDAY;
		}

	} 
	
	public function setDontDisplayZodiac($v)
	{

		if ($this->dont_display_zodiac !== $v || $v === false) {
			$this->dont_display_zodiac = $v;
			$this->modifiedColumns[] = MemberPeer::DONT_DISPLAY_ZODIAC;
		}

	} 
	
	public function setUsCitizen($v)
	{

		if ($this->us_citizen !== $v || $v === true) {
			$this->us_citizen = $v;
			$this->modifiedColumns[] = MemberPeer::US_CITIZEN;
		}

	} 
	
	public function setEmailNotifications($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->email_notifications !== $v || $v === 0) {
			$this->email_notifications = $v;
			$this->modifiedColumns[] = MemberPeer::EMAIL_NOTIFICATIONS;
		}

	} 
	
	public function setDontUsePhotos($v)
	{

		if ($this->dont_use_photos !== $v || $v === false) {
			$this->dont_use_photos = $v;
			$this->modifiedColumns[] = MemberPeer::DONT_USE_PHOTOS;
		}

	} 
	
	public function setContactOnlyFullMembers($v)
	{

		if ($this->contact_only_full_members !== $v || $v === false) {
			$this->contact_only_full_members = $v;
			$this->modifiedColumns[] = MemberPeer::CONTACT_ONLY_FULL_MEMBERS;
		}

	} 
	
	public function setYoutubeVid($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->youtube_vid !== $v) {
			$this->youtube_vid = $v;
			$this->modifiedColumns[] = MemberPeer::YOUTUBE_VID;
		}

	} 
	
	public function setEssayHeadline($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->essay_headline !== $v) {
			$this->essay_headline = $v;
			$this->modifiedColumns[] = MemberPeer::ESSAY_HEADLINE;
		}

	} 
	
	public function setEssayIntroduction($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->essay_introduction !== $v) {
			$this->essay_introduction = $v;
			$this->modifiedColumns[] = MemberPeer::ESSAY_INTRODUCTION;
		}

	} 
	
	public function setSearchCriteriaId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->search_criteria_id !== $v) {
			$this->search_criteria_id = $v;
			$this->modifiedColumns[] = MemberPeer::SEARCH_CRITERIA_ID;
		}

		if ($this->aSearchCriteria !== null && $this->aSearchCriteria->getId() !== $v) {
			$this->aSearchCriteria = null;
		}

	} 
	
	public function setSubscriptionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->subscription_id !== $v) {
			$this->subscription_id = $v;
			$this->modifiedColumns[] = MemberPeer::SUBSCRIPTION_ID;
		}

		if ($this->aSubscription !== null && $this->aSubscription->getId() !== $v) {
			$this->aSubscription = null;
		}

	} 
	
	public function setSubAutoRenew($v)
	{

		if ($this->sub_auto_renew !== $v || $v === true) {
			$this->sub_auto_renew = $v;
			$this->modifiedColumns[] = MemberPeer::SUB_AUTO_RENEW;
		}

	} 
	
	public function setMemberCounterId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_counter_id !== $v) {
			$this->member_counter_id = $v;
			$this->modifiedColumns[] = MemberPeer::MEMBER_COUNTER_ID;
		}

		if ($this->aMemberCounter !== null && $this->aMemberCounter->getId() !== $v) {
			$this->aMemberCounter = null;
		}

	} 
	
	public function setLastActivity($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_activity] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_activity !== $ts) {
			$this->last_activity = $ts;
			$this->modifiedColumns[] = MemberPeer::LAST_ACTIVITY;
		}

	} 
	
	public function setLastStatusChange($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_status_change] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_status_change !== $ts) {
			$this->last_status_change = $ts;
			$this->modifiedColumns[] = MemberPeer::LAST_STATUS_CHANGE;
		}

	} 
	
	public function setLastFlagged($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_flagged] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_flagged !== $ts) {
			$this->last_flagged = $ts;
			$this->modifiedColumns[] = MemberPeer::LAST_FLAGGED;
		}

	} 
	
	public function setLastLogin($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_login] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_login !== $ts) {
			$this->last_login = $ts;
			$this->modifiedColumns[] = MemberPeer::LAST_LOGIN;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = MemberPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_status_id = $rs->getInt($startcol + 1);

			$this->username = $rs->getString($startcol + 2);

			$this->password = $rs->getString($startcol + 3);

			$this->new_password = $rs->getString($startcol + 4);

			$this->must_change_pwd = $rs->getBoolean($startcol + 5);

			$this->first_name = $rs->getString($startcol + 6);

			$this->last_name = $rs->getString($startcol + 7);

			$this->email = $rs->getString($startcol + 8);

			$this->tmp_email = $rs->getString($startcol + 9);

			$this->confirmed_email = $rs->getString($startcol + 10);

			$this->sex = $rs->getString($startcol + 11);

			$this->looking_for = $rs->getString($startcol + 12);

			$this->reviewed_by_id = $rs->getInt($startcol + 13);

			$this->reviewed_at = $rs->getTimestamp($startcol + 14, null);

			$this->is_starred = $rs->getBoolean($startcol + 15);

			$this->country = $rs->getString($startcol + 16);

			$this->state_id = $rs->getInt($startcol + 17);

			$this->district = $rs->getString($startcol + 18);

			$this->city = $rs->getString($startcol + 19);

			$this->zip = $rs->getInt($startcol + 20);

			$this->nationality = $rs->getString($startcol + 21);

			$this->language = $rs->getString($startcol + 22);

			$this->birthday = $rs->getString($startcol + 23);

			$this->dont_display_zodiac = $rs->getBoolean($startcol + 24);

			$this->us_citizen = $rs->getBoolean($startcol + 25);

			$this->email_notifications = $rs->getInt($startcol + 26);

			$this->dont_use_photos = $rs->getBoolean($startcol + 27);

			$this->contact_only_full_members = $rs->getBoolean($startcol + 28);

			$this->youtube_vid = $rs->getString($startcol + 29);

			$this->essay_headline = $rs->getString($startcol + 30);

			$this->essay_introduction = $rs->getString($startcol + 31);

			$this->search_criteria_id = $rs->getInt($startcol + 32);

			$this->subscription_id = $rs->getInt($startcol + 33);

			$this->sub_auto_renew = $rs->getBoolean($startcol + 34);

			$this->member_counter_id = $rs->getInt($startcol + 35);

			$this->last_activity = $rs->getTimestamp($startcol + 36, null);

			$this->last_status_change = $rs->getTimestamp($startcol + 37, null);

			$this->last_flagged = $rs->getTimestamp($startcol + 38, null);

			$this->last_login = $rs->getTimestamp($startcol + 39, null);

			$this->created_at = $rs->getTimestamp($startcol + 40, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 41; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Member object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMember:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MemberPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMember:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMember:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(MemberPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MemberPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMember:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aMemberStatus !== null) {
				if ($this->aMemberStatus->isModified()) {
					$affectedRows += $this->aMemberStatus->save($con);
				}
				$this->setMemberStatus($this->aMemberStatus);
			}

			if ($this->aUser !== null) {
				if ($this->aUser->isModified()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}

			if ($this->aState !== null) {
				if ($this->aState->isModified()) {
					$affectedRows += $this->aState->save($con);
				}
				$this->setState($this->aState);
			}

			if ($this->aSearchCriteria !== null) {
				if ($this->aSearchCriteria->isModified()) {
					$affectedRows += $this->aSearchCriteria->save($con);
				}
				$this->setSearchCriteria($this->aSearchCriteria);
			}

			if ($this->aSubscription !== null) {
				if ($this->aSubscription->isModified()) {
					$affectedRows += $this->aSubscription->save($con);
				}
				$this->setSubscription($this->aSubscription);
			}

			if ($this->aMemberCounter !== null) {
				if ($this->aMemberCounter->isModified()) {
					$affectedRows += $this->aMemberCounter->save($con);
				}
				$this->setMemberCounter($this->aMemberCounter);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MemberPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMemberNotes !== null) {
				foreach($this->collMemberNotes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberDescAnswers !== null) {
				foreach($this->collMemberDescAnswers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberPhotos !== null) {
				foreach($this->collMemberPhotos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberImbras !== null) {
				foreach($this->collMemberImbras as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProfileViewsRelatedByMemberId !== null) {
				foreach($this->collProfileViewsRelatedByMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProfileViewsRelatedByProfileId !== null) {
				foreach($this->collProfileViewsRelatedByProfileId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlocksRelatedByMemberId !== null) {
				foreach($this->collBlocksRelatedByMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlocksRelatedByProfileId !== null) {
				foreach($this->collBlocksRelatedByProfileId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSubscriptionHistorys !== null) {
				foreach($this->collSubscriptionHistorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberStatusHistorys !== null) {
				foreach($this->collMemberStatusHistorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMessagesRelatedByFromMemberId !== null) {
				foreach($this->collMessagesRelatedByFromMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMessagesRelatedByToMemberId !== null) {
				foreach($this->collMessagesRelatedByToMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collHotlistsRelatedByMemberId !== null) {
				foreach($this->collHotlistsRelatedByMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collHotlistsRelatedByProfileId !== null) {
				foreach($this->collHotlistsRelatedByProfileId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collWinksRelatedByMemberId !== null) {
				foreach($this->collWinksRelatedByMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collWinksRelatedByProfileId !== null) {
				foreach($this->collWinksRelatedByProfileId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collFeedbacks !== null) {
				foreach($this->collFeedbacks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collFlagsRelatedByMemberId !== null) {
				foreach($this->collFlagsRelatedByMemberId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collFlagsRelatedByFlaggerId !== null) {
				foreach($this->collFlagsRelatedByFlaggerId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSuspendedByFlags !== null) {
				foreach($this->collSuspendedByFlags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aMemberStatus !== null) {
				if (!$this->aMemberStatus->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberStatus->getValidationFailures());
				}
			}

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}

			if ($this->aState !== null) {
				if (!$this->aState->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aState->getValidationFailures());
				}
			}

			if ($this->aSearchCriteria !== null) {
				if (!$this->aSearchCriteria->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSearchCriteria->getValidationFailures());
				}
			}

			if ($this->aSubscription !== null) {
				if (!$this->aSubscription->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSubscription->getValidationFailures());
				}
			}

			if ($this->aMemberCounter !== null) {
				if (!$this->aMemberCounter->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberCounter->getValidationFailures());
				}
			}


			if (($retval = MemberPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMemberNotes !== null) {
					foreach($this->collMemberNotes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberDescAnswers !== null) {
					foreach($this->collMemberDescAnswers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberPhotos !== null) {
					foreach($this->collMemberPhotos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberImbras !== null) {
					foreach($this->collMemberImbras as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProfileViewsRelatedByMemberId !== null) {
					foreach($this->collProfileViewsRelatedByMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProfileViewsRelatedByProfileId !== null) {
					foreach($this->collProfileViewsRelatedByProfileId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlocksRelatedByMemberId !== null) {
					foreach($this->collBlocksRelatedByMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlocksRelatedByProfileId !== null) {
					foreach($this->collBlocksRelatedByProfileId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSubscriptionHistorys !== null) {
					foreach($this->collSubscriptionHistorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberStatusHistorys !== null) {
					foreach($this->collMemberStatusHistorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMessagesRelatedByFromMemberId !== null) {
					foreach($this->collMessagesRelatedByFromMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMessagesRelatedByToMemberId !== null) {
					foreach($this->collMessagesRelatedByToMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collHotlistsRelatedByMemberId !== null) {
					foreach($this->collHotlistsRelatedByMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collHotlistsRelatedByProfileId !== null) {
					foreach($this->collHotlistsRelatedByProfileId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collWinksRelatedByMemberId !== null) {
					foreach($this->collWinksRelatedByMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collWinksRelatedByProfileId !== null) {
					foreach($this->collWinksRelatedByProfileId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collFeedbacks !== null) {
					foreach($this->collFeedbacks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collFlagsRelatedByMemberId !== null) {
					foreach($this->collFlagsRelatedByMemberId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collFlagsRelatedByFlaggerId !== null) {
					foreach($this->collFlagsRelatedByFlaggerId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSuspendedByFlags !== null) {
					foreach($this->collSuspendedByFlags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMemberStatusId();
				break;
			case 2:
				return $this->getUsername();
				break;
			case 3:
				return $this->getPassword();
				break;
			case 4:
				return $this->getNewPassword();
				break;
			case 5:
				return $this->getMustChangePwd();
				break;
			case 6:
				return $this->getFirstName();
				break;
			case 7:
				return $this->getLastName();
				break;
			case 8:
				return $this->getEmail();
				break;
			case 9:
				return $this->getTmpEmail();
				break;
			case 10:
				return $this->getConfirmedEmail();
				break;
			case 11:
				return $this->getSex();
				break;
			case 12:
				return $this->getLookingFor();
				break;
			case 13:
				return $this->getReviewedById();
				break;
			case 14:
				return $this->getReviewedAt();
				break;
			case 15:
				return $this->getIsStarred();
				break;
			case 16:
				return $this->getCountry();
				break;
			case 17:
				return $this->getStateId();
				break;
			case 18:
				return $this->getDistrict();
				break;
			case 19:
				return $this->getCity();
				break;
			case 20:
				return $this->getZip();
				break;
			case 21:
				return $this->getNationality();
				break;
			case 22:
				return $this->getLanguage();
				break;
			case 23:
				return $this->getBirthday();
				break;
			case 24:
				return $this->getDontDisplayZodiac();
				break;
			case 25:
				return $this->getUsCitizen();
				break;
			case 26:
				return $this->getEmailNotifications();
				break;
			case 27:
				return $this->getDontUsePhotos();
				break;
			case 28:
				return $this->getContactOnlyFullMembers();
				break;
			case 29:
				return $this->getYoutubeVid();
				break;
			case 30:
				return $this->getEssayHeadline();
				break;
			case 31:
				return $this->getEssayIntroduction();
				break;
			case 32:
				return $this->getSearchCriteriaId();
				break;
			case 33:
				return $this->getSubscriptionId();
				break;
			case 34:
				return $this->getSubAutoRenew();
				break;
			case 35:
				return $this->getMemberCounterId();
				break;
			case 36:
				return $this->getLastActivity();
				break;
			case 37:
				return $this->getLastStatusChange();
				break;
			case 38:
				return $this->getLastFlagged();
				break;
			case 39:
				return $this->getLastLogin();
				break;
			case 40:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberStatusId(),
			$keys[2] => $this->getUsername(),
			$keys[3] => $this->getPassword(),
			$keys[4] => $this->getNewPassword(),
			$keys[5] => $this->getMustChangePwd(),
			$keys[6] => $this->getFirstName(),
			$keys[7] => $this->getLastName(),
			$keys[8] => $this->getEmail(),
			$keys[9] => $this->getTmpEmail(),
			$keys[10] => $this->getConfirmedEmail(),
			$keys[11] => $this->getSex(),
			$keys[12] => $this->getLookingFor(),
			$keys[13] => $this->getReviewedById(),
			$keys[14] => $this->getReviewedAt(),
			$keys[15] => $this->getIsStarred(),
			$keys[16] => $this->getCountry(),
			$keys[17] => $this->getStateId(),
			$keys[18] => $this->getDistrict(),
			$keys[19] => $this->getCity(),
			$keys[20] => $this->getZip(),
			$keys[21] => $this->getNationality(),
			$keys[22] => $this->getLanguage(),
			$keys[23] => $this->getBirthday(),
			$keys[24] => $this->getDontDisplayZodiac(),
			$keys[25] => $this->getUsCitizen(),
			$keys[26] => $this->getEmailNotifications(),
			$keys[27] => $this->getDontUsePhotos(),
			$keys[28] => $this->getContactOnlyFullMembers(),
			$keys[29] => $this->getYoutubeVid(),
			$keys[30] => $this->getEssayHeadline(),
			$keys[31] => $this->getEssayIntroduction(),
			$keys[32] => $this->getSearchCriteriaId(),
			$keys[33] => $this->getSubscriptionId(),
			$keys[34] => $this->getSubAutoRenew(),
			$keys[35] => $this->getMemberCounterId(),
			$keys[36] => $this->getLastActivity(),
			$keys[37] => $this->getLastStatusChange(),
			$keys[38] => $this->getLastFlagged(),
			$keys[39] => $this->getLastLogin(),
			$keys[40] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMemberStatusId($value);
				break;
			case 2:
				$this->setUsername($value);
				break;
			case 3:
				$this->setPassword($value);
				break;
			case 4:
				$this->setNewPassword($value);
				break;
			case 5:
				$this->setMustChangePwd($value);
				break;
			case 6:
				$this->setFirstName($value);
				break;
			case 7:
				$this->setLastName($value);
				break;
			case 8:
				$this->setEmail($value);
				break;
			case 9:
				$this->setTmpEmail($value);
				break;
			case 10:
				$this->setConfirmedEmail($value);
				break;
			case 11:
				$this->setSex($value);
				break;
			case 12:
				$this->setLookingFor($value);
				break;
			case 13:
				$this->setReviewedById($value);
				break;
			case 14:
				$this->setReviewedAt($value);
				break;
			case 15:
				$this->setIsStarred($value);
				break;
			case 16:
				$this->setCountry($value);
				break;
			case 17:
				$this->setStateId($value);
				break;
			case 18:
				$this->setDistrict($value);
				break;
			case 19:
				$this->setCity($value);
				break;
			case 20:
				$this->setZip($value);
				break;
			case 21:
				$this->setNationality($value);
				break;
			case 22:
				$this->setLanguage($value);
				break;
			case 23:
				$this->setBirthday($value);
				break;
			case 24:
				$this->setDontDisplayZodiac($value);
				break;
			case 25:
				$this->setUsCitizen($value);
				break;
			case 26:
				$this->setEmailNotifications($value);
				break;
			case 27:
				$this->setDontUsePhotos($value);
				break;
			case 28:
				$this->setContactOnlyFullMembers($value);
				break;
			case 29:
				$this->setYoutubeVid($value);
				break;
			case 30:
				$this->setEssayHeadline($value);
				break;
			case 31:
				$this->setEssayIntroduction($value);
				break;
			case 32:
				$this->setSearchCriteriaId($value);
				break;
			case 33:
				$this->setSubscriptionId($value);
				break;
			case 34:
				$this->setSubAutoRenew($value);
				break;
			case 35:
				$this->setMemberCounterId($value);
				break;
			case 36:
				$this->setLastActivity($value);
				break;
			case 37:
				$this->setLastStatusChange($value);
				break;
			case 38:
				$this->setLastFlagged($value);
				break;
			case 39:
				$this->setLastLogin($value);
				break;
			case 40:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberStatusId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUsername($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPassword($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNewPassword($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMustChangePwd($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setFirstName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLastName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setEmail($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTmpEmail($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setConfirmedEmail($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setSex($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setLookingFor($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setReviewedById($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setReviewedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setIsStarred($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setCountry($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setStateId($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setDistrict($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setCity($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setZip($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setNationality($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setLanguage($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setBirthday($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setDontDisplayZodiac($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setUsCitizen($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setEmailNotifications($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setDontUsePhotos($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setContactOnlyFullMembers($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setYoutubeVid($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setEssayHeadline($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setEssayIntroduction($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setSearchCriteriaId($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setSubscriptionId($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setSubAutoRenew($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setMemberCounterId($arr[$keys[35]]);
		if (array_key_exists($keys[36], $arr)) $this->setLastActivity($arr[$keys[36]]);
		if (array_key_exists($keys[37], $arr)) $this->setLastStatusChange($arr[$keys[37]]);
		if (array_key_exists($keys[38], $arr)) $this->setLastFlagged($arr[$keys[38]]);
		if (array_key_exists($keys[39], $arr)) $this->setLastLogin($arr[$keys[39]]);
		if (array_key_exists($keys[40], $arr)) $this->setCreatedAt($arr[$keys[40]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberPeer::ID)) $criteria->add(MemberPeer::ID, $this->id);
		if ($this->isColumnModified(MemberPeer::MEMBER_STATUS_ID)) $criteria->add(MemberPeer::MEMBER_STATUS_ID, $this->member_status_id);
		if ($this->isColumnModified(MemberPeer::USERNAME)) $criteria->add(MemberPeer::USERNAME, $this->username);
		if ($this->isColumnModified(MemberPeer::PASSWORD)) $criteria->add(MemberPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(MemberPeer::NEW_PASSWORD)) $criteria->add(MemberPeer::NEW_PASSWORD, $this->new_password);
		if ($this->isColumnModified(MemberPeer::MUST_CHANGE_PWD)) $criteria->add(MemberPeer::MUST_CHANGE_PWD, $this->must_change_pwd);
		if ($this->isColumnModified(MemberPeer::FIRST_NAME)) $criteria->add(MemberPeer::FIRST_NAME, $this->first_name);
		if ($this->isColumnModified(MemberPeer::LAST_NAME)) $criteria->add(MemberPeer::LAST_NAME, $this->last_name);
		if ($this->isColumnModified(MemberPeer::EMAIL)) $criteria->add(MemberPeer::EMAIL, $this->email);
		if ($this->isColumnModified(MemberPeer::TMP_EMAIL)) $criteria->add(MemberPeer::TMP_EMAIL, $this->tmp_email);
		if ($this->isColumnModified(MemberPeer::CONFIRMED_EMAIL)) $criteria->add(MemberPeer::CONFIRMED_EMAIL, $this->confirmed_email);
		if ($this->isColumnModified(MemberPeer::SEX)) $criteria->add(MemberPeer::SEX, $this->sex);
		if ($this->isColumnModified(MemberPeer::LOOKING_FOR)) $criteria->add(MemberPeer::LOOKING_FOR, $this->looking_for);
		if ($this->isColumnModified(MemberPeer::REVIEWED_BY_ID)) $criteria->add(MemberPeer::REVIEWED_BY_ID, $this->reviewed_by_id);
		if ($this->isColumnModified(MemberPeer::REVIEWED_AT)) $criteria->add(MemberPeer::REVIEWED_AT, $this->reviewed_at);
		if ($this->isColumnModified(MemberPeer::IS_STARRED)) $criteria->add(MemberPeer::IS_STARRED, $this->is_starred);
		if ($this->isColumnModified(MemberPeer::COUNTRY)) $criteria->add(MemberPeer::COUNTRY, $this->country);
		if ($this->isColumnModified(MemberPeer::STATE_ID)) $criteria->add(MemberPeer::STATE_ID, $this->state_id);
		if ($this->isColumnModified(MemberPeer::DISTRICT)) $criteria->add(MemberPeer::DISTRICT, $this->district);
		if ($this->isColumnModified(MemberPeer::CITY)) $criteria->add(MemberPeer::CITY, $this->city);
		if ($this->isColumnModified(MemberPeer::ZIP)) $criteria->add(MemberPeer::ZIP, $this->zip);
		if ($this->isColumnModified(MemberPeer::NATIONALITY)) $criteria->add(MemberPeer::NATIONALITY, $this->nationality);
		if ($this->isColumnModified(MemberPeer::LANGUAGE)) $criteria->add(MemberPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(MemberPeer::BIRTHDAY)) $criteria->add(MemberPeer::BIRTHDAY, $this->birthday);
		if ($this->isColumnModified(MemberPeer::DONT_DISPLAY_ZODIAC)) $criteria->add(MemberPeer::DONT_DISPLAY_ZODIAC, $this->dont_display_zodiac);
		if ($this->isColumnModified(MemberPeer::US_CITIZEN)) $criteria->add(MemberPeer::US_CITIZEN, $this->us_citizen);
		if ($this->isColumnModified(MemberPeer::EMAIL_NOTIFICATIONS)) $criteria->add(MemberPeer::EMAIL_NOTIFICATIONS, $this->email_notifications);
		if ($this->isColumnModified(MemberPeer::DONT_USE_PHOTOS)) $criteria->add(MemberPeer::DONT_USE_PHOTOS, $this->dont_use_photos);
		if ($this->isColumnModified(MemberPeer::CONTACT_ONLY_FULL_MEMBERS)) $criteria->add(MemberPeer::CONTACT_ONLY_FULL_MEMBERS, $this->contact_only_full_members);
		if ($this->isColumnModified(MemberPeer::YOUTUBE_VID)) $criteria->add(MemberPeer::YOUTUBE_VID, $this->youtube_vid);
		if ($this->isColumnModified(MemberPeer::ESSAY_HEADLINE)) $criteria->add(MemberPeer::ESSAY_HEADLINE, $this->essay_headline);
		if ($this->isColumnModified(MemberPeer::ESSAY_INTRODUCTION)) $criteria->add(MemberPeer::ESSAY_INTRODUCTION, $this->essay_introduction);
		if ($this->isColumnModified(MemberPeer::SEARCH_CRITERIA_ID)) $criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->search_criteria_id);
		if ($this->isColumnModified(MemberPeer::SUBSCRIPTION_ID)) $criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->subscription_id);
		if ($this->isColumnModified(MemberPeer::SUB_AUTO_RENEW)) $criteria->add(MemberPeer::SUB_AUTO_RENEW, $this->sub_auto_renew);
		if ($this->isColumnModified(MemberPeer::MEMBER_COUNTER_ID)) $criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->member_counter_id);
		if ($this->isColumnModified(MemberPeer::LAST_ACTIVITY)) $criteria->add(MemberPeer::LAST_ACTIVITY, $this->last_activity);
		if ($this->isColumnModified(MemberPeer::LAST_STATUS_CHANGE)) $criteria->add(MemberPeer::LAST_STATUS_CHANGE, $this->last_status_change);
		if ($this->isColumnModified(MemberPeer::LAST_FLAGGED)) $criteria->add(MemberPeer::LAST_FLAGGED, $this->last_flagged);
		if ($this->isColumnModified(MemberPeer::LAST_LOGIN)) $criteria->add(MemberPeer::LAST_LOGIN, $this->last_login);
		if ($this->isColumnModified(MemberPeer::CREATED_AT)) $criteria->add(MemberPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberPeer::DATABASE_NAME);

		$criteria->add(MemberPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setMemberStatusId($this->member_status_id);

		$copyObj->setUsername($this->username);

		$copyObj->setPassword($this->password);

		$copyObj->setNewPassword($this->new_password);

		$copyObj->setMustChangePwd($this->must_change_pwd);

		$copyObj->setFirstName($this->first_name);

		$copyObj->setLastName($this->last_name);

		$copyObj->setEmail($this->email);

		$copyObj->setTmpEmail($this->tmp_email);

		$copyObj->setConfirmedEmail($this->confirmed_email);

		$copyObj->setSex($this->sex);

		$copyObj->setLookingFor($this->looking_for);

		$copyObj->setReviewedById($this->reviewed_by_id);

		$copyObj->setReviewedAt($this->reviewed_at);

		$copyObj->setIsStarred($this->is_starred);

		$copyObj->setCountry($this->country);

		$copyObj->setStateId($this->state_id);

		$copyObj->setDistrict($this->district);

		$copyObj->setCity($this->city);

		$copyObj->setZip($this->zip);

		$copyObj->setNationality($this->nationality);

		$copyObj->setLanguage($this->language);

		$copyObj->setBirthday($this->birthday);

		$copyObj->setDontDisplayZodiac($this->dont_display_zodiac);

		$copyObj->setUsCitizen($this->us_citizen);

		$copyObj->setEmailNotifications($this->email_notifications);

		$copyObj->setDontUsePhotos($this->dont_use_photos);

		$copyObj->setContactOnlyFullMembers($this->contact_only_full_members);

		$copyObj->setYoutubeVid($this->youtube_vid);

		$copyObj->setEssayHeadline($this->essay_headline);

		$copyObj->setEssayIntroduction($this->essay_introduction);

		$copyObj->setSearchCriteriaId($this->search_criteria_id);

		$copyObj->setSubscriptionId($this->subscription_id);

		$copyObj->setSubAutoRenew($this->sub_auto_renew);

		$copyObj->setMemberCounterId($this->member_counter_id);

		$copyObj->setLastActivity($this->last_activity);

		$copyObj->setLastStatusChange($this->last_status_change);

		$copyObj->setLastFlagged($this->last_flagged);

		$copyObj->setLastLogin($this->last_login);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMemberNotes() as $relObj) {
				$copyObj->addMemberNote($relObj->copy($deepCopy));
			}

			foreach($this->getMemberDescAnswers() as $relObj) {
				$copyObj->addMemberDescAnswer($relObj->copy($deepCopy));
			}

			foreach($this->getMemberPhotos() as $relObj) {
				$copyObj->addMemberPhoto($relObj->copy($deepCopy));
			}

			foreach($this->getMemberImbras() as $relObj) {
				$copyObj->addMemberImbra($relObj->copy($deepCopy));
			}

			foreach($this->getProfileViewsRelatedByMemberId() as $relObj) {
				$copyObj->addProfileViewRelatedByMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getProfileViewsRelatedByProfileId() as $relObj) {
				$copyObj->addProfileViewRelatedByProfileId($relObj->copy($deepCopy));
			}

			foreach($this->getBlocksRelatedByMemberId() as $relObj) {
				$copyObj->addBlockRelatedByMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getBlocksRelatedByProfileId() as $relObj) {
				$copyObj->addBlockRelatedByProfileId($relObj->copy($deepCopy));
			}

			foreach($this->getSubscriptionHistorys() as $relObj) {
				$copyObj->addSubscriptionHistory($relObj->copy($deepCopy));
			}

			foreach($this->getMemberStatusHistorys() as $relObj) {
				$copyObj->addMemberStatusHistory($relObj->copy($deepCopy));
			}

			foreach($this->getMessagesRelatedByFromMemberId() as $relObj) {
				$copyObj->addMessageRelatedByFromMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getMessagesRelatedByToMemberId() as $relObj) {
				$copyObj->addMessageRelatedByToMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getHotlistsRelatedByMemberId() as $relObj) {
				$copyObj->addHotlistRelatedByMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getHotlistsRelatedByProfileId() as $relObj) {
				$copyObj->addHotlistRelatedByProfileId($relObj->copy($deepCopy));
			}

			foreach($this->getWinksRelatedByMemberId() as $relObj) {
				$copyObj->addWinkRelatedByMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getWinksRelatedByProfileId() as $relObj) {
				$copyObj->addWinkRelatedByProfileId($relObj->copy($deepCopy));
			}

			foreach($this->getFeedbacks() as $relObj) {
				$copyObj->addFeedback($relObj->copy($deepCopy));
			}

			foreach($this->getFlagsRelatedByMemberId() as $relObj) {
				$copyObj->addFlagRelatedByMemberId($relObj->copy($deepCopy));
			}

			foreach($this->getFlagsRelatedByFlaggerId() as $relObj) {
				$copyObj->addFlagRelatedByFlaggerId($relObj->copy($deepCopy));
			}

			foreach($this->getSuspendedByFlags() as $relObj) {
				$copyObj->addSuspendedByFlag($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MemberPeer();
		}
		return self::$peer;
	}

	
	public function setMemberStatus($v)
	{


		if ($v === null) {
			$this->setMemberStatusId(NULL);
		} else {
			$this->setMemberStatusId($v->getId());
		}


		$this->aMemberStatus = $v;
	}


	
	public function getMemberStatus($con = null)
	{
		if ($this->aMemberStatus === null && ($this->member_status_id !== null)) {
						include_once 'lib/model/om/BaseMemberStatusPeer.php';

			$this->aMemberStatus = MemberStatusPeer::retrieveByPK($this->member_status_id, $con);

			
		}
		return $this->aMemberStatus;
	}

	
	public function setUser($v)
	{


		if ($v === null) {
			$this->setReviewedById(NULL);
		} else {
			$this->setReviewedById($v->getId());
		}


		$this->aUser = $v;
	}


	
	public function getUser($con = null)
	{
		if ($this->aUser === null && ($this->reviewed_by_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUser = UserPeer::retrieveByPK($this->reviewed_by_id, $con);

			
		}
		return $this->aUser;
	}

	
	public function setState($v)
	{


		if ($v === null) {
			$this->setStateId(NULL);
		} else {
			$this->setStateId($v->getId());
		}


		$this->aState = $v;
	}


	
	public function getState($con = null)
	{
		if ($this->aState === null && ($this->state_id !== null)) {
						include_once 'lib/model/om/BaseStatePeer.php';

			$this->aState = StatePeer::retrieveByPK($this->state_id, $con);

			
		}
		return $this->aState;
	}

	
	public function setSearchCriteria($v)
	{


		if ($v === null) {
			$this->setSearchCriteriaId(NULL);
		} else {
			$this->setSearchCriteriaId($v->getId());
		}


		$this->aSearchCriteria = $v;
	}


	
	public function getSearchCriteria($con = null)
	{
		if ($this->aSearchCriteria === null && ($this->search_criteria_id !== null)) {
						include_once 'lib/model/om/BaseSearchCriteriaPeer.php';

			$this->aSearchCriteria = SearchCriteriaPeer::retrieveByPK($this->search_criteria_id, $con);

			
		}
		return $this->aSearchCriteria;
	}

	
	public function setSubscription($v)
	{


		if ($v === null) {
			$this->setSubscriptionId(NULL);
		} else {
			$this->setSubscriptionId($v->getId());
		}


		$this->aSubscription = $v;
	}


	
	public function getSubscription($con = null)
	{
		if ($this->aSubscription === null && ($this->subscription_id !== null)) {
						include_once 'lib/model/om/BaseSubscriptionPeer.php';

			$this->aSubscription = SubscriptionPeer::retrieveByPK($this->subscription_id, $con);

			
		}
		return $this->aSubscription;
	}

	
	public function setMemberCounter($v)
	{


		if ($v === null) {
			$this->setMemberCounterId(NULL);
		} else {
			$this->setMemberCounterId($v->getId());
		}


		$this->aMemberCounter = $v;
	}


	
	public function getMemberCounter($con = null)
	{
		if ($this->aMemberCounter === null && ($this->member_counter_id !== null)) {
						include_once 'lib/model/om/BaseMemberCounterPeer.php';

			$this->aMemberCounter = MemberCounterPeer::retrieveByPK($this->member_counter_id, $con);

			
		}
		return $this->aMemberCounter;
	}

	
	public function initMemberNotes()
	{
		if ($this->collMemberNotes === null) {
			$this->collMemberNotes = array();
		}
	}

	
	public function getMemberNotes($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberNotePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberNotes === null) {
			if ($this->isNew()) {
			   $this->collMemberNotes = array();
			} else {

				$criteria->add(MemberNotePeer::MEMBER_ID, $this->getId());

				MemberNotePeer::addSelectColumns($criteria);
				$this->collMemberNotes = MemberNotePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberNotePeer::MEMBER_ID, $this->getId());

				MemberNotePeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberNoteCriteria) || !$this->lastMemberNoteCriteria->equals($criteria)) {
					$this->collMemberNotes = MemberNotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberNoteCriteria = $criteria;
		return $this->collMemberNotes;
	}

	
	public function countMemberNotes($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberNotePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberNotePeer::MEMBER_ID, $this->getId());

		return MemberNotePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberNote(MemberNote $l)
	{
		$this->collMemberNotes[] = $l;
		$l->setMember($this);
	}


	
	public function getMemberNotesJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberNotePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberNotes === null) {
			if ($this->isNew()) {
				$this->collMemberNotes = array();
			} else {

				$criteria->add(MemberNotePeer::MEMBER_ID, $this->getId());

				$this->collMemberNotes = MemberNotePeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberNotePeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastMemberNoteCriteria) || !$this->lastMemberNoteCriteria->equals($criteria)) {
				$this->collMemberNotes = MemberNotePeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastMemberNoteCriteria = $criteria;

		return $this->collMemberNotes;
	}

	
	public function initMemberDescAnswers()
	{
		if ($this->collMemberDescAnswers === null) {
			$this->collMemberDescAnswers = array();
		}
	}

	
	public function getMemberDescAnswers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberDescAnswers === null) {
			if ($this->isNew()) {
			   $this->collMemberDescAnswers = array();
			} else {

				$criteria->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());

				MemberDescAnswerPeer::addSelectColumns($criteria);
				$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());

				MemberDescAnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberDescAnswerCriteria) || !$this->lastMemberDescAnswerCriteria->equals($criteria)) {
					$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberDescAnswerCriteria = $criteria;
		return $this->collMemberDescAnswers;
	}

	
	public function countMemberDescAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());

		return MemberDescAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberDescAnswer(MemberDescAnswer $l)
	{
		$this->collMemberDescAnswers[] = $l;
		$l->setMember($this);
	}


	
	public function getMemberDescAnswersJoinDescQuestion($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberDescAnswers === null) {
			if ($this->isNew()) {
				$this->collMemberDescAnswers = array();
			} else {

				$criteria->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());

				$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelectJoinDescQuestion($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberDescAnswerPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastMemberDescAnswerCriteria) || !$this->lastMemberDescAnswerCriteria->equals($criteria)) {
				$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelectJoinDescQuestion($criteria, $con);
			}
		}
		$this->lastMemberDescAnswerCriteria = $criteria;

		return $this->collMemberDescAnswers;
	}

	
	public function initMemberPhotos()
	{
		if ($this->collMemberPhotos === null) {
			$this->collMemberPhotos = array();
		}
	}

	
	public function getMemberPhotos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPhotoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberPhotos === null) {
			if ($this->isNew()) {
			   $this->collMemberPhotos = array();
			} else {

				$criteria->add(MemberPhotoPeer::MEMBER_ID, $this->getId());

				MemberPhotoPeer::addSelectColumns($criteria);
				$this->collMemberPhotos = MemberPhotoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberPhotoPeer::MEMBER_ID, $this->getId());

				MemberPhotoPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberPhotoCriteria) || !$this->lastMemberPhotoCriteria->equals($criteria)) {
					$this->collMemberPhotos = MemberPhotoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberPhotoCriteria = $criteria;
		return $this->collMemberPhotos;
	}

	
	public function countMemberPhotos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPhotoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberPhotoPeer::MEMBER_ID, $this->getId());

		return MemberPhotoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberPhoto(MemberPhoto $l)
	{
		$this->collMemberPhotos[] = $l;
		$l->setMember($this);
	}

	
	public function initMemberImbras()
	{
		if ($this->collMemberImbras === null) {
			$this->collMemberImbras = array();
		}
	}

	
	public function getMemberImbras($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbras === null) {
			if ($this->isNew()) {
			   $this->collMemberImbras = array();
			} else {

				$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

				MemberImbraPeer::addSelectColumns($criteria);
				$this->collMemberImbras = MemberImbraPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

				MemberImbraPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberImbraCriteria) || !$this->lastMemberImbraCriteria->equals($criteria)) {
					$this->collMemberImbras = MemberImbraPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberImbraCriteria = $criteria;
		return $this->collMemberImbras;
	}

	
	public function countMemberImbras($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

		return MemberImbraPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberImbra(MemberImbra $l)
	{
		$this->collMemberImbras[] = $l;
		$l->setMember($this);
	}


	
	public function getMemberImbrasJoinImbraStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbras === null) {
			if ($this->isNew()) {
				$this->collMemberImbras = array();
			} else {

				$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

				$this->collMemberImbras = MemberImbraPeer::doSelectJoinImbraStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastMemberImbraCriteria) || !$this->lastMemberImbraCriteria->equals($criteria)) {
				$this->collMemberImbras = MemberImbraPeer::doSelectJoinImbraStatus($criteria, $con);
			}
		}
		$this->lastMemberImbraCriteria = $criteria;

		return $this->collMemberImbras;
	}


	
	public function getMemberImbrasJoinState($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbras === null) {
			if ($this->isNew()) {
				$this->collMemberImbras = array();
			} else {

				$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

				$this->collMemberImbras = MemberImbraPeer::doSelectJoinState($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberImbraPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastMemberImbraCriteria) || !$this->lastMemberImbraCriteria->equals($criteria)) {
				$this->collMemberImbras = MemberImbraPeer::doSelectJoinState($criteria, $con);
			}
		}
		$this->lastMemberImbraCriteria = $criteria;

		return $this->collMemberImbras;
	}

	
	public function initProfileViewsRelatedByMemberId()
	{
		if ($this->collProfileViewsRelatedByMemberId === null) {
			$this->collProfileViewsRelatedByMemberId = array();
		}
	}

	
	public function getProfileViewsRelatedByMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseProfileViewPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProfileViewsRelatedByMemberId === null) {
			if ($this->isNew()) {
			   $this->collProfileViewsRelatedByMemberId = array();
			} else {

				$criteria->add(ProfileViewPeer::MEMBER_ID, $this->getId());

				ProfileViewPeer::addSelectColumns($criteria);
				$this->collProfileViewsRelatedByMemberId = ProfileViewPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ProfileViewPeer::MEMBER_ID, $this->getId());

				ProfileViewPeer::addSelectColumns($criteria);
				if (!isset($this->lastProfileViewRelatedByMemberIdCriteria) || !$this->lastProfileViewRelatedByMemberIdCriteria->equals($criteria)) {
					$this->collProfileViewsRelatedByMemberId = ProfileViewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProfileViewRelatedByMemberIdCriteria = $criteria;
		return $this->collProfileViewsRelatedByMemberId;
	}

	
	public function countProfileViewsRelatedByMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseProfileViewPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProfileViewPeer::MEMBER_ID, $this->getId());

		return ProfileViewPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addProfileViewRelatedByMemberId(ProfileView $l)
	{
		$this->collProfileViewsRelatedByMemberId[] = $l;
		$l->setMemberRelatedByMemberId($this);
	}

	
	public function initProfileViewsRelatedByProfileId()
	{
		if ($this->collProfileViewsRelatedByProfileId === null) {
			$this->collProfileViewsRelatedByProfileId = array();
		}
	}

	
	public function getProfileViewsRelatedByProfileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseProfileViewPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProfileViewsRelatedByProfileId === null) {
			if ($this->isNew()) {
			   $this->collProfileViewsRelatedByProfileId = array();
			} else {

				$criteria->add(ProfileViewPeer::PROFILE_ID, $this->getId());

				ProfileViewPeer::addSelectColumns($criteria);
				$this->collProfileViewsRelatedByProfileId = ProfileViewPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ProfileViewPeer::PROFILE_ID, $this->getId());

				ProfileViewPeer::addSelectColumns($criteria);
				if (!isset($this->lastProfileViewRelatedByProfileIdCriteria) || !$this->lastProfileViewRelatedByProfileIdCriteria->equals($criteria)) {
					$this->collProfileViewsRelatedByProfileId = ProfileViewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProfileViewRelatedByProfileIdCriteria = $criteria;
		return $this->collProfileViewsRelatedByProfileId;
	}

	
	public function countProfileViewsRelatedByProfileId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseProfileViewPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProfileViewPeer::PROFILE_ID, $this->getId());

		return ProfileViewPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addProfileViewRelatedByProfileId(ProfileView $l)
	{
		$this->collProfileViewsRelatedByProfileId[] = $l;
		$l->setMemberRelatedByProfileId($this);
	}

	
	public function initBlocksRelatedByMemberId()
	{
		if ($this->collBlocksRelatedByMemberId === null) {
			$this->collBlocksRelatedByMemberId = array();
		}
	}

	
	public function getBlocksRelatedByMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseBlockPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlocksRelatedByMemberId === null) {
			if ($this->isNew()) {
			   $this->collBlocksRelatedByMemberId = array();
			} else {

				$criteria->add(BlockPeer::MEMBER_ID, $this->getId());

				BlockPeer::addSelectColumns($criteria);
				$this->collBlocksRelatedByMemberId = BlockPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(BlockPeer::MEMBER_ID, $this->getId());

				BlockPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlockRelatedByMemberIdCriteria) || !$this->lastBlockRelatedByMemberIdCriteria->equals($criteria)) {
					$this->collBlocksRelatedByMemberId = BlockPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlockRelatedByMemberIdCriteria = $criteria;
		return $this->collBlocksRelatedByMemberId;
	}

	
	public function countBlocksRelatedByMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseBlockPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlockPeer::MEMBER_ID, $this->getId());

		return BlockPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addBlockRelatedByMemberId(Block $l)
	{
		$this->collBlocksRelatedByMemberId[] = $l;
		$l->setMemberRelatedByMemberId($this);
	}

	
	public function initBlocksRelatedByProfileId()
	{
		if ($this->collBlocksRelatedByProfileId === null) {
			$this->collBlocksRelatedByProfileId = array();
		}
	}

	
	public function getBlocksRelatedByProfileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseBlockPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlocksRelatedByProfileId === null) {
			if ($this->isNew()) {
			   $this->collBlocksRelatedByProfileId = array();
			} else {

				$criteria->add(BlockPeer::PROFILE_ID, $this->getId());

				BlockPeer::addSelectColumns($criteria);
				$this->collBlocksRelatedByProfileId = BlockPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(BlockPeer::PROFILE_ID, $this->getId());

				BlockPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlockRelatedByProfileIdCriteria) || !$this->lastBlockRelatedByProfileIdCriteria->equals($criteria)) {
					$this->collBlocksRelatedByProfileId = BlockPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlockRelatedByProfileIdCriteria = $criteria;
		return $this->collBlocksRelatedByProfileId;
	}

	
	public function countBlocksRelatedByProfileId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseBlockPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlockPeer::PROFILE_ID, $this->getId());

		return BlockPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addBlockRelatedByProfileId(Block $l)
	{
		$this->collBlocksRelatedByProfileId[] = $l;
		$l->setMemberRelatedByProfileId($this);
	}

	
	public function initSubscriptionHistorys()
	{
		if ($this->collSubscriptionHistorys === null) {
			$this->collSubscriptionHistorys = array();
		}
	}

	
	public function getSubscriptionHistorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSubscriptionHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionHistorys === null) {
			if ($this->isNew()) {
			   $this->collSubscriptionHistorys = array();
			} else {

				$criteria->add(SubscriptionHistoryPeer::MEMBER_ID, $this->getId());

				SubscriptionHistoryPeer::addSelectColumns($criteria);
				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubscriptionHistoryPeer::MEMBER_ID, $this->getId());

				SubscriptionHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastSubscriptionHistoryCriteria) || !$this->lastSubscriptionHistoryCriteria->equals($criteria)) {
					$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSubscriptionHistoryCriteria = $criteria;
		return $this->collSubscriptionHistorys;
	}

	
	public function countSubscriptionHistorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSubscriptionHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SubscriptionHistoryPeer::MEMBER_ID, $this->getId());

		return SubscriptionHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSubscriptionHistory(SubscriptionHistory $l)
	{
		$this->collSubscriptionHistorys[] = $l;
		$l->setMember($this);
	}


	
	public function getSubscriptionHistorysJoinSubscription($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSubscriptionHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionHistorys === null) {
			if ($this->isNew()) {
				$this->collSubscriptionHistorys = array();
			} else {

				$criteria->add(SubscriptionHistoryPeer::MEMBER_ID, $this->getId());

				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelectJoinSubscription($criteria, $con);
			}
		} else {
									
			$criteria->add(SubscriptionHistoryPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastSubscriptionHistoryCriteria) || !$this->lastSubscriptionHistoryCriteria->equals($criteria)) {
				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelectJoinSubscription($criteria, $con);
			}
		}
		$this->lastSubscriptionHistoryCriteria = $criteria;

		return $this->collSubscriptionHistorys;
	}

	
	public function initMemberStatusHistorys()
	{
		if ($this->collMemberStatusHistorys === null) {
			$this->collMemberStatusHistorys = array();
		}
	}

	
	public function getMemberStatusHistorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStatusHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberStatusHistorys === null) {
			if ($this->isNew()) {
			   $this->collMemberStatusHistorys = array();
			} else {

				$criteria->add(MemberStatusHistoryPeer::MEMBER_ID, $this->getId());

				MemberStatusHistoryPeer::addSelectColumns($criteria);
				$this->collMemberStatusHistorys = MemberStatusHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberStatusHistoryPeer::MEMBER_ID, $this->getId());

				MemberStatusHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberStatusHistoryCriteria) || !$this->lastMemberStatusHistoryCriteria->equals($criteria)) {
					$this->collMemberStatusHistorys = MemberStatusHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberStatusHistoryCriteria = $criteria;
		return $this->collMemberStatusHistorys;
	}

	
	public function countMemberStatusHistorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStatusHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberStatusHistoryPeer::MEMBER_ID, $this->getId());

		return MemberStatusHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberStatusHistory(MemberStatusHistory $l)
	{
		$this->collMemberStatusHistorys[] = $l;
		$l->setMember($this);
	}


	
	public function getMemberStatusHistorysJoinMemberStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStatusHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberStatusHistorys === null) {
			if ($this->isNew()) {
				$this->collMemberStatusHistorys = array();
			} else {

				$criteria->add(MemberStatusHistoryPeer::MEMBER_ID, $this->getId());

				$this->collMemberStatusHistorys = MemberStatusHistoryPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberStatusHistoryPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastMemberStatusHistoryCriteria) || !$this->lastMemberStatusHistoryCriteria->equals($criteria)) {
				$this->collMemberStatusHistorys = MemberStatusHistoryPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		}
		$this->lastMemberStatusHistoryCriteria = $criteria;

		return $this->collMemberStatusHistorys;
	}

	
	public function initMessagesRelatedByFromMemberId()
	{
		if ($this->collMessagesRelatedByFromMemberId === null) {
			$this->collMessagesRelatedByFromMemberId = array();
		}
	}

	
	public function getMessagesRelatedByFromMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMessagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessagesRelatedByFromMemberId === null) {
			if ($this->isNew()) {
			   $this->collMessagesRelatedByFromMemberId = array();
			} else {

				$criteria->add(MessagePeer::FROM_MEMBER_ID, $this->getId());

				MessagePeer::addSelectColumns($criteria);
				$this->collMessagesRelatedByFromMemberId = MessagePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MessagePeer::FROM_MEMBER_ID, $this->getId());

				MessagePeer::addSelectColumns($criteria);
				if (!isset($this->lastMessageRelatedByFromMemberIdCriteria) || !$this->lastMessageRelatedByFromMemberIdCriteria->equals($criteria)) {
					$this->collMessagesRelatedByFromMemberId = MessagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessageRelatedByFromMemberIdCriteria = $criteria;
		return $this->collMessagesRelatedByFromMemberId;
	}

	
	public function countMessagesRelatedByFromMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMessagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MessagePeer::FROM_MEMBER_ID, $this->getId());

		return MessagePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMessageRelatedByFromMemberId(Message $l)
	{
		$this->collMessagesRelatedByFromMemberId[] = $l;
		$l->setMemberRelatedByFromMemberId($this);
	}

	
	public function initMessagesRelatedByToMemberId()
	{
		if ($this->collMessagesRelatedByToMemberId === null) {
			$this->collMessagesRelatedByToMemberId = array();
		}
	}

	
	public function getMessagesRelatedByToMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMessagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessagesRelatedByToMemberId === null) {
			if ($this->isNew()) {
			   $this->collMessagesRelatedByToMemberId = array();
			} else {

				$criteria->add(MessagePeer::TO_MEMBER_ID, $this->getId());

				MessagePeer::addSelectColumns($criteria);
				$this->collMessagesRelatedByToMemberId = MessagePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MessagePeer::TO_MEMBER_ID, $this->getId());

				MessagePeer::addSelectColumns($criteria);
				if (!isset($this->lastMessageRelatedByToMemberIdCriteria) || !$this->lastMessageRelatedByToMemberIdCriteria->equals($criteria)) {
					$this->collMessagesRelatedByToMemberId = MessagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessageRelatedByToMemberIdCriteria = $criteria;
		return $this->collMessagesRelatedByToMemberId;
	}

	
	public function countMessagesRelatedByToMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMessagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MessagePeer::TO_MEMBER_ID, $this->getId());

		return MessagePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMessageRelatedByToMemberId(Message $l)
	{
		$this->collMessagesRelatedByToMemberId[] = $l;
		$l->setMemberRelatedByToMemberId($this);
	}

	
	public function initHotlistsRelatedByMemberId()
	{
		if ($this->collHotlistsRelatedByMemberId === null) {
			$this->collHotlistsRelatedByMemberId = array();
		}
	}

	
	public function getHotlistsRelatedByMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHotlistPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHotlistsRelatedByMemberId === null) {
			if ($this->isNew()) {
			   $this->collHotlistsRelatedByMemberId = array();
			} else {

				$criteria->add(HotlistPeer::MEMBER_ID, $this->getId());

				HotlistPeer::addSelectColumns($criteria);
				$this->collHotlistsRelatedByMemberId = HotlistPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(HotlistPeer::MEMBER_ID, $this->getId());

				HotlistPeer::addSelectColumns($criteria);
				if (!isset($this->lastHotlistRelatedByMemberIdCriteria) || !$this->lastHotlistRelatedByMemberIdCriteria->equals($criteria)) {
					$this->collHotlistsRelatedByMemberId = HotlistPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHotlistRelatedByMemberIdCriteria = $criteria;
		return $this->collHotlistsRelatedByMemberId;
	}

	
	public function countHotlistsRelatedByMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseHotlistPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(HotlistPeer::MEMBER_ID, $this->getId());

		return HotlistPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addHotlistRelatedByMemberId(Hotlist $l)
	{
		$this->collHotlistsRelatedByMemberId[] = $l;
		$l->setMemberRelatedByMemberId($this);
	}

	
	public function initHotlistsRelatedByProfileId()
	{
		if ($this->collHotlistsRelatedByProfileId === null) {
			$this->collHotlistsRelatedByProfileId = array();
		}
	}

	
	public function getHotlistsRelatedByProfileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHotlistPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHotlistsRelatedByProfileId === null) {
			if ($this->isNew()) {
			   $this->collHotlistsRelatedByProfileId = array();
			} else {

				$criteria->add(HotlistPeer::PROFILE_ID, $this->getId());

				HotlistPeer::addSelectColumns($criteria);
				$this->collHotlistsRelatedByProfileId = HotlistPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(HotlistPeer::PROFILE_ID, $this->getId());

				HotlistPeer::addSelectColumns($criteria);
				if (!isset($this->lastHotlistRelatedByProfileIdCriteria) || !$this->lastHotlistRelatedByProfileIdCriteria->equals($criteria)) {
					$this->collHotlistsRelatedByProfileId = HotlistPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHotlistRelatedByProfileIdCriteria = $criteria;
		return $this->collHotlistsRelatedByProfileId;
	}

	
	public function countHotlistsRelatedByProfileId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseHotlistPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(HotlistPeer::PROFILE_ID, $this->getId());

		return HotlistPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addHotlistRelatedByProfileId(Hotlist $l)
	{
		$this->collHotlistsRelatedByProfileId[] = $l;
		$l->setMemberRelatedByProfileId($this);
	}

	
	public function initWinksRelatedByMemberId()
	{
		if ($this->collWinksRelatedByMemberId === null) {
			$this->collWinksRelatedByMemberId = array();
		}
	}

	
	public function getWinksRelatedByMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseWinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWinksRelatedByMemberId === null) {
			if ($this->isNew()) {
			   $this->collWinksRelatedByMemberId = array();
			} else {

				$criteria->add(WinkPeer::MEMBER_ID, $this->getId());

				WinkPeer::addSelectColumns($criteria);
				$this->collWinksRelatedByMemberId = WinkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(WinkPeer::MEMBER_ID, $this->getId());

				WinkPeer::addSelectColumns($criteria);
				if (!isset($this->lastWinkRelatedByMemberIdCriteria) || !$this->lastWinkRelatedByMemberIdCriteria->equals($criteria)) {
					$this->collWinksRelatedByMemberId = WinkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWinkRelatedByMemberIdCriteria = $criteria;
		return $this->collWinksRelatedByMemberId;
	}

	
	public function countWinksRelatedByMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseWinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WinkPeer::MEMBER_ID, $this->getId());

		return WinkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addWinkRelatedByMemberId(Wink $l)
	{
		$this->collWinksRelatedByMemberId[] = $l;
		$l->setMemberRelatedByMemberId($this);
	}

	
	public function initWinksRelatedByProfileId()
	{
		if ($this->collWinksRelatedByProfileId === null) {
			$this->collWinksRelatedByProfileId = array();
		}
	}

	
	public function getWinksRelatedByProfileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseWinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWinksRelatedByProfileId === null) {
			if ($this->isNew()) {
			   $this->collWinksRelatedByProfileId = array();
			} else {

				$criteria->add(WinkPeer::PROFILE_ID, $this->getId());

				WinkPeer::addSelectColumns($criteria);
				$this->collWinksRelatedByProfileId = WinkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(WinkPeer::PROFILE_ID, $this->getId());

				WinkPeer::addSelectColumns($criteria);
				if (!isset($this->lastWinkRelatedByProfileIdCriteria) || !$this->lastWinkRelatedByProfileIdCriteria->equals($criteria)) {
					$this->collWinksRelatedByProfileId = WinkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWinkRelatedByProfileIdCriteria = $criteria;
		return $this->collWinksRelatedByProfileId;
	}

	
	public function countWinksRelatedByProfileId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseWinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WinkPeer::PROFILE_ID, $this->getId());

		return WinkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addWinkRelatedByProfileId(Wink $l)
	{
		$this->collWinksRelatedByProfileId[] = $l;
		$l->setMemberRelatedByProfileId($this);
	}

	
	public function initFeedbacks()
	{
		if ($this->collFeedbacks === null) {
			$this->collFeedbacks = array();
		}
	}

	
	public function getFeedbacks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFeedbackPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFeedbacks === null) {
			if ($this->isNew()) {
			   $this->collFeedbacks = array();
			} else {

				$criteria->add(FeedbackPeer::MEMBER_ID, $this->getId());

				FeedbackPeer::addSelectColumns($criteria);
				$this->collFeedbacks = FeedbackPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FeedbackPeer::MEMBER_ID, $this->getId());

				FeedbackPeer::addSelectColumns($criteria);
				if (!isset($this->lastFeedbackCriteria) || !$this->lastFeedbackCriteria->equals($criteria)) {
					$this->collFeedbacks = FeedbackPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFeedbackCriteria = $criteria;
		return $this->collFeedbacks;
	}

	
	public function countFeedbacks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFeedbackPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FeedbackPeer::MEMBER_ID, $this->getId());

		return FeedbackPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFeedback(Feedback $l)
	{
		$this->collFeedbacks[] = $l;
		$l->setMember($this);
	}

	
	public function initFlagsRelatedByMemberId()
	{
		if ($this->collFlagsRelatedByMemberId === null) {
			$this->collFlagsRelatedByMemberId = array();
		}
	}

	
	public function getFlagsRelatedByMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlagsRelatedByMemberId === null) {
			if ($this->isNew()) {
			   $this->collFlagsRelatedByMemberId = array();
			} else {

				$criteria->add(FlagPeer::MEMBER_ID, $this->getId());

				FlagPeer::addSelectColumns($criteria);
				$this->collFlagsRelatedByMemberId = FlagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FlagPeer::MEMBER_ID, $this->getId());

				FlagPeer::addSelectColumns($criteria);
				if (!isset($this->lastFlagRelatedByMemberIdCriteria) || !$this->lastFlagRelatedByMemberIdCriteria->equals($criteria)) {
					$this->collFlagsRelatedByMemberId = FlagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFlagRelatedByMemberIdCriteria = $criteria;
		return $this->collFlagsRelatedByMemberId;
	}

	
	public function countFlagsRelatedByMemberId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FlagPeer::MEMBER_ID, $this->getId());

		return FlagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFlagRelatedByMemberId(Flag $l)
	{
		$this->collFlagsRelatedByMemberId[] = $l;
		$l->setMemberRelatedByMemberId($this);
	}


	
	public function getFlagsRelatedByMemberIdJoinFlagCategory($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlagsRelatedByMemberId === null) {
			if ($this->isNew()) {
				$this->collFlagsRelatedByMemberId = array();
			} else {

				$criteria->add(FlagPeer::MEMBER_ID, $this->getId());

				$this->collFlagsRelatedByMemberId = FlagPeer::doSelectJoinFlagCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(FlagPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastFlagRelatedByMemberIdCriteria) || !$this->lastFlagRelatedByMemberIdCriteria->equals($criteria)) {
				$this->collFlagsRelatedByMemberId = FlagPeer::doSelectJoinFlagCategory($criteria, $con);
			}
		}
		$this->lastFlagRelatedByMemberIdCriteria = $criteria;

		return $this->collFlagsRelatedByMemberId;
	}

	
	public function initFlagsRelatedByFlaggerId()
	{
		if ($this->collFlagsRelatedByFlaggerId === null) {
			$this->collFlagsRelatedByFlaggerId = array();
		}
	}

	
	public function getFlagsRelatedByFlaggerId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlagsRelatedByFlaggerId === null) {
			if ($this->isNew()) {
			   $this->collFlagsRelatedByFlaggerId = array();
			} else {

				$criteria->add(FlagPeer::FLAGGER_ID, $this->getId());

				FlagPeer::addSelectColumns($criteria);
				$this->collFlagsRelatedByFlaggerId = FlagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FlagPeer::FLAGGER_ID, $this->getId());

				FlagPeer::addSelectColumns($criteria);
				if (!isset($this->lastFlagRelatedByFlaggerIdCriteria) || !$this->lastFlagRelatedByFlaggerIdCriteria->equals($criteria)) {
					$this->collFlagsRelatedByFlaggerId = FlagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFlagRelatedByFlaggerIdCriteria = $criteria;
		return $this->collFlagsRelatedByFlaggerId;
	}

	
	public function countFlagsRelatedByFlaggerId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FlagPeer::FLAGGER_ID, $this->getId());

		return FlagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFlagRelatedByFlaggerId(Flag $l)
	{
		$this->collFlagsRelatedByFlaggerId[] = $l;
		$l->setMemberRelatedByFlaggerId($this);
	}


	
	public function getFlagsRelatedByFlaggerIdJoinFlagCategory($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlagsRelatedByFlaggerId === null) {
			if ($this->isNew()) {
				$this->collFlagsRelatedByFlaggerId = array();
			} else {

				$criteria->add(FlagPeer::FLAGGER_ID, $this->getId());

				$this->collFlagsRelatedByFlaggerId = FlagPeer::doSelectJoinFlagCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(FlagPeer::FLAGGER_ID, $this->getId());

			if (!isset($this->lastFlagRelatedByFlaggerIdCriteria) || !$this->lastFlagRelatedByFlaggerIdCriteria->equals($criteria)) {
				$this->collFlagsRelatedByFlaggerId = FlagPeer::doSelectJoinFlagCategory($criteria, $con);
			}
		}
		$this->lastFlagRelatedByFlaggerIdCriteria = $criteria;

		return $this->collFlagsRelatedByFlaggerId;
	}

	
	public function initSuspendedByFlags()
	{
		if ($this->collSuspendedByFlags === null) {
			$this->collSuspendedByFlags = array();
		}
	}

	
	public function getSuspendedByFlags($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSuspendedByFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSuspendedByFlags === null) {
			if ($this->isNew()) {
			   $this->collSuspendedByFlags = array();
			} else {

				$criteria->add(SuspendedByFlagPeer::MEMBER_ID, $this->getId());

				SuspendedByFlagPeer::addSelectColumns($criteria);
				$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SuspendedByFlagPeer::MEMBER_ID, $this->getId());

				SuspendedByFlagPeer::addSelectColumns($criteria);
				if (!isset($this->lastSuspendedByFlagCriteria) || !$this->lastSuspendedByFlagCriteria->equals($criteria)) {
					$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSuspendedByFlagCriteria = $criteria;
		return $this->collSuspendedByFlags;
	}

	
	public function countSuspendedByFlags($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSuspendedByFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SuspendedByFlagPeer::MEMBER_ID, $this->getId());

		return SuspendedByFlagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSuspendedByFlag(SuspendedByFlag $l)
	{
		$this->collSuspendedByFlags[] = $l;
		$l->setMember($this);
	}


	
	public function getSuspendedByFlagsJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSuspendedByFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSuspendedByFlags === null) {
			if ($this->isNew()) {
				$this->collSuspendedByFlags = array();
			} else {

				$criteria->add(SuspendedByFlagPeer::MEMBER_ID, $this->getId());

				$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(SuspendedByFlagPeer::MEMBER_ID, $this->getId());

			if (!isset($this->lastSuspendedByFlagCriteria) || !$this->lastSuspendedByFlagCriteria->equals($criteria)) {
				$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastSuspendedByFlagCriteria = $criteria;

		return $this->collSuspendedByFlags;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMember:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMember::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 