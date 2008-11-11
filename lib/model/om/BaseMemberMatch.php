<?php


abstract class BaseMemberMatch extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member1_id;


	
	protected $member2_id;


	
	protected $pct = 0;

	
	protected $aMemberRelatedByMember1Id;

	
	protected $aMemberRelatedByMember2Id;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMember1Id()
	{

		return $this->member1_id;
	}

	
	public function getMember2Id()
	{

		return $this->member2_id;
	}

	
	public function getPct()
	{

		return $this->pct;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberMatchPeer::ID;
		}

	} 
	
	public function setMember1Id($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member1_id !== $v) {
			$this->member1_id = $v;
			$this->modifiedColumns[] = MemberMatchPeer::MEMBER1_ID;
		}

		if ($this->aMemberRelatedByMember1Id !== null && $this->aMemberRelatedByMember1Id->getId() !== $v) {
			$this->aMemberRelatedByMember1Id = null;
		}

	} 
	
	public function setMember2Id($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member2_id !== $v) {
			$this->member2_id = $v;
			$this->modifiedColumns[] = MemberMatchPeer::MEMBER2_ID;
		}

		if ($this->aMemberRelatedByMember2Id !== null && $this->aMemberRelatedByMember2Id->getId() !== $v) {
			$this->aMemberRelatedByMember2Id = null;
		}

	} 
	
	public function setPct($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->pct !== $v || $v === 0) {
			$this->pct = $v;
			$this->modifiedColumns[] = MemberMatchPeer::PCT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member1_id = $rs->getInt($startcol + 1);

			$this->member2_id = $rs->getInt($startcol + 2);

			$this->pct = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MemberMatch object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberMatch:delete:pre') as $callable)
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
			$con = Propel::getConnection(MemberMatchPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberMatchPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMemberMatch:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberMatch:save:pre') as $callable)
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
			$con = Propel::getConnection(MemberMatchPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMemberMatch:save:post') as $callable)
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


												
			if ($this->aMemberRelatedByMember1Id !== null) {
				if ($this->aMemberRelatedByMember1Id->isModified()) {
					$affectedRows += $this->aMemberRelatedByMember1Id->save($con);
				}
				$this->setMemberRelatedByMember1Id($this->aMemberRelatedByMember1Id);
			}

			if ($this->aMemberRelatedByMember2Id !== null) {
				if ($this->aMemberRelatedByMember2Id->isModified()) {
					$affectedRows += $this->aMemberRelatedByMember2Id->save($con);
				}
				$this->setMemberRelatedByMember2Id($this->aMemberRelatedByMember2Id);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MemberMatchPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberMatchPeer::doUpdate($this, $con);
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


												
			if ($this->aMemberRelatedByMember1Id !== null) {
				if (!$this->aMemberRelatedByMember1Id->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByMember1Id->getValidationFailures());
				}
			}

			if ($this->aMemberRelatedByMember2Id !== null) {
				if (!$this->aMemberRelatedByMember2Id->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByMember2Id->getValidationFailures());
				}
			}


			if (($retval = MemberMatchPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberMatchPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMember1Id();
				break;
			case 2:
				return $this->getMember2Id();
				break;
			case 3:
				return $this->getPct();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberMatchPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMember1Id(),
			$keys[2] => $this->getMember2Id(),
			$keys[3] => $this->getPct(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberMatchPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMember1Id($value);
				break;
			case 2:
				$this->setMember2Id($value);
				break;
			case 3:
				$this->setPct($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberMatchPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMember1Id($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMember2Id($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPct($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberMatchPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberMatchPeer::ID)) $criteria->add(MemberMatchPeer::ID, $this->id);
		if ($this->isColumnModified(MemberMatchPeer::MEMBER1_ID)) $criteria->add(MemberMatchPeer::MEMBER1_ID, $this->member1_id);
		if ($this->isColumnModified(MemberMatchPeer::MEMBER2_ID)) $criteria->add(MemberMatchPeer::MEMBER2_ID, $this->member2_id);
		if ($this->isColumnModified(MemberMatchPeer::PCT)) $criteria->add(MemberMatchPeer::PCT, $this->pct);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberMatchPeer::DATABASE_NAME);

		$criteria->add(MemberMatchPeer::ID, $this->id);

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

		$copyObj->setMember1Id($this->member1_id);

		$copyObj->setMember2Id($this->member2_id);

		$copyObj->setPct($this->pct);


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
			self::$peer = new MemberMatchPeer();
		}
		return self::$peer;
	}

	
	public function setMemberRelatedByMember1Id($v)
	{


		if ($v === null) {
			$this->setMember1Id(NULL);
		} else {
			$this->setMember1Id($v->getId());
		}


		$this->aMemberRelatedByMember1Id = $v;
	}


	
	public function getMemberRelatedByMember1Id($con = null)
	{
		if ($this->aMemberRelatedByMember1Id === null && ($this->member1_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByMember1Id = MemberPeer::retrieveByPK($this->member1_id, $con);

			
		}
		return $this->aMemberRelatedByMember1Id;
	}

	
	public function setMemberRelatedByMember2Id($v)
	{


		if ($v === null) {
			$this->setMember2Id(NULL);
		} else {
			$this->setMember2Id($v->getId());
		}


		$this->aMemberRelatedByMember2Id = $v;
	}


	
	public function getMemberRelatedByMember2Id($con = null)
	{
		if ($this->aMemberRelatedByMember2Id === null && ($this->member2_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByMember2Id = MemberPeer::retrieveByPK($this->member2_id, $con);

			
		}
		return $this->aMemberRelatedByMember2Id;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMemberMatch:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMemberMatch::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 