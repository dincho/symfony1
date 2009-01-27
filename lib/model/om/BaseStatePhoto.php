<?php


abstract class BaseStatePhoto extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $state_id;


	
	protected $file;


	
	protected $cropped;

	
	protected $aState;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getStateId()
	{

		return $this->state_id;
	}

	
	public function getFile()
	{

		return $this->file;
	}

	
	public function getCropped()
	{

		return $this->cropped;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = StatePhotoPeer::ID;
		}

	} 
	
	public function setStateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->state_id !== $v) {
			$this->state_id = $v;
			$this->modifiedColumns[] = StatePhotoPeer::STATE_ID;
		}

		if ($this->aState !== null && $this->aState->getId() !== $v) {
			$this->aState = null;
		}

	} 
	
	public function setFile($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file !== $v) {
			$this->file = $v;
			$this->modifiedColumns[] = StatePhotoPeer::FILE;
		}

	} 
	
	public function setCropped($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->cropped !== $v) {
			$this->cropped = $v;
			$this->modifiedColumns[] = StatePhotoPeer::CROPPED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->state_id = $rs->getInt($startcol + 1);

			$this->file = $rs->getString($startcol + 2);

			$this->cropped = $rs->getString($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating StatePhoto object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseStatePhoto:delete:pre') as $callable)
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
			$con = Propel::getConnection(StatePhotoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			StatePhotoPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseStatePhoto:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseStatePhoto:save:pre') as $callable)
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
			$con = Propel::getConnection(StatePhotoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseStatePhoto:save:post') as $callable)
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


												
			if ($this->aState !== null) {
				if ($this->aState->isModified()) {
					$affectedRows += $this->aState->save($con);
				}
				$this->setState($this->aState);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = StatePhotoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += StatePhotoPeer::doUpdate($this, $con);
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


												
			if ($this->aState !== null) {
				if (!$this->aState->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aState->getValidationFailures());
				}
			}


			if (($retval = StatePhotoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StatePhotoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getStateId();
				break;
			case 2:
				return $this->getFile();
				break;
			case 3:
				return $this->getCropped();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StatePhotoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getStateId(),
			$keys[2] => $this->getFile(),
			$keys[3] => $this->getCropped(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StatePhotoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setStateId($value);
				break;
			case 2:
				$this->setFile($value);
				break;
			case 3:
				$this->setCropped($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StatePhotoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setStateId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFile($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCropped($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(StatePhotoPeer::DATABASE_NAME);

		if ($this->isColumnModified(StatePhotoPeer::ID)) $criteria->add(StatePhotoPeer::ID, $this->id);
		if ($this->isColumnModified(StatePhotoPeer::STATE_ID)) $criteria->add(StatePhotoPeer::STATE_ID, $this->state_id);
		if ($this->isColumnModified(StatePhotoPeer::FILE)) $criteria->add(StatePhotoPeer::FILE, $this->file);
		if ($this->isColumnModified(StatePhotoPeer::CROPPED)) $criteria->add(StatePhotoPeer::CROPPED, $this->cropped);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(StatePhotoPeer::DATABASE_NAME);

		$criteria->add(StatePhotoPeer::ID, $this->id);

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

		$copyObj->setStateId($this->state_id);

		$copyObj->setFile($this->file);

		$copyObj->setCropped($this->cropped);


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
			self::$peer = new StatePhotoPeer();
		}
		return self::$peer;
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


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseStatePhoto:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseStatePhoto::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 