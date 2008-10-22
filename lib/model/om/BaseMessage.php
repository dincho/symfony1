<?php


abstract class BaseMessage extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $from_member_id;


	
	protected $to_member_id;


	
	protected $subject;


	
	protected $content;


	
	protected $sent_box = false;


	
	protected $is_read = false;


	
	protected $is_reviewed = false;


	
	protected $created_at;

	
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

	
	public function getSentBox()
	{

		return $this->sent_box;
	}

	
	public function getIsRead()
	{

		return $this->is_read;
	}

	
	public function getIsReviewed()
	{

		return $this->is_reviewed;
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
			$this->modifiedColumns[] = MessagePeer::ID;
		}

	} 
	
	public function setFromMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->from_member_id !== $v) {
			$this->from_member_id = $v;
			$this->modifiedColumns[] = MessagePeer::FROM_MEMBER_ID;
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
			$this->modifiedColumns[] = MessagePeer::TO_MEMBER_ID;
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
			$this->modifiedColumns[] = MessagePeer::SUBJECT;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = MessagePeer::CONTENT;
		}

	} 
	
	public function setSentBox($v)
	{

		if ($this->sent_box !== $v || $v === false) {
			$this->sent_box = $v;
			$this->modifiedColumns[] = MessagePeer::SENT_BOX;
		}

	} 
	
	public function setIsRead($v)
	{

		if ($this->is_read !== $v || $v === false) {
			$this->is_read = $v;
			$this->modifiedColumns[] = MessagePeer::IS_READ;
		}

	} 
	
	public function setIsReviewed($v)
	{

		if ($this->is_reviewed !== $v || $v === false) {
			$this->is_reviewed = $v;
			$this->modifiedColumns[] = MessagePeer::IS_REVIEWED;
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
			$this->modifiedColumns[] = MessagePeer::CREATED_AT;
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

			$this->sent_box = $rs->getBoolean($startcol + 5);

			$this->is_read = $rs->getBoolean($startcol + 6);

			$this->is_reviewed = $rs->getBoolean($startcol + 7);

			$this->created_at = $rs->getTimestamp($startcol + 8, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Message object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessage:delete:pre') as $callable)
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
			$con = Propel::getConnection(MessagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MessagePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMessage:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessage:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(MessagePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MessagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMessage:save:post') as $callable)
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
					$pk = MessagePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MessagePeer::doUpdate($this, $con);
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


			if (($retval = MessagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSentBox();
				break;
			case 6:
				return $this->getIsRead();
				break;
			case 7:
				return $this->getIsReviewed();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFromMemberId(),
			$keys[2] => $this->getToMemberId(),
			$keys[3] => $this->getSubject(),
			$keys[4] => $this->getContent(),
			$keys[5] => $this->getSentBox(),
			$keys[6] => $this->getIsRead(),
			$keys[7] => $this->getIsReviewed(),
			$keys[8] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSentBox($value);
				break;
			case 6:
				$this->setIsRead($value);
				break;
			case 7:
				$this->setIsReviewed($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFromMemberId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setToMemberId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSubject($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSentBox($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsRead($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsReviewed($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MessagePeer::DATABASE_NAME);

		if ($this->isColumnModified(MessagePeer::ID)) $criteria->add(MessagePeer::ID, $this->id);
		if ($this->isColumnModified(MessagePeer::FROM_MEMBER_ID)) $criteria->add(MessagePeer::FROM_MEMBER_ID, $this->from_member_id);
		if ($this->isColumnModified(MessagePeer::TO_MEMBER_ID)) $criteria->add(MessagePeer::TO_MEMBER_ID, $this->to_member_id);
		if ($this->isColumnModified(MessagePeer::SUBJECT)) $criteria->add(MessagePeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(MessagePeer::CONTENT)) $criteria->add(MessagePeer::CONTENT, $this->content);
		if ($this->isColumnModified(MessagePeer::SENT_BOX)) $criteria->add(MessagePeer::SENT_BOX, $this->sent_box);
		if ($this->isColumnModified(MessagePeer::IS_READ)) $criteria->add(MessagePeer::IS_READ, $this->is_read);
		if ($this->isColumnModified(MessagePeer::IS_REVIEWED)) $criteria->add(MessagePeer::IS_REVIEWED, $this->is_reviewed);
		if ($this->isColumnModified(MessagePeer::CREATED_AT)) $criteria->add(MessagePeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MessagePeer::DATABASE_NAME);

		$criteria->add(MessagePeer::ID, $this->id);

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

		$copyObj->setSentBox($this->sent_box);

		$copyObj->setIsRead($this->is_read);

		$copyObj->setIsReviewed($this->is_reviewed);

		$copyObj->setCreatedAt($this->created_at);


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
			self::$peer = new MessagePeer();
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
    if (!$callable = sfMixer::getCallable('BaseMessage:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMessage::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 