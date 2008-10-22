<?php


abstract class BaseGroups extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $group_name;


	
	protected $group_description;

	
	protected $collPermissionss;

	
	protected $lastPermissionsCriteria = null;

	
	protected $collGroupAndActions;

	
	protected $lastGroupAndActionCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getGroupName()
	{

		return $this->group_name;
	}

	
	public function getGroupDescription()
	{

		return $this->group_description;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = GroupsPeer::ID;
		}

	} 
	
	public function setGroupName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->group_name !== $v) {
			$this->group_name = $v;
			$this->modifiedColumns[] = GroupsPeer::GROUP_NAME;
		}

	} 
	
	public function setGroupDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->group_description !== $v) {
			$this->group_description = $v;
			$this->modifiedColumns[] = GroupsPeer::GROUP_DESCRIPTION;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->group_name = $rs->getString($startcol + 1);

			$this->group_description = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Groups object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseGroups:delete:pre') as $callable)
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
			$con = Propel::getConnection(GroupsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			GroupsPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseGroups:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseGroups:save:pre') as $callable)
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
			$con = Propel::getConnection(GroupsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseGroups:save:post') as $callable)
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
					$pk = GroupsPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += GroupsPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collPermissionss !== null) {
				foreach($this->collPermissionss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupAndActions !== null) {
				foreach($this->collGroupAndActions as $referrerFK) {
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


			if (($retval = GroupsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPermissionss !== null) {
					foreach($this->collPermissionss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupAndActions !== null) {
					foreach($this->collGroupAndActions as $referrerFK) {
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
		$pos = GroupsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getGroupName();
				break;
			case 2:
				return $this->getGroupDescription();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GroupsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getGroupName(),
			$keys[2] => $this->getGroupDescription(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = GroupsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setGroupName($value);
				break;
			case 2:
				$this->setGroupDescription($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = GroupsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setGroupName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGroupDescription($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(GroupsPeer::DATABASE_NAME);

		if ($this->isColumnModified(GroupsPeer::ID)) $criteria->add(GroupsPeer::ID, $this->id);
		if ($this->isColumnModified(GroupsPeer::GROUP_NAME)) $criteria->add(GroupsPeer::GROUP_NAME, $this->group_name);
		if ($this->isColumnModified(GroupsPeer::GROUP_DESCRIPTION)) $criteria->add(GroupsPeer::GROUP_DESCRIPTION, $this->group_description);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(GroupsPeer::DATABASE_NAME);

		$criteria->add(GroupsPeer::ID, $this->id);

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

		$copyObj->setGroupName($this->group_name);

		$copyObj->setGroupDescription($this->group_description);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getPermissionss() as $relObj) {
				$copyObj->addPermissions($relObj->copy($deepCopy));
			}

			foreach($this->getGroupAndActions() as $relObj) {
				$copyObj->addGroupAndAction($relObj->copy($deepCopy));
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
			self::$peer = new GroupsPeer();
		}
		return self::$peer;
	}

	
	public function initPermissionss()
	{
		if ($this->collPermissionss === null) {
			$this->collPermissionss = array();
		}
	}

	
	public function getPermissionss($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BasePermissionsPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPermissionss === null) {
			if ($this->isNew()) {
			   $this->collPermissionss = array();
			} else {

				$criteria->add(PermissionsPeer::GROUP_ID, $this->getId());

				PermissionsPeer::addSelectColumns($criteria);
				$this->collPermissionss = PermissionsPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PermissionsPeer::GROUP_ID, $this->getId());

				PermissionsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPermissionsCriteria) || !$this->lastPermissionsCriteria->equals($criteria)) {
					$this->collPermissionss = PermissionsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPermissionsCriteria = $criteria;
		return $this->collPermissionss;
	}

	
	public function countPermissionss($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BasePermissionsPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PermissionsPeer::GROUP_ID, $this->getId());

		return PermissionsPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addPermissions(Permissions $l)
	{
		$this->collPermissionss[] = $l;
		$l->setGroups($this);
	}


	
	public function getPermissionssJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BasePermissionsPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPermissionss === null) {
			if ($this->isNew()) {
				$this->collPermissionss = array();
			} else {

				$criteria->add(PermissionsPeer::GROUP_ID, $this->getId());

				$this->collPermissionss = PermissionsPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(PermissionsPeer::GROUP_ID, $this->getId());

			if (!isset($this->lastPermissionsCriteria) || !$this->lastPermissionsCriteria->equals($criteria)) {
				$this->collPermissionss = PermissionsPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastPermissionsCriteria = $criteria;

		return $this->collPermissionss;
	}

	
	public function initGroupAndActions()
	{
		if ($this->collGroupAndActions === null) {
			$this->collGroupAndActions = array();
		}
	}

	
	public function getGroupAndActions($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseGroupAndActionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupAndActions === null) {
			if ($this->isNew()) {
			   $this->collGroupAndActions = array();
			} else {

				$criteria->add(GroupAndActionPeer::GROUP_ID, $this->getId());

				GroupAndActionPeer::addSelectColumns($criteria);
				$this->collGroupAndActions = GroupAndActionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(GroupAndActionPeer::GROUP_ID, $this->getId());

				GroupAndActionPeer::addSelectColumns($criteria);
				if (!isset($this->lastGroupAndActionCriteria) || !$this->lastGroupAndActionCriteria->equals($criteria)) {
					$this->collGroupAndActions = GroupAndActionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGroupAndActionCriteria = $criteria;
		return $this->collGroupAndActions;
	}

	
	public function countGroupAndActions($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseGroupAndActionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GroupAndActionPeer::GROUP_ID, $this->getId());

		return GroupAndActionPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addGroupAndAction(GroupAndAction $l)
	{
		$this->collGroupAndActions[] = $l;
		$l->setGroups($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseGroups:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseGroups::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 