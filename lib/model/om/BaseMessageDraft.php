<?php


abstract class BaseMessageDraft extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $from_member_id;


	
	protected $to_member_id;


	
	protected $subject;


	
	protected $content;


	
	protected $reply_to;


	
	protected $updated_at;

	
	protected $aMemberRelatedByFromMemberId;

	
	protected $aMemberRelatedByToMemberId;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFromMemberId()
	{

		return $this->from_member_id;
	}

	
	public function getToMemberId()
	{

		return $this->to_member_id;
	}

	
	public function getSubject()
	{

		return $this->subject;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getReplyTo()
	{

		return $this->reply_to;
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
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
			$this->modifiedColumns[] = MessageDraftPeer::ID;
		}

	} 
	
	public function setFromMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->from_member_id !== $v) {
			$this->from_member_id = $v;
			$this->modifiedColumns[] = MessageDraftPeer::FROM_MEMBER_ID;
		}

		if ($this->aMemberRelatedByFromMemberId !== null && $this->aMemberRelatedByFromMemberId->getId() !== $v) {
			$this->aMemberRelatedByFromMemberId = null;
		}

	} 
	
	public function setToMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->to_member_id !== $v) {
			$this->to_member_id = $v;
			$this->modifiedColumns[] = MessageDraftPeer::TO_MEMBER_ID;
		}

		if ($this->aMemberRelatedByToMemberId !== null && $this->aMemberRelatedByToMemberId->getId() !== $v) {
			$this->aMemberRelatedByToMemberId = null;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = MessageDraftPeer::SUBJECT;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = MessageDraftPeer::CONTENT;
		}

	} 
	
	public function setReplyTo($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reply_to !== $v) {
			$this->reply_to = $v;
			$this->modifiedColumns[] = MessageDraftPeer::REPLY_TO;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = MessageDraftPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->from_member_id = $rs->getInt($startcol + 1);

			$this->to_member_id = $rs->getInt($startcol + 2);

			$this->subject = $rs->getString($startcol + 3);

			$this->content = $rs->getString($startcol + 4);

			$this->reply_to = $rs->getInt($startcol + 5);

			$this->updated_at = $rs->getTimestamp($startcol + 6, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MessageDraft object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessageDraft:delete:pre') as $callable)
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
			$con = Propel::getConnection(MessageDraftPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MessageDraftPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMessageDraft:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessageDraft:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isModified() && !$this->isColumnModified(MessageDraftPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MessageDraftPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMessageDraft:save:post') as $callable)
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


												
			if ($this->aMemberRelatedByFromMemberId !== null) {
				if ($this->aMemberRelatedByFromMemberId->isModified()) {
					$affectedRows += $this->aMemberRelatedByFromMemberId->save($con);
				}
				$this->setMemberRelatedByFromMemberId($this->aMemberRelatedByFromMemberId);
			}

			if ($this->aMemberRelatedByToMemberId !== null) {
				if ($this->aMemberRelatedByToMemberId->isModified()) {
					$affectedRows += $this->aMemberRelatedByToMemberId->save($con);
				}
				$this->setMemberRelatedByToMemberId($this->aMemberRelatedByToMemberId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MessageDraftPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MessageDraftPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->aMemberRelatedByFromMemberId !== null) {
				if (!$this->aMemberRelatedByFromMemberId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByFromMemberId->getValidationFailures());
				}
			}

			if ($this->aMemberRelatedByToMemberId !== null) {
				if (!$this->aMemberRelatedByToMemberId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByToMemberId->getValidationFailures());
				}
			}


			if (($retval = MessageDraftPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessageDraftPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFromMemberId();
				break;
			case 2:
				return $this->getToMemberId();
				break;
			case 3:
				return $this->getSubject();
				break;
			case 4:
				return $this->getContent();
				break;
			case 5:
				return $this->getReplyTo();
				break;
			case 6:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessageDraftPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFromMemberId(),
			$keys[2] => $this->getToMemberId(),
			$keys[3] => $this->getSubject(),
			$keys[4] => $this->getContent(),
			$keys[5] => $this->getReplyTo(),
			$keys[6] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessageDraftPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFromMemberId($value);
				break;
			case 2:
				$this->setToMemberId($value);
				break;
			case 3:
				$this->setSubject($value);
				break;
			case 4:
				$this->setContent($value);
				break;
			case 5:
				$this->setReplyTo($value);
				break;
			case 6:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessageDraftPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFromMemberId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setToMemberId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSubject($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setReplyTo($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MessageDraftPeer::DATABASE_NAME);

		if ($this->isColumnModified(MessageDraftPeer::ID)) $criteria->add(MessageDraftPeer::ID, $this->id);
		if ($this->isColumnModified(MessageDraftPeer::FROM_MEMBER_ID)) $criteria->add(MessageDraftPeer::FROM_MEMBER_ID, $this->from_member_id);
		if ($this->isColumnModified(MessageDraftPeer::TO_MEMBER_ID)) $criteria->add(MessageDraftPeer::TO_MEMBER_ID, $this->to_member_id);
		if ($this->isColumnModified(MessageDraftPeer::SUBJECT)) $criteria->add(MessageDraftPeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(MessageDraftPeer::CONTENT)) $criteria->add(MessageDraftPeer::CONTENT, $this->content);
		if ($this->isColumnModified(MessageDraftPeer::REPLY_TO)) $criteria->add(MessageDraftPeer::REPLY_TO, $this->reply_to);
		if ($this->isColumnModified(MessageDraftPeer::UPDATED_AT)) $criteria->add(MessageDraftPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MessageDraftPeer::DATABASE_NAME);

		$criteria->add(MessageDraftPeer::ID, $this->id);

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

		$copyObj->setFromMemberId($this->from_member_id);

		$copyObj->setToMemberId($this->to_member_id);

		$copyObj->setSubject($this->subject);

		$copyObj->setContent($this->content);

		$copyObj->setReplyTo($this->reply_to);

		$copyObj->setUpdatedAt($this->updated_at);


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
			self::$peer = new MessageDraftPeer();
		}
		return self::$peer;
	}

	
	public function setMemberRelatedByFromMemberId($v)
	{


		if ($v === null) {
			$this->setFromMemberId(NULL);
		} else {
			$this->setFromMemberId($v->getId());
		}


		$this->aMemberRelatedByFromMemberId = $v;
	}


	
	public function getMemberRelatedByFromMemberId($con = null)
	{
		if ($this->aMemberRelatedByFromMemberId === null && ($this->from_member_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByFromMemberId = MemberPeer::retrieveByPK($this->from_member_id, $con);

			
		}
		return $this->aMemberRelatedByFromMemberId;
	}

	
	public function setMemberRelatedByToMemberId($v)
	{


		if ($v === null) {
			$this->setToMemberId(NULL);
		} else {
			$this->setToMemberId($v->getId());
		}


		$this->aMemberRelatedByToMemberId = $v;
	}


	
	public function getMemberRelatedByToMemberId($con = null)
	{
		if ($this->aMemberRelatedByToMemberId === null && ($this->to_member_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByToMemberId = MemberPeer::retrieveByPK($this->to_member_id, $con);

			
		}
		return $this->aMemberRelatedByToMemberId;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMessageDraft:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMessageDraft::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 