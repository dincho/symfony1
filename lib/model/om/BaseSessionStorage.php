<?php


abstract class BaseSessionStorage extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $sess_id;


	
	protected $sess_data;


	
	protected $sess_time;


	
	protected $user_id = 0;


	
	protected $id;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getSessId()
	{

		return $this->sess_id;
	}

	
	public function getSessData()
	{

		return $this->sess_data;
	}

	
	public function getSessTime()
	{

		return $this->sess_time;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getId()
	{

		return $this->id;
	}

	
	public function setSessId($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sess_id !== $v) {
			$this->sess_id = $v;
			$this->modifiedColumns[] = SessionStoragePeer::SESS_ID;
		}

	} 
	
	public function setSessData($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sess_data !== $v) {
			$this->sess_data = $v;
			$this->modifiedColumns[] = SessionStoragePeer::SESS_DATA;
		}

	} 
	
	public function setSessTime($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sess_time !== $v) {
			$this->sess_time = $v;
			$this->modifiedColumns[] = SessionStoragePeer::SESS_TIME;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v || $v === 0) {
			$this->user_id = $v;
			$this->modifiedColumns[] = SessionStoragePeer::USER_ID;
		}

	} 
	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SessionStoragePeer::ID;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->sess_id = $rs->getString($startcol + 0);

			$this->sess_data = $rs->getString($startcol + 1);

			$this->sess_time = $rs->getString($startcol + 2);

			$this->user_id = $rs->getInt($startcol + 3);

			$this->id = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating SessionStorage object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseSessionStorage:delete:pre') as $callable)
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
			$con = Propel::getConnection(SessionStoragePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SessionStoragePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseSessionStorage:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseSessionStorage:save:pre') as $callable)
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
			$con = Propel::getConnection(SessionStoragePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseSessionStorage:save:post') as $callable)
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
					$pk = SessionStoragePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SessionStoragePeer::doUpdate($this, $con);
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


			if (($retval = SessionStoragePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SessionStoragePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getSessId();
				break;
			case 1:
				return $this->getSessData();
				break;
			case 2:
				return $this->getSessTime();
				break;
			case 3:
				return $this->getUserId();
				break;
			case 4:
				return $this->getId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SessionStoragePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getSessId(),
			$keys[1] => $this->getSessData(),
			$keys[2] => $this->getSessTime(),
			$keys[3] => $this->getUserId(),
			$keys[4] => $this->getId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SessionStoragePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setSessId($value);
				break;
			case 1:
				$this->setSessData($value);
				break;
			case 2:
				$this->setSessTime($value);
				break;
			case 3:
				$this->setUserId($value);
				break;
			case 4:
				$this->setId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SessionStoragePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setSessId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSessData($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSessTime($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setId($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SessionStoragePeer::DATABASE_NAME);

		if ($this->isColumnModified(SessionStoragePeer::SESS_ID)) $criteria->add(SessionStoragePeer::SESS_ID, $this->sess_id);
		if ($this->isColumnModified(SessionStoragePeer::SESS_DATA)) $criteria->add(SessionStoragePeer::SESS_DATA, $this->sess_data);
		if ($this->isColumnModified(SessionStoragePeer::SESS_TIME)) $criteria->add(SessionStoragePeer::SESS_TIME, $this->sess_time);
		if ($this->isColumnModified(SessionStoragePeer::USER_ID)) $criteria->add(SessionStoragePeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(SessionStoragePeer::ID)) $criteria->add(SessionStoragePeer::ID, $this->id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SessionStoragePeer::DATABASE_NAME);

		$criteria->add(SessionStoragePeer::ID, $this->id);

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

		$copyObj->setSessId($this->sess_id);

		$copyObj->setSessData($this->sess_data);

		$copyObj->setSessTime($this->sess_time);

		$copyObj->setUserId($this->user_id);


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
			self::$peer = new SessionStoragePeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseSessionStorage:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseSessionStorage::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 