<?php


abstract class BaseFlag extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_id;


	
	protected $flagger_id;


	
	protected $flag_category_id;


	
	protected $comment;


	
	protected $is_history = false;


	
	protected $created_at;

	
	protected $aMemberRelatedByMemberId;

	
	protected $aMemberRelatedByFlaggerId;

	
	protected $aFlagCategory;

	
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

	
	public function getFlaggerId()
	{

		return $this->flagger_id;
	}

	
	public function getFlagCategoryId()
	{

		return $this->flag_category_id;
	}

	
	public function getComment()
	{

		return $this->comment;
	}

	
	public function getIsHistory()
	{

		return $this->is_history;
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
			$this->modifiedColumns[] = FlagPeer::ID;
		}

	} 
	
	public function setMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = FlagPeer::MEMBER_ID;
		}

		if ($this->aMemberRelatedByMemberId !== null && $this->aMemberRelatedByMemberId->getId() !== $v) {
			$this->aMemberRelatedByMemberId = null;
		}

	} 
	
	public function setFlaggerId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->flagger_id !== $v) {
			$this->flagger_id = $v;
			$this->modifiedColumns[] = FlagPeer::FLAGGER_ID;
		}

		if ($this->aMemberRelatedByFlaggerId !== null && $this->aMemberRelatedByFlaggerId->getId() !== $v) {
			$this->aMemberRelatedByFlaggerId = null;
		}

	} 
	
	public function setFlagCategoryId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->flag_category_id !== $v) {
			$this->flag_category_id = $v;
			$this->modifiedColumns[] = FlagPeer::FLAG_CATEGORY_ID;
		}

		if ($this->aFlagCategory !== null && $this->aFlagCategory->getId() !== $v) {
			$this->aFlagCategory = null;
		}

	} 
	
	public function setComment($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->comment !== $v) {
			$this->comment = $v;
			$this->modifiedColumns[] = FlagPeer::COMMENT;
		}

	} 
	
	public function setIsHistory($v)
	{

		if ($this->is_history !== $v || $v === false) {
			$this->is_history = $v;
			$this->modifiedColumns[] = FlagPeer::IS_HISTORY;
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
			$this->modifiedColumns[] = FlagPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_id = $rs->getInt($startcol + 1);

			$this->flagger_id = $rs->getInt($startcol + 2);

			$this->flag_category_id = $rs->getInt($startcol + 3);

			$this->comment = $rs->getString($startcol + 4);

			$this->is_history = $rs->getBoolean($startcol + 5);

			$this->created_at = $rs->getTimestamp($startcol + 6, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Flag object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseFlag:delete:pre') as $callable)
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
			$con = Propel::getConnection(FlagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			FlagPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseFlag:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseFlag:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(FlagPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(FlagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseFlag:save:post') as $callable)
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

			if ($this->aMemberRelatedByFlaggerId !== null) {
				if ($this->aMemberRelatedByFlaggerId->isModified()) {
					$affectedRows += $this->aMemberRelatedByFlaggerId->save($con);
				}
				$this->setMemberRelatedByFlaggerId($this->aMemberRelatedByFlaggerId);
			}

			if ($this->aFlagCategory !== null) {
				if ($this->aFlagCategory->isModified()) {
					$affectedRows += $this->aFlagCategory->save($con);
				}
				$this->setFlagCategory($this->aFlagCategory);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = FlagPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += FlagPeer::doUpdate($this, $con);
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

			if ($this->aMemberRelatedByFlaggerId !== null) {
				if (!$this->aMemberRelatedByFlaggerId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberRelatedByFlaggerId->getValidationFailures());
				}
			}

			if ($this->aFlagCategory !== null) {
				if (!$this->aFlagCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aFlagCategory->getValidationFailures());
				}
			}


			if (($retval = FlagPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FlagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFlaggerId();
				break;
			case 3:
				return $this->getFlagCategoryId();
				break;
			case 4:
				return $this->getComment();
				break;
			case 5:
				return $this->getIsHistory();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FlagPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberId(),
			$keys[2] => $this->getFlaggerId(),
			$keys[3] => $this->getFlagCategoryId(),
			$keys[4] => $this->getComment(),
			$keys[5] => $this->getIsHistory(),
			$keys[6] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FlagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFlaggerId($value);
				break;
			case 3:
				$this->setFlagCategoryId($value);
				break;
			case 4:
				$this->setComment($value);
				break;
			case 5:
				$this->setIsHistory($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FlagPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFlaggerId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFlagCategoryId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setComment($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsHistory($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(FlagPeer::DATABASE_NAME);

		if ($this->isColumnModified(FlagPeer::ID)) $criteria->add(FlagPeer::ID, $this->id);
		if ($this->isColumnModified(FlagPeer::MEMBER_ID)) $criteria->add(FlagPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(FlagPeer::FLAGGER_ID)) $criteria->add(FlagPeer::FLAGGER_ID, $this->flagger_id);
		if ($this->isColumnModified(FlagPeer::FLAG_CATEGORY_ID)) $criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->flag_category_id);
		if ($this->isColumnModified(FlagPeer::COMMENT)) $criteria->add(FlagPeer::COMMENT, $this->comment);
		if ($this->isColumnModified(FlagPeer::IS_HISTORY)) $criteria->add(FlagPeer::IS_HISTORY, $this->is_history);
		if ($this->isColumnModified(FlagPeer::CREATED_AT)) $criteria->add(FlagPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(FlagPeer::DATABASE_NAME);

		$criteria->add(FlagPeer::ID, $this->id);

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

		$copyObj->setFlaggerId($this->flagger_id);

		$copyObj->setFlagCategoryId($this->flag_category_id);

		$copyObj->setComment($this->comment);

		$copyObj->setIsHistory($this->is_history);

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
			self::$peer = new FlagPeer();
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

	
	public function setMemberRelatedByFlaggerId($v)
	{


		if ($v === null) {
			$this->setFlaggerId(NULL);
		} else {
			$this->setFlaggerId($v->getId());
		}


		$this->aMemberRelatedByFlaggerId = $v;
	}


	
	public function getMemberRelatedByFlaggerId($con = null)
	{
		if ($this->aMemberRelatedByFlaggerId === null && ($this->flagger_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMemberRelatedByFlaggerId = MemberPeer::retrieveByPK($this->flagger_id, $con);

			
		}
		return $this->aMemberRelatedByFlaggerId;
	}

	
	public function setFlagCategory($v)
	{


		if ($v === null) {
			$this->setFlagCategoryId(NULL);
		} else {
			$this->setFlagCategoryId($v->getId());
		}


		$this->aFlagCategory = $v;
	}


	
	public function getFlagCategory($con = null)
	{
		if ($this->aFlagCategory === null && ($this->flag_category_id !== null)) {
						include_once 'lib/model/om/BaseFlagCategoryPeer.php';

			$this->aFlagCategory = FlagCategoryPeer::retrieveByPK($this->flag_category_id, $con);

			
		}
		return $this->aFlagCategory;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseFlag:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseFlag::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 