<?php


abstract class BasesfSetting extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $cat_id;


	
	protected $env;


	
	protected $name;


	
	protected $value;


	
	protected $var_type;


	
	protected $description;


	
	protected $created_user_id;


	
	protected $updated_user_id;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $aCatalogue;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getCatId()
	{

		return $this->cat_id;
	}

	
	public function getEnv()
	{

		return $this->env;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getValue()
	{

		return $this->value;
	}

	
	public function getVarType()
	{

		return $this->var_type;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getCreatedUserId()
	{

		return $this->created_user_id;
	}

	
	public function getUpdatedUserId()
	{

		return $this->updated_user_id;
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

	
	public function setCatId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cat_id !== $v) {
			$this->cat_id = $v;
			$this->modifiedColumns[] = sfSettingPeer::CAT_ID;
		}

		if ($this->aCatalogue !== null && $this->aCatalogue->getCatId() !== $v) {
			$this->aCatalogue = null;
		}

	} 
	
	public function setEnv($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->env !== $v) {
			$this->env = $v;
			$this->modifiedColumns[] = sfSettingPeer::ENV;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = sfSettingPeer::NAME;
		}

	} 
	
	public function setValue($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->value !== $v) {
			$this->value = $v;
			$this->modifiedColumns[] = sfSettingPeer::VALUE;
		}

	} 
	
	public function setVarType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->var_type !== $v) {
			$this->var_type = $v;
			$this->modifiedColumns[] = sfSettingPeer::VAR_TYPE;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = sfSettingPeer::DESCRIPTION;
		}

	} 
	
	public function setCreatedUserId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_user_id !== $v) {
			$this->created_user_id = $v;
			$this->modifiedColumns[] = sfSettingPeer::CREATED_USER_ID;
		}

	} 
	
	public function setUpdatedUserId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_user_id !== $v) {
			$this->updated_user_id = $v;
			$this->modifiedColumns[] = sfSettingPeer::UPDATED_USER_ID;
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
			$this->modifiedColumns[] = sfSettingPeer::CREATED_AT;
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
			$this->modifiedColumns[] = sfSettingPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->cat_id = $rs->getInt($startcol + 0);

			$this->env = $rs->getString($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->value = $rs->getString($startcol + 3);

			$this->var_type = $rs->getString($startcol + 4);

			$this->description = $rs->getString($startcol + 5);

			$this->created_user_id = $rs->getInt($startcol + 6);

			$this->updated_user_id = $rs->getInt($startcol + 7);

			$this->created_at = $rs->getTimestamp($startcol + 8, null);

			$this->updated_at = $rs->getTimestamp($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfSetting object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSetting:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfSettingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfSettingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfSetting:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSetting:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfSettingPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(sfSettingPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfSettingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfSetting:save:post') as $callable)
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


												
			if ($this->aCatalogue !== null) {
				if ($this->aCatalogue->isModified()) {
					$affectedRows += $this->aCatalogue->save($con);
				}
				$this->setCatalogue($this->aCatalogue);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfSettingPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += sfSettingPeer::doUpdate($this, $con);
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


												
			if ($this->aCatalogue !== null) {
				if (!$this->aCatalogue->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCatalogue->getValidationFailures());
				}
			}


			if (($retval = sfSettingPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSettingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCatId();
				break;
			case 1:
				return $this->getEnv();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getValue();
				break;
			case 4:
				return $this->getVarType();
				break;
			case 5:
				return $this->getDescription();
				break;
			case 6:
				return $this->getCreatedUserId();
				break;
			case 7:
				return $this->getUpdatedUserId();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSettingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCatId(),
			$keys[1] => $this->getEnv(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getValue(),
			$keys[4] => $this->getVarType(),
			$keys[5] => $this->getDescription(),
			$keys[6] => $this->getCreatedUserId(),
			$keys[7] => $this->getUpdatedUserId(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSettingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCatId($value);
				break;
			case 1:
				$this->setEnv($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setValue($value);
				break;
			case 4:
				$this->setVarType($value);
				break;
			case 5:
				$this->setDescription($value);
				break;
			case 6:
				$this->setCreatedUserId($value);
				break;
			case 7:
				$this->setUpdatedUserId($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSettingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCatId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setEnv($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setValue($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setVarType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedUserId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedUserId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfSettingPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfSettingPeer::CAT_ID)) $criteria->add(sfSettingPeer::CAT_ID, $this->cat_id);
		if ($this->isColumnModified(sfSettingPeer::ENV)) $criteria->add(sfSettingPeer::ENV, $this->env);
		if ($this->isColumnModified(sfSettingPeer::NAME)) $criteria->add(sfSettingPeer::NAME, $this->name);
		if ($this->isColumnModified(sfSettingPeer::VALUE)) $criteria->add(sfSettingPeer::VALUE, $this->value);
		if ($this->isColumnModified(sfSettingPeer::VAR_TYPE)) $criteria->add(sfSettingPeer::VAR_TYPE, $this->var_type);
		if ($this->isColumnModified(sfSettingPeer::DESCRIPTION)) $criteria->add(sfSettingPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(sfSettingPeer::CREATED_USER_ID)) $criteria->add(sfSettingPeer::CREATED_USER_ID, $this->created_user_id);
		if ($this->isColumnModified(sfSettingPeer::UPDATED_USER_ID)) $criteria->add(sfSettingPeer::UPDATED_USER_ID, $this->updated_user_id);
		if ($this->isColumnModified(sfSettingPeer::CREATED_AT)) $criteria->add(sfSettingPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfSettingPeer::UPDATED_AT)) $criteria->add(sfSettingPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfSettingPeer::DATABASE_NAME);

		$criteria->add(sfSettingPeer::CAT_ID, $this->cat_id);
		$criteria->add(sfSettingPeer::ENV, $this->env);
		$criteria->add(sfSettingPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getCatId();

		$pks[1] = $this->getEnv();

		$pks[2] = $this->getName();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setCatId($keys[0]);

		$this->setEnv($keys[1]);

		$this->setName($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setValue($this->value);

		$copyObj->setVarType($this->var_type);

		$copyObj->setDescription($this->description);

		$copyObj->setCreatedUserId($this->created_user_id);

		$copyObj->setUpdatedUserId($this->updated_user_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		$copyObj->setNew(true);

		$copyObj->setCatId(NULL); 
		$copyObj->setEnv(NULL); 
		$copyObj->setName(NULL); 
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
			self::$peer = new sfSettingPeer();
		}
		return self::$peer;
	}

	
	public function setCatalogue($v)
	{


		if ($v === null) {
			$this->setCatId(NULL);
		} else {
			$this->setCatId($v->getCatId());
		}


		$this->aCatalogue = $v;
	}


	
	public function getCatalogue($con = null)
	{
		if ($this->aCatalogue === null && ($this->cat_id !== null)) {
						include_once 'lib/model/om/BaseCataloguePeer.php';

			$this->aCatalogue = CataloguePeer::retrieveByPK($this->cat_id, $con);

			
		}
		return $this->aCatalogue;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfSetting:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfSetting::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 