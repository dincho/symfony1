<?php


abstract class BaseWink extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_id;


	
	protected $profile_id;


	
	protected $sent_box = false;


	
	protected $created_at;


	
	protected $deleted_at;

	
	protected $aMemberRelatedByMemberId;

	
	protected $aMemberRelatedByProfileId;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMemberId()
	{

		return $this->member_id;
	}

	
	public function getProfileId()
	{

		return $this->profile_id;
	}

	
	public function getSentBox()
	{

		return $this->sent_box;
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

	
	public function getDeletedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->deleted_at === null || $this->deleted_at === '') {
			return null;
		} elseif (!is_int($this->deleted_at)) {
						$ts = strtotime($this->deleted_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [deleted_at] as date/time value: " . var_export($this->deleted_at, true));
			}
		} else {
			$ts = $this->deleted_at;
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
			$this->modifiedColumns[] = WinkPeer::ID;
		}

	} 
	
	public function setMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = WinkPeer::MEMBER_ID;
		}

		if ($this->aMemberRelatedByMemberId !== null && $this->aMemberRelatedByMemberId->getId() !== $v) {
			$this->aMemberRelatedByMemberId = null;
		}

	} 
	
	public function setProfileId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->profile_id !== $v) {
			$this->profile_id = $v;
			$this->modifiedColumns[] = WinkPeer::PROFILE_ID;
		}

		if ($this->aMemberRelatedByProfileId !== null && $this->aMemberRelatedByProfileId->getId() !== $v) {
			$this->aMemberRelatedByProfileId = null;
		}

	} 
	
	public function setSentBox($v)
	{

		if ($this->sent_box !== $v || $v === false) {
			$this->sent_box = $v;
			$this->modifiedColumns[] = WinkPeer::SENT_BOX;
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
			$this->modifiedColumns[] = WinkPeer::CREATED_AT;
		}

	} 
	
	public function setDeletedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [deleted_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->deleted_at !== $ts) {
			$this->deleted_at = $ts;
			$this->modifiedColumns[] = WinkPeer::DELETED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_id = $rs->getInt($startcol + 1);

			$this->profile_id = $rs->getInt($startcol + 2);

			$this->sent_box = $rs->getBoolean($startcol + 3);

			$this->created_at = $rs->getTimestamp($startcol + 4, null);

			$this->deleted_at = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Wink object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseWink:delete:pre') as $callable)
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
			$con = Propel::getConnection(WinkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			WinkPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseWink:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseWink:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(WinkPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(WinkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseWink:save:post') as $callable)
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


												
			if ($this->aMemberRelatedByMemberId !== null) {
				if ($this->aMemberRelatedByMemberId->isModified()) {
					$affectedRows += $this->aMemberRelatedByMemberId->save($con);
				}
				$this->setMemberRelatedByMemberId($this->aMemberRelatedByMemberId);
			}

			if ($this->aMemberRelatedByProfileId !== null) {
				if ($this->aMemberRelatedByProfileId->isModified()) {
					$affectedRows += $this->aMemberRelatedByProfileId->save($con);
				}
				$this->setMemberRelatedByProfileId($this->aMemberRelatedByProfileId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = WinkPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += WinkPeer::doUpdate($this, $con);
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


												
			if ($this->aMemberRelatedByMemberId !== null) {
				if (!$this->aMemberRelatedByMemberId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByMemberId->getValidationFailures());
				}
			}

			if ($this->aMemberRelatedByProfileId !== null) {
				if (!$this->aMemberRelatedByProfileId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByProfileId->getValidationFailures());
				}
			}


			if (($retval = WinkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = WinkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMemberId();
				break;
			case 2:
				return $this->getProfileId();
				break;
			case 3:
				return $this->getSentBox();
				break;
			case 4:
				return $this->getCreatedAt();
				break;
			case 5:
				return $this->getDeletedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = WinkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberId(),
			$keys[2] => $this->getProfileId(),
			$keys[3] => $this->getSentBox(),
			$keys[4] => $this->getCreatedAt(),
			$keys[5] => $this->getDeletedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = WinkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMemberId($value);
				break;
			case 2:
				$this->setProfileId($value);
				break;
			case 3:
				$this->setSentBox($value);
				break;
			case 4:
				$this->setCreatedAt($value);
				break;
			case 5:
				$this->setDeletedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = WinkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setProfileId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSentBox($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDeletedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(WinkPeer::DATABASE_NAME);

		if ($this->isColumnModified(WinkPeer::ID)) $criteria->add(WinkPeer::ID, $this->id);
		if ($this->isColumnModified(WinkPeer::MEMBER_ID)) $criteria->add(WinkPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(WinkPeer::PROFILE_ID)) $criteria->add(WinkPeer::PROFILE_ID, $this->profile_id);
		if ($this->isColumnModified(WinkPeer::SENT_BOX)) $criteria->add(WinkPeer::SENT_BOX, $this->sent_box);
		if ($this->isColumnModified(WinkPeer::CREATED_AT)) $criteria->add(WinkPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(WinkPeer::DELETED_AT)) $criteria->add(WinkPeer::DELETED_AT, $this->deleted_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(WinkPeer::DATABASE_NAME);

		$criteria->add(WinkPeer::ID, $this->id);

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

		$copyObj->setMemberId($this->member_id);

		$copyObj->setProfileId($this->profile_id);

		$copyObj->setSentBox($this->sent_box);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setDeletedAt($this->deleted_at);


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
			self::$peer = new WinkPeer();
		}
		return self::$peer;
	}

	
	public function setMemberRelatedByMemberId($v)
	{


		if ($v === null) {
			$this->setMemberId(NULL);
		} else {
			$this->setMemberId($v->getId());
		}


		$this->aMemberRelatedByMemberId = $v;
	}


	
	public function getMemberRelatedByMemberId($con = null)
	{
		if ($this->aMemberRelatedByMemberId === null && ($this->member_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByMemberId = MemberPeer::retrieveByPK($this->member_id, $con);

			
		}
		return $this->aMemberRelatedByMemberId;
	}

	
	public function setMemberRelatedByProfileId($v)
	{


		if ($v === null) {
			$this->setProfileId(NULL);
		} else {
			$this->setProfileId($v->getId());
		}


		$this->aMemberRelatedByProfileId = $v;
	}


	
	public function getMemberRelatedByProfileId($con = null)
	{
		if ($this->aMemberRelatedByProfileId === null && ($this->profile_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByProfileId = MemberPeer::retrieveByPK($this->profile_id, $con);

			
		}
		return $this->aMemberRelatedByProfileId;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseWink:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseWink::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 