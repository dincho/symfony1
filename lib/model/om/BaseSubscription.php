<?php


abstract class BaseSubscription extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;


	
	protected $can_create_profile = false;


	
	protected $create_profiles = 0;


	
	protected $can_post_photo = false;


	
	protected $post_photos = 0;


	
	protected $can_wink = false;


	
	protected $winks = 0;


	
	protected $can_read_messages = false;


	
	protected $read_messages = 0;


	
	protected $can_reply_messages = false;


	
	protected $reply_messages = 0;


	
	protected $can_send_messages = false;


	
	protected $send_messages = 0;


	
	protected $can_see_viewed = false;


	
	protected $see_viewed = 0;


	
	protected $can_contact_assistant = false;


	
	protected $contact_assistant = 0;


	
	protected $pre_approve = false;


	
	protected $amount;


	
	protected $period;


	
	protected $period_type;


	
	protected $trial1_amount;


	
	protected $trial1_period;


	
	protected $trial1_period_type;


	
	protected $trial2_amount;


	
	protected $trial2_period;


	
	protected $trial2_period_type;

	
	protected $collMembers;

	
	protected $lastMemberCriteria = null;

	
	protected $collSubscriptionHistorys;

	
	protected $lastSubscriptionHistoryCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getCanCreateProfile()
	{

		return $this->can_create_profile;
	}

	
	public function getCreateProfiles()
	{

		return $this->create_profiles;
	}

	
	public function getCanPostPhoto()
	{

		return $this->can_post_photo;
	}

	
	public function getPostPhotos()
	{

		return $this->post_photos;
	}

	
	public function getCanWink()
	{

		return $this->can_wink;
	}

	
	public function getWinks()
	{

		return $this->winks;
	}

	
	public function getCanReadMessages()
	{

		return $this->can_read_messages;
	}

	
	public function getReadMessages()
	{

		return $this->read_messages;
	}

	
	public function getCanReplyMessages()
	{

		return $this->can_reply_messages;
	}

	
	public function getReplyMessages()
	{

		return $this->reply_messages;
	}

	
	public function getCanSendMessages()
	{

		return $this->can_send_messages;
	}

	
	public function getSendMessages()
	{

		return $this->send_messages;
	}

	
	public function getCanSeeViewed()
	{

		return $this->can_see_viewed;
	}

	
	public function getSeeViewed()
	{

		return $this->see_viewed;
	}

	
	public function getCanContactAssistant()
	{

		return $this->can_contact_assistant;
	}

	
	public function getContactAssistant()
	{

		return $this->contact_assistant;
	}

	
	public function getPreApprove()
	{

		return $this->pre_approve;
	}

	
	public function getAmount()
	{

		return $this->amount;
	}

	
	public function getPeriod()
	{

		return $this->period;
	}

	
	public function getPeriodType()
	{

		return $this->period_type;
	}

	
	public function getTrial1Amount()
	{

		return $this->trial1_amount;
	}

	
	public function getTrial1Period()
	{

		return $this->trial1_period;
	}

	
	public function getTrial1PeriodType()
	{

		return $this->trial1_period_type;
	}

	
	public function getTrial2Amount()
	{

		return $this->trial2_amount;
	}

	
	public function getTrial2Period()
	{

		return $this->trial2_period;
	}

	
	public function getTrial2PeriodType()
	{

		return $this->trial2_period_type;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SubscriptionPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TITLE;
		}

	} 
	
	public function setCanCreateProfile($v)
	{

		if ($this->can_create_profile !== $v || $v === false) {
			$this->can_create_profile = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_CREATE_PROFILE;
		}

	} 
	
	public function setCreateProfiles($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->create_profiles !== $v || $v === 0) {
			$this->create_profiles = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CREATE_PROFILES;
		}

	} 
	
	public function setCanPostPhoto($v)
	{

		if ($this->can_post_photo !== $v || $v === false) {
			$this->can_post_photo = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_POST_PHOTO;
		}

	} 
	
	public function setPostPhotos($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->post_photos !== $v || $v === 0) {
			$this->post_photos = $v;
			$this->modifiedColumns[] = SubscriptionPeer::POST_PHOTOS;
		}

	} 
	
	public function setCanWink($v)
	{

		if ($this->can_wink !== $v || $v === false) {
			$this->can_wink = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_WINK;
		}

	} 
	
	public function setWinks($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->winks !== $v || $v === 0) {
			$this->winks = $v;
			$this->modifiedColumns[] = SubscriptionPeer::WINKS;
		}

	} 
	
	public function setCanReadMessages($v)
	{

		if ($this->can_read_messages !== $v || $v === false) {
			$this->can_read_messages = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_READ_MESSAGES;
		}

	} 
	
	public function setReadMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->read_messages !== $v || $v === 0) {
			$this->read_messages = $v;
			$this->modifiedColumns[] = SubscriptionPeer::READ_MESSAGES;
		}

	} 
	
	public function setCanReplyMessages($v)
	{

		if ($this->can_reply_messages !== $v || $v === false) {
			$this->can_reply_messages = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_REPLY_MESSAGES;
		}

	} 
	
	public function setReplyMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reply_messages !== $v || $v === 0) {
			$this->reply_messages = $v;
			$this->modifiedColumns[] = SubscriptionPeer::REPLY_MESSAGES;
		}

	} 
	
	public function setCanSendMessages($v)
	{

		if ($this->can_send_messages !== $v || $v === false) {
			$this->can_send_messages = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_SEND_MESSAGES;
		}

	} 
	
	public function setSendMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->send_messages !== $v || $v === 0) {
			$this->send_messages = $v;
			$this->modifiedColumns[] = SubscriptionPeer::SEND_MESSAGES;
		}

	} 
	
	public function setCanSeeViewed($v)
	{

		if ($this->can_see_viewed !== $v || $v === false) {
			$this->can_see_viewed = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_SEE_VIEWED;
		}

	} 
	
	public function setSeeViewed($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->see_viewed !== $v || $v === 0) {
			$this->see_viewed = $v;
			$this->modifiedColumns[] = SubscriptionPeer::SEE_VIEWED;
		}

	} 
	
	public function setCanContactAssistant($v)
	{

		if ($this->can_contact_assistant !== $v || $v === false) {
			$this->can_contact_assistant = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CAN_CONTACT_ASSISTANT;
		}

	} 
	
	public function setContactAssistant($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->contact_assistant !== $v || $v === 0) {
			$this->contact_assistant = $v;
			$this->modifiedColumns[] = SubscriptionPeer::CONTACT_ASSISTANT;
		}

	} 
	
	public function setPreApprove($v)
	{

		if ($this->pre_approve !== $v || $v === false) {
			$this->pre_approve = $v;
			$this->modifiedColumns[] = SubscriptionPeer::PRE_APPROVE;
		}

	} 
	
	public function setAmount($v)
	{

		if ($this->amount !== $v) {
			$this->amount = $v;
			$this->modifiedColumns[] = SubscriptionPeer::AMOUNT;
		}

	} 
	
	public function setPeriod($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->period !== $v) {
			$this->period = $v;
			$this->modifiedColumns[] = SubscriptionPeer::PERIOD;
		}

	} 
	
	public function setPeriodType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->period_type !== $v) {
			$this->period_type = $v;
			$this->modifiedColumns[] = SubscriptionPeer::PERIOD_TYPE;
		}

	} 
	
	public function setTrial1Amount($v)
	{

		if ($this->trial1_amount !== $v) {
			$this->trial1_amount = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TRIAL1_AMOUNT;
		}

	} 
	
	public function setTrial1Period($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->trial1_period !== $v) {
			$this->trial1_period = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TRIAL1_PERIOD;
		}

	} 
	
	public function setTrial1PeriodType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->trial1_period_type !== $v) {
			$this->trial1_period_type = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TRIAL1_PERIOD_TYPE;
		}

	} 
	
	public function setTrial2Amount($v)
	{

		if ($this->trial2_amount !== $v) {
			$this->trial2_amount = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TRIAL2_AMOUNT;
		}

	} 
	
	public function setTrial2Period($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->trial2_period !== $v) {
			$this->trial2_period = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TRIAL2_PERIOD;
		}

	} 
	
	public function setTrial2PeriodType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->trial2_period_type !== $v) {
			$this->trial2_period_type = $v;
			$this->modifiedColumns[] = SubscriptionPeer::TRIAL2_PERIOD_TYPE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->can_create_profile = $rs->getBoolean($startcol + 2);

			$this->create_profiles = $rs->getInt($startcol + 3);

			$this->can_post_photo = $rs->getBoolean($startcol + 4);

			$this->post_photos = $rs->getInt($startcol + 5);

			$this->can_wink = $rs->getBoolean($startcol + 6);

			$this->winks = $rs->getInt($startcol + 7);

			$this->can_read_messages = $rs->getBoolean($startcol + 8);

			$this->read_messages = $rs->getInt($startcol + 9);

			$this->can_reply_messages = $rs->getBoolean($startcol + 10);

			$this->reply_messages = $rs->getInt($startcol + 11);

			$this->can_send_messages = $rs->getBoolean($startcol + 12);

			$this->send_messages = $rs->getInt($startcol + 13);

			$this->can_see_viewed = $rs->getBoolean($startcol + 14);

			$this->see_viewed = $rs->getInt($startcol + 15);

			$this->can_contact_assistant = $rs->getBoolean($startcol + 16);

			$this->contact_assistant = $rs->getInt($startcol + 17);

			$this->pre_approve = $rs->getBoolean($startcol + 18);

			$this->amount = $rs->getFloat($startcol + 19);

			$this->period = $rs->getInt($startcol + 20);

			$this->period_type = $rs->getString($startcol + 21);

			$this->trial1_amount = $rs->getFloat($startcol + 22);

			$this->trial1_period = $rs->getInt($startcol + 23);

			$this->trial1_period_type = $rs->getString($startcol + 24);

			$this->trial2_amount = $rs->getFloat($startcol + 25);

			$this->trial2_period = $rs->getInt($startcol + 26);

			$this->trial2_period_type = $rs->getString($startcol + 27);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 28; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Subscription object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseSubscription:delete:pre') as $callable)
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
			$con = Propel::getConnection(SubscriptionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SubscriptionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseSubscription:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseSubscription:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SubscriptionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseSubscription:save:post') as $callable)
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SubscriptionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SubscriptionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMembers !== null) {
				foreach($this->collMembers as $referrerFK) {
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


			if (($retval = SubscriptionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMembers !== null) {
					foreach($this->collMembers as $referrerFK) {
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


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SubscriptionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTitle();
				break;
			case 2:
				return $this->getCanCreateProfile();
				break;
			case 3:
				return $this->getCreateProfiles();
				break;
			case 4:
				return $this->getCanPostPhoto();
				break;
			case 5:
				return $this->getPostPhotos();
				break;
			case 6:
				return $this->getCanWink();
				break;
			case 7:
				return $this->getWinks();
				break;
			case 8:
				return $this->getCanReadMessages();
				break;
			case 9:
				return $this->getReadMessages();
				break;
			case 10:
				return $this->getCanReplyMessages();
				break;
			case 11:
				return $this->getReplyMessages();
				break;
			case 12:
				return $this->getCanSendMessages();
				break;
			case 13:
				return $this->getSendMessages();
				break;
			case 14:
				return $this->getCanSeeViewed();
				break;
			case 15:
				return $this->getSeeViewed();
				break;
			case 16:
				return $this->getCanContactAssistant();
				break;
			case 17:
				return $this->getContactAssistant();
				break;
			case 18:
				return $this->getPreApprove();
				break;
			case 19:
				return $this->getAmount();
				break;
			case 20:
				return $this->getPeriod();
				break;
			case 21:
				return $this->getPeriodType();
				break;
			case 22:
				return $this->getTrial1Amount();
				break;
			case 23:
				return $this->getTrial1Period();
				break;
			case 24:
				return $this->getTrial1PeriodType();
				break;
			case 25:
				return $this->getTrial2Amount();
				break;
			case 26:
				return $this->getTrial2Period();
				break;
			case 27:
				return $this->getTrial2PeriodType();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SubscriptionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getCanCreateProfile(),
			$keys[3] => $this->getCreateProfiles(),
			$keys[4] => $this->getCanPostPhoto(),
			$keys[5] => $this->getPostPhotos(),
			$keys[6] => $this->getCanWink(),
			$keys[7] => $this->getWinks(),
			$keys[8] => $this->getCanReadMessages(),
			$keys[9] => $this->getReadMessages(),
			$keys[10] => $this->getCanReplyMessages(),
			$keys[11] => $this->getReplyMessages(),
			$keys[12] => $this->getCanSendMessages(),
			$keys[13] => $this->getSendMessages(),
			$keys[14] => $this->getCanSeeViewed(),
			$keys[15] => $this->getSeeViewed(),
			$keys[16] => $this->getCanContactAssistant(),
			$keys[17] => $this->getContactAssistant(),
			$keys[18] => $this->getPreApprove(),
			$keys[19] => $this->getAmount(),
			$keys[20] => $this->getPeriod(),
			$keys[21] => $this->getPeriodType(),
			$keys[22] => $this->getTrial1Amount(),
			$keys[23] => $this->getTrial1Period(),
			$keys[24] => $this->getTrial1PeriodType(),
			$keys[25] => $this->getTrial2Amount(),
			$keys[26] => $this->getTrial2Period(),
			$keys[27] => $this->getTrial2PeriodType(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SubscriptionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTitle($value);
				break;
			case 2:
				$this->setCanCreateProfile($value);
				break;
			case 3:
				$this->setCreateProfiles($value);
				break;
			case 4:
				$this->setCanPostPhoto($value);
				break;
			case 5:
				$this->setPostPhotos($value);
				break;
			case 6:
				$this->setCanWink($value);
				break;
			case 7:
				$this->setWinks($value);
				break;
			case 8:
				$this->setCanReadMessages($value);
				break;
			case 9:
				$this->setReadMessages($value);
				break;
			case 10:
				$this->setCanReplyMessages($value);
				break;
			case 11:
				$this->setReplyMessages($value);
				break;
			case 12:
				$this->setCanSendMessages($value);
				break;
			case 13:
				$this->setSendMessages($value);
				break;
			case 14:
				$this->setCanSeeViewed($value);
				break;
			case 15:
				$this->setSeeViewed($value);
				break;
			case 16:
				$this->setCanContactAssistant($value);
				break;
			case 17:
				$this->setContactAssistant($value);
				break;
			case 18:
				$this->setPreApprove($value);
				break;
			case 19:
				$this->setAmount($value);
				break;
			case 20:
				$this->setPeriod($value);
				break;
			case 21:
				$this->setPeriodType($value);
				break;
			case 22:
				$this->setTrial1Amount($value);
				break;
			case 23:
				$this->setTrial1Period($value);
				break;
			case 24:
				$this->setTrial1PeriodType($value);
				break;
			case 25:
				$this->setTrial2Amount($value);
				break;
			case 26:
				$this->setTrial2Period($value);
				break;
			case 27:
				$this->setTrial2PeriodType($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SubscriptionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCanCreateProfile($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreateProfiles($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCanPostPhoto($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPostPhotos($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCanWink($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setWinks($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCanReadMessages($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setReadMessages($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCanReplyMessages($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setReplyMessages($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCanSendMessages($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setSendMessages($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCanSeeViewed($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setSeeViewed($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setCanContactAssistant($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setContactAssistant($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setPreApprove($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setAmount($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setPeriod($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setPeriodType($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setTrial1Amount($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setTrial1Period($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setTrial1PeriodType($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setTrial2Amount($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setTrial2Period($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setTrial2PeriodType($arr[$keys[27]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);

		if ($this->isColumnModified(SubscriptionPeer::ID)) $criteria->add(SubscriptionPeer::ID, $this->id);
		if ($this->isColumnModified(SubscriptionPeer::TITLE)) $criteria->add(SubscriptionPeer::TITLE, $this->title);
		if ($this->isColumnModified(SubscriptionPeer::CAN_CREATE_PROFILE)) $criteria->add(SubscriptionPeer::CAN_CREATE_PROFILE, $this->can_create_profile);
		if ($this->isColumnModified(SubscriptionPeer::CREATE_PROFILES)) $criteria->add(SubscriptionPeer::CREATE_PROFILES, $this->create_profiles);
		if ($this->isColumnModified(SubscriptionPeer::CAN_POST_PHOTO)) $criteria->add(SubscriptionPeer::CAN_POST_PHOTO, $this->can_post_photo);
		if ($this->isColumnModified(SubscriptionPeer::POST_PHOTOS)) $criteria->add(SubscriptionPeer::POST_PHOTOS, $this->post_photos);
		if ($this->isColumnModified(SubscriptionPeer::CAN_WINK)) $criteria->add(SubscriptionPeer::CAN_WINK, $this->can_wink);
		if ($this->isColumnModified(SubscriptionPeer::WINKS)) $criteria->add(SubscriptionPeer::WINKS, $this->winks);
		if ($this->isColumnModified(SubscriptionPeer::CAN_READ_MESSAGES)) $criteria->add(SubscriptionPeer::CAN_READ_MESSAGES, $this->can_read_messages);
		if ($this->isColumnModified(SubscriptionPeer::READ_MESSAGES)) $criteria->add(SubscriptionPeer::READ_MESSAGES, $this->read_messages);
		if ($this->isColumnModified(SubscriptionPeer::CAN_REPLY_MESSAGES)) $criteria->add(SubscriptionPeer::CAN_REPLY_MESSAGES, $this->can_reply_messages);
		if ($this->isColumnModified(SubscriptionPeer::REPLY_MESSAGES)) $criteria->add(SubscriptionPeer::REPLY_MESSAGES, $this->reply_messages);
		if ($this->isColumnModified(SubscriptionPeer::CAN_SEND_MESSAGES)) $criteria->add(SubscriptionPeer::CAN_SEND_MESSAGES, $this->can_send_messages);
		if ($this->isColumnModified(SubscriptionPeer::SEND_MESSAGES)) $criteria->add(SubscriptionPeer::SEND_MESSAGES, $this->send_messages);
		if ($this->isColumnModified(SubscriptionPeer::CAN_SEE_VIEWED)) $criteria->add(SubscriptionPeer::CAN_SEE_VIEWED, $this->can_see_viewed);
		if ($this->isColumnModified(SubscriptionPeer::SEE_VIEWED)) $criteria->add(SubscriptionPeer::SEE_VIEWED, $this->see_viewed);
		if ($this->isColumnModified(SubscriptionPeer::CAN_CONTACT_ASSISTANT)) $criteria->add(SubscriptionPeer::CAN_CONTACT_ASSISTANT, $this->can_contact_assistant);
		if ($this->isColumnModified(SubscriptionPeer::CONTACT_ASSISTANT)) $criteria->add(SubscriptionPeer::CONTACT_ASSISTANT, $this->contact_assistant);
		if ($this->isColumnModified(SubscriptionPeer::PRE_APPROVE)) $criteria->add(SubscriptionPeer::PRE_APPROVE, $this->pre_approve);
		if ($this->isColumnModified(SubscriptionPeer::AMOUNT)) $criteria->add(SubscriptionPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(SubscriptionPeer::PERIOD)) $criteria->add(SubscriptionPeer::PERIOD, $this->period);
		if ($this->isColumnModified(SubscriptionPeer::PERIOD_TYPE)) $criteria->add(SubscriptionPeer::PERIOD_TYPE, $this->period_type);
		if ($this->isColumnModified(SubscriptionPeer::TRIAL1_AMOUNT)) $criteria->add(SubscriptionPeer::TRIAL1_AMOUNT, $this->trial1_amount);
		if ($this->isColumnModified(SubscriptionPeer::TRIAL1_PERIOD)) $criteria->add(SubscriptionPeer::TRIAL1_PERIOD, $this->trial1_period);
		if ($this->isColumnModified(SubscriptionPeer::TRIAL1_PERIOD_TYPE)) $criteria->add(SubscriptionPeer::TRIAL1_PERIOD_TYPE, $this->trial1_period_type);
		if ($this->isColumnModified(SubscriptionPeer::TRIAL2_AMOUNT)) $criteria->add(SubscriptionPeer::TRIAL2_AMOUNT, $this->trial2_amount);
		if ($this->isColumnModified(SubscriptionPeer::TRIAL2_PERIOD)) $criteria->add(SubscriptionPeer::TRIAL2_PERIOD, $this->trial2_period);
		if ($this->isColumnModified(SubscriptionPeer::TRIAL2_PERIOD_TYPE)) $criteria->add(SubscriptionPeer::TRIAL2_PERIOD_TYPE, $this->trial2_period_type);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);

		$criteria->add(SubscriptionPeer::ID, $this->id);

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

		$copyObj->setTitle($this->title);

		$copyObj->setCanCreateProfile($this->can_create_profile);

		$copyObj->setCreateProfiles($this->create_profiles);

		$copyObj->setCanPostPhoto($this->can_post_photo);

		$copyObj->setPostPhotos($this->post_photos);

		$copyObj->setCanWink($this->can_wink);

		$copyObj->setWinks($this->winks);

		$copyObj->setCanReadMessages($this->can_read_messages);

		$copyObj->setReadMessages($this->read_messages);

		$copyObj->setCanReplyMessages($this->can_reply_messages);

		$copyObj->setReplyMessages($this->reply_messages);

		$copyObj->setCanSendMessages($this->can_send_messages);

		$copyObj->setSendMessages($this->send_messages);

		$copyObj->setCanSeeViewed($this->can_see_viewed);

		$copyObj->setSeeViewed($this->see_viewed);

		$copyObj->setCanContactAssistant($this->can_contact_assistant);

		$copyObj->setContactAssistant($this->contact_assistant);

		$copyObj->setPreApprove($this->pre_approve);

		$copyObj->setAmount($this->amount);

		$copyObj->setPeriod($this->period);

		$copyObj->setPeriodType($this->period_type);

		$copyObj->setTrial1Amount($this->trial1_amount);

		$copyObj->setTrial1Period($this->trial1_period);

		$copyObj->setTrial1PeriodType($this->trial1_period_type);

		$copyObj->setTrial2Amount($this->trial2_amount);

		$copyObj->setTrial2Period($this->trial2_period);

		$copyObj->setTrial2PeriodType($this->trial2_period_type);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMembers() as $relObj) {
				$copyObj->addMember($relObj->copy($deepCopy));
			}

			foreach($this->getSubscriptionHistorys() as $relObj) {
				$copyObj->addSubscriptionHistory($relObj->copy($deepCopy));
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
			self::$peer = new SubscriptionPeer();
		}
		return self::$peer;
	}

	
	public function initMembers()
	{
		if ($this->collMembers === null) {
			$this->collMembers = array();
		}
	}

	
	public function getMembers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
			   $this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				$this->collMembers = MemberPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
					$this->collMembers = MemberPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberCriteria = $criteria;
		return $this->collMembers;
	}

	
	public function countMembers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

		return MemberPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMember(Member $l)
	{
		$this->collMembers[] = $l;
		$l->setSubscription($this);
	}


	
	public function getMembersJoinMemberStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinState($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinMemberPhoto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinMemberCounter($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
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

				$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

				SubscriptionHistoryPeer::addSelectColumns($criteria);
				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

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

		$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

		return SubscriptionHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSubscriptionHistory(SubscriptionHistory $l)
	{
		$this->collSubscriptionHistorys[] = $l;
		$l->setSubscription($this);
	}


	
	public function getSubscriptionHistorysJoinMember($criteria = null, $con = null)
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

				$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelectJoinMember($criteria, $con);
			}
		} else {
									
			$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastSubscriptionHistoryCriteria) || !$this->lastSubscriptionHistoryCriteria->equals($criteria)) {
				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelectJoinMember($criteria, $con);
			}
		}
		$this->lastSubscriptionHistoryCriteria = $criteria;

		return $this->collSubscriptionHistorys;
	}


	
	public function getSubscriptionHistorysJoinMemberStatus($criteria = null, $con = null)
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

				$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(SubscriptionHistoryPeer::SUBSCRIPTION_ID, $this->getId());

			if (!isset($this->lastSubscriptionHistoryCriteria) || !$this->lastSubscriptionHistoryCriteria->equals($criteria)) {
				$this->collSubscriptionHistorys = SubscriptionHistoryPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		}
		$this->lastSubscriptionHistoryCriteria = $criteria;

		return $this->collSubscriptionHistorys;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseSubscription:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseSubscription::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 