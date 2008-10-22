<?php


abstract class BaseGroupAndAction extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $action;


	
	protected $group_id;

	
	protected $aGroups;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getAction()
	{

		return $this->action;
	}

	
	public function getGroupId()
	{

		return $this->group_id;
	}

	
	public function setAction($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->action !== $v) {
			$this->action = $v;
			$this->modifiedColumns[] = GroupAndActionPeer::ACTION;
		}

	} 
	
	public function setGroupId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = GroupAndActionPeer::GROUP_ID;
		}

		if ($this->aGroups !== null && $this->aGroups->getId() !== $v) {
			$this->aGroups = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->action = $rs->getString($startcol + 0);

			$this->group_id = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating GroupAndAction object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseGroupAndAction:delete:pre') as $callable)
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
			$con = Propel::getConnection(GroupAndActionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GroupAndActionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseGroupAndAction:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseGroupAndAction:save:pre') as $callable)
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
			$con = Propel::getConnection(GroupAndActionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseGroupAndAction:save:post') as $callable)
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


												
			if ($this->aGroups !== null) {
				if ($this->aGroups->isModified()) {
					$affectedRows += $this->aGroups->save($con);
				}
				$this->setGroups($this->aGroups);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = GroupAndActionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += GroupAndActionPeer::doUpdate($this, $con);
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


												
			if ($this->aGroups !== null) {
				if (!$this->aGroups->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGroups->getValidationFailures());
				}
			}


			if (($retval = GroupAndActionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GroupAndActionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAction();
				break;
			case 1:
				return $this->getGroupId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GroupAndActionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAction(),
			$keys[1] => $this->getGroupId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GroupAndActionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAction($value);
				break;
			case 1:
				$this->setGroupId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GroupAndActionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAction($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setGroupId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GroupAndActionPeer::DATABASE_NAME);

		if ($this->isColumnModified(GroupAndActionPeer::ACTION)) $criteria->add(GroupAndActionPeer::ACTION, $this->action);
		if ($this->isColumnModified(GroupAndActionPeer::GROUP_ID)) $criteria->add(GroupAndActionPeer::GROUP_ID, $this->group_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GroupAndActionPeer::DATABASE_NAME);

		$criteria->add(GroupAndActionPeer::ACTION, $this->action);
		$criteria->add(GroupAndActionPeer::GROUP_ID, $this->group_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getAction();

		$pks[1] = $this->getGroupId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setAction($keys[0]);

		$this->setGroupId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setAction(NULL); 
		$copyObj->setGroupId(NULL); 
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
			self::$peer = new GroupAndActionPeer();
		}
		return self::$peer;
	}

	
	public function setGroups($v)
	{


		if ($v === null) {
			$this->setGroupId(NULL);
		} else {
			$this->setGroupId($v->getId());
		}


		$this->aGroups = $v;
	}


	
	public function getGroups($con = null)
	{
		if ($this->aGroups === null && ($this->group_id !== null)) {
						include_once 'lib/model/om/BaseGroupsPeer.php';

			$this->aGroups = GroupsPeer::retrieveByPK($this->group_id, $con);

			
		}
		return $this->aGroups;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseGroupAndAction:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseGroupAndAction::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 