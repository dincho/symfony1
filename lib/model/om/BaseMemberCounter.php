<?php


abstract class BaseMemberCounter extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $current_flags = 0;


	
	protected $total_flags = 0;


	
	protected $sent_flags = 0;


	
	protected $sent_winks = 0;


	
	protected $received_winks = 0;


	
	protected $read_messages = 0;


	
	protected $sent_messages = 0;


	
	protected $received_messages = 0;


	
	protected $reply_messages = 0;


	
	protected $unsuspensions = 0;


	
	protected $assistant_contacts = 0;


	
	protected $profile_views = 0;


	
	protected $made_profile_views = 0;


	
	protected $hotlist = 0;


	
	protected $on_others_hotlist = 0;

	
	protected $collMembers;

	
	protected $lastMemberCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCurrentFlags()
	{

		return $this->current_flags;
	}

	
	public function getTotalFlags()
	{

		return $this->total_flags;
	}

	
	public function getSentFlags()
	{

		return $this->sent_flags;
	}

	
	public function getSentWinks()
	{

		return $this->sent_winks;
	}

	
	public function getReceivedWinks()
	{

		return $this->received_winks;
	}

	
	public function getReadMessages()
	{

		return $this->read_messages;
	}

	
	public function getSentMessages()
	{

		return $this->sent_messages;
	}

	
	public function getReceivedMessages()
	{

		return $this->received_messages;
	}

	
	public function getReplyMessages()
	{

		return $this->reply_messages;
	}

	
	public function getUnsuspensions()
	{

		return $this->unsuspensions;
	}

	
	public function getAssistantContacts()
	{

		return $this->assistant_contacts;
	}

	
	public function getProfileViews()
	{

		return $this->profile_views;
	}

	
	public function getMadeProfileViews()
	{

		return $this->made_profile_views;
	}

	
	public function getHotlist()
	{

		return $this->hotlist;
	}

	
	public function getOnOthersHotlist()
	{

		return $this->on_others_hotlist;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberCounterPeer::ID;
		}

	} 
	
	public function setCurrentFlags($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->current_flags !== $v || $v === 0) {
			$this->current_flags = $v;
			$this->modifiedColumns[] = MemberCounterPeer::CURRENT_FLAGS;
		}

	} 
	
	public function setTotalFlags($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_flags !== $v || $v === 0) {
			$this->total_flags = $v;
			$this->modifiedColumns[] = MemberCounterPeer::TOTAL_FLAGS;
		}

	} 
	
	public function setSentFlags($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sent_flags !== $v || $v === 0) {
			$this->sent_flags = $v;
			$this->modifiedColumns[] = MemberCounterPeer::SENT_FLAGS;
		}

	} 
	
	public function setSentWinks($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sent_winks !== $v || $v === 0) {
			$this->sent_winks = $v;
			$this->modifiedColumns[] = MemberCounterPeer::SENT_WINKS;
		}

	} 
	
	public function setReceivedWinks($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->received_winks !== $v || $v === 0) {
			$this->received_winks = $v;
			$this->modifiedColumns[] = MemberCounterPeer::RECEIVED_WINKS;
		}

	} 
	
	public function setReadMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->read_messages !== $v || $v === 0) {
			$this->read_messages = $v;
			$this->modifiedColumns[] = MemberCounterPeer::READ_MESSAGES;
		}

	} 
	
	public function setSentMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sent_messages !== $v || $v === 0) {
			$this->sent_messages = $v;
			$this->modifiedColumns[] = MemberCounterPeer::SENT_MESSAGES;
		}

	} 
	
	public function setReceivedMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->received_messages !== $v || $v === 0) {
			$this->received_messages = $v;
			$this->modifiedColumns[] = MemberCounterPeer::RECEIVED_MESSAGES;
		}

	} 
	
	public function setReplyMessages($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reply_messages !== $v || $v === 0) {
			$this->reply_messages = $v;
			$this->modifiedColumns[] = MemberCounterPeer::REPLY_MESSAGES;
		}

	} 
	
	public function setUnsuspensions($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->unsuspensions !== $v || $v === 0) {
			$this->unsuspensions = $v;
			$this->modifiedColumns[] = MemberCounterPeer::UNSUSPENSIONS;
		}

	} 
	
	public function setAssistantContacts($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->assistant_contacts !== $v || $v === 0) {
			$this->assistant_contacts = $v;
			$this->modifiedColumns[] = MemberCounterPeer::ASSISTANT_CONTACTS;
		}

	} 
	
	public function setProfileViews($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->profile_views !== $v || $v === 0) {
			$this->profile_views = $v;
			$this->modifiedColumns[] = MemberCounterPeer::PROFILE_VIEWS;
		}

	} 
	
	public function setMadeProfileViews($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->made_profile_views !== $v || $v === 0) {
			$this->made_profile_views = $v;
			$this->modifiedColumns[] = MemberCounterPeer::MADE_PROFILE_VIEWS;
		}

	} 
	
	public function setHotlist($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->hotlist !== $v || $v === 0) {
			$this->hotlist = $v;
			$this->modifiedColumns[] = MemberCounterPeer::HOTLIST;
		}

	} 
	
	public function setOnOthersHotlist($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->on_others_hotlist !== $v || $v === 0) {
			$this->on_others_hotlist = $v;
			$this->modifiedColumns[] = MemberCounterPeer::ON_OTHERS_HOTLIST;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->current_flags = $rs->getInt($startcol + 1);

			$this->total_flags = $rs->getInt($startcol + 2);

			$this->sent_flags = $rs->getInt($startcol + 3);

			$this->sent_winks = $rs->getInt($startcol + 4);

			$this->received_winks = $rs->getInt($startcol + 5);

			$this->read_messages = $rs->getInt($startcol + 6);

			$this->sent_messages = $rs->getInt($startcol + 7);

			$this->received_messages = $rs->getInt($startcol + 8);

			$this->reply_messages = $rs->getInt($startcol + 9);

			$this->unsuspensions = $rs->getInt($startcol + 10);

			$this->assistant_contacts = $rs->getInt($startcol + 11);

			$this->profile_views = $rs->getInt($startcol + 12);

			$this->made_profile_views = $rs->getInt($startcol + 13);

			$this->hotlist = $rs->getInt($startcol + 14);

			$this->on_others_hotlist = $rs->getInt($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MemberCounter object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberCounter:delete:pre') as $callable)
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
			$con = Propel::getConnection(MemberCounterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberCounterPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMemberCounter:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberCounter:save:pre') as $callable)
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
			$con = Propel::getConnection(MemberCounterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMemberCounter:save:post') as $callable)
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
					$pk = MemberCounterPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberCounterPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMembers !== null) {
				foreach($this->collMembers as $referrerFK) {
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


			if (($retval = MemberCounterPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMembers !== null) {
					foreach($this->collMembers as $referrerFK) {
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
		$pos = MemberCounterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCurrentFlags();
				break;
			case 2:
				return $this->getTotalFlags();
				break;
			case 3:
				return $this->getSentFlags();
				break;
			case 4:
				return $this->getSentWinks();
				break;
			case 5:
				return $this->getReceivedWinks();
				break;
			case 6:
				return $this->getReadMessages();
				break;
			case 7:
				return $this->getSentMessages();
				break;
			case 8:
				return $this->getReceivedMessages();
				break;
			case 9:
				return $this->getReplyMessages();
				break;
			case 10:
				return $this->getUnsuspensions();
				break;
			case 11:
				return $this->getAssistantContacts();
				break;
			case 12:
				return $this->getProfileViews();
				break;
			case 13:
				return $this->getMadeProfileViews();
				break;
			case 14:
				return $this->getHotlist();
				break;
			case 15:
				return $this->getOnOthersHotlist();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberCounterPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCurrentFlags(),
			$keys[2] => $this->getTotalFlags(),
			$keys[3] => $this->getSentFlags(),
			$keys[4] => $this->getSentWinks(),
			$keys[5] => $this->getReceivedWinks(),
			$keys[6] => $this->getReadMessages(),
			$keys[7] => $this->getSentMessages(),
			$keys[8] => $this->getReceivedMessages(),
			$keys[9] => $this->getReplyMessages(),
			$keys[10] => $this->getUnsuspensions(),
			$keys[11] => $this->getAssistantContacts(),
			$keys[12] => $this->getProfileViews(),
			$keys[13] => $this->getMadeProfileViews(),
			$keys[14] => $this->getHotlist(),
			$keys[15] => $this->getOnOthersHotlist(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberCounterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCurrentFlags($value);
				break;
			case 2:
				$this->setTotalFlags($value);
				break;
			case 3:
				$this->setSentFlags($value);
				break;
			case 4:
				$this->setSentWinks($value);
				break;
			case 5:
				$this->setReceivedWinks($value);
				break;
			case 6:
				$this->setReadMessages($value);
				break;
			case 7:
				$this->setSentMessages($value);
				break;
			case 8:
				$this->setReceivedMessages($value);
				break;
			case 9:
				$this->setReplyMessages($value);
				break;
			case 10:
				$this->setUnsuspensions($value);
				break;
			case 11:
				$this->setAssistantContacts($value);
				break;
			case 12:
				$this->setProfileViews($value);
				break;
			case 13:
				$this->setMadeProfileViews($value);
				break;
			case 14:
				$this->setHotlist($value);
				break;
			case 15:
				$this->setOnOthersHotlist($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberCounterPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCurrentFlags($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTotalFlags($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSentFlags($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSentWinks($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setReceivedWinks($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setReadMessages($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setSentMessages($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setReceivedMessages($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setReplyMessages($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUnsuspensions($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAssistantContacts($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setProfileViews($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setMadeProfileViews($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setHotlist($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setOnOthersHotlist($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberCounterPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberCounterPeer::ID)) $criteria->add(MemberCounterPeer::ID, $this->id);
		if ($this->isColumnModified(MemberCounterPeer::CURRENT_FLAGS)) $criteria->add(MemberCounterPeer::CURRENT_FLAGS, $this->current_flags);
		if ($this->isColumnModified(MemberCounterPeer::TOTAL_FLAGS)) $criteria->add(MemberCounterPeer::TOTAL_FLAGS, $this->total_flags);
		if ($this->isColumnModified(MemberCounterPeer::SENT_FLAGS)) $criteria->add(MemberCounterPeer::SENT_FLAGS, $this->sent_flags);
		if ($this->isColumnModified(MemberCounterPeer::SENT_WINKS)) $criteria->add(MemberCounterPeer::SENT_WINKS, $this->sent_winks);
		if ($this->isColumnModified(MemberCounterPeer::RECEIVED_WINKS)) $criteria->add(MemberCounterPeer::RECEIVED_WINKS, $this->received_winks);
		if ($this->isColumnModified(MemberCounterPeer::READ_MESSAGES)) $criteria->add(MemberCounterPeer::READ_MESSAGES, $this->read_messages);
		if ($this->isColumnModified(MemberCounterPeer::SENT_MESSAGES)) $criteria->add(MemberCounterPeer::SENT_MESSAGES, $this->sent_messages);
		if ($this->isColumnModified(MemberCounterPeer::RECEIVED_MESSAGES)) $criteria->add(MemberCounterPeer::RECEIVED_MESSAGES, $this->received_messages);
		if ($this->isColumnModified(MemberCounterPeer::REPLY_MESSAGES)) $criteria->add(MemberCounterPeer::REPLY_MESSAGES, $this->reply_messages);
		if ($this->isColumnModified(MemberCounterPeer::UNSUSPENSIONS)) $criteria->add(MemberCounterPeer::UNSUSPENSIONS, $this->unsuspensions);
		if ($this->isColumnModified(MemberCounterPeer::ASSISTANT_CONTACTS)) $criteria->add(MemberCounterPeer::ASSISTANT_CONTACTS, $this->assistant_contacts);
		if ($this->isColumnModified(MemberCounterPeer::PROFILE_VIEWS)) $criteria->add(MemberCounterPeer::PROFILE_VIEWS, $this->profile_views);
		if ($this->isColumnModified(MemberCounterPeer::MADE_PROFILE_VIEWS)) $criteria->add(MemberCounterPeer::MADE_PROFILE_VIEWS, $this->made_profile_views);
		if ($this->isColumnModified(MemberCounterPeer::HOTLIST)) $criteria->add(MemberCounterPeer::HOTLIST, $this->hotlist);
		if ($this->isColumnModified(MemberCounterPeer::ON_OTHERS_HOTLIST)) $criteria->add(MemberCounterPeer::ON_OTHERS_HOTLIST, $this->on_others_hotlist);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberCounterPeer::DATABASE_NAME);

		$criteria->add(MemberCounterPeer::ID, $this->id);

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

		$copyObj->setCurrentFlags($this->current_flags);

		$copyObj->setTotalFlags($this->total_flags);

		$copyObj->setSentFlags($this->sent_flags);

		$copyObj->setSentWinks($this->sent_winks);

		$copyObj->setReceivedWinks($this->received_winks);

		$copyObj->setReadMessages($this->read_messages);

		$copyObj->setSentMessages($this->sent_messages);

		$copyObj->setReceivedMessages($this->received_messages);

		$copyObj->setReplyMessages($this->reply_messages);

		$copyObj->setUnsuspensions($this->unsuspensions);

		$copyObj->setAssistantContacts($this->assistant_contacts);

		$copyObj->setProfileViews($this->profile_views);

		$copyObj->setMadeProfileViews($this->made_profile_views);

		$copyObj->setHotlist($this->hotlist);

		$copyObj->setOnOthersHotlist($this->on_others_hotlist);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMembers() as $relObj) {
				$copyObj->addMember($relObj->copy($deepCopy));
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
			self::$peer = new MemberCounterPeer();
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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				$this->collMembers = MemberPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

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

		$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

		return MemberPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMember(Member $l)
	{
		$this->collMembers[] = $l;
		$l->setMemberCounter($this);
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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinSearchCriteria($criteria = null, $con = null)
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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinSearchCriteria($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinSearchCriteria($criteria, $con);
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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinSubscription($criteria = null, $con = null)
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

				$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::MEMBER_COUNTER_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMemberCounter:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMemberCounter::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 