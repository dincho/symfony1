<?php


abstract class BaseMsgCollection extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $trans_collection_id;


	
	protected $name;

	
	protected $aTransCollection;

	
	protected $collTransUnits;

	
	protected $lastTransUnitCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTransCollectionId()
	{

		return $this->trans_collection_id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MsgCollectionPeer::ID;
		}

	} 
	
	public function setTransCollectionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->trans_collection_id !== $v) {
			$this->trans_collection_id = $v;
			$this->modifiedColumns[] = MsgCollectionPeer::TRANS_COLLECTION_ID;
		}

		if ($this->aTransCollection !== null && $this->aTransCollection->getId() !== $v) {
			$this->aTransCollection = null;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = MsgCollectionPeer::NAME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->trans_collection_id = $rs->getInt($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MsgCollection object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMsgCollection:delete:pre') as $callable)
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
			$con = Propel::getConnection(MsgCollectionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MsgCollectionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMsgCollection:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMsgCollection:save:pre') as $callable)
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
			$con = Propel::getConnection(MsgCollectionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMsgCollection:save:post') as $callable)
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


												
			if ($this->aTransCollection !== null) {
				if ($this->aTransCollection->isModified()) {
					$affectedRows += $this->aTransCollection->save($con);
				}
				$this->setTransCollection($this->aTransCollection);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MsgCollectionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MsgCollectionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collTransUnits !== null) {
				foreach($this->collTransUnits as $referrerFK) {
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


												
			if ($this->aTransCollection !== null) {
				if (!$this->aTransCollection->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTransCollection->getValidationFailures());
				}
			}


			if (($retval = MsgCollectionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTransUnits !== null) {
					foreach($this->collTransUnits as $referrerFK) {
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
		$pos = MsgCollectionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTransCollectionId();
				break;
			case 2:
				return $this->getName();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MsgCollectionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTransCollectionId(),
			$keys[2] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MsgCollectionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTransCollectionId($value);
				break;
			case 2:
				$this->setName($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MsgCollectionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTransCollectionId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MsgCollectionPeer::DATABASE_NAME);

		if ($this->isColumnModified(MsgCollectionPeer::ID)) $criteria->add(MsgCollectionPeer::ID, $this->id);
		if ($this->isColumnModified(MsgCollectionPeer::TRANS_COLLECTION_ID)) $criteria->add(MsgCollectionPeer::TRANS_COLLECTION_ID, $this->trans_collection_id);
		if ($this->isColumnModified(MsgCollectionPeer::NAME)) $criteria->add(MsgCollectionPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MsgCollectionPeer::DATABASE_NAME);

		$criteria->add(MsgCollectionPeer::ID, $this->id);

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

		$copyObj->setTransCollectionId($this->trans_collection_id);

		$copyObj->setName($this->name);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getTransUnits() as $relObj) {
				$copyObj->addTransUnit($relObj->copy($deepCopy));
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
			self::$peer = new MsgCollectionPeer();
		}
		return self::$peer;
	}

	
	public function setTransCollection($v)
	{


		if ($v === null) {
			$this->setTransCollectionId(NULL);
		} else {
			$this->setTransCollectionId($v->getId());
		}


		$this->aTransCollection = $v;
	}


	
	public function getTransCollection($con = null)
	{
		if ($this->aTransCollection === null && ($this->trans_collection_id !== null)) {
						include_once 'lib/model/om/BaseTransCollectionPeer.php';

			$this->aTransCollection = TransCollectionPeer::retrieveByPK($this->trans_collection_id, $con);

			
		}
		return $this->aTransCollection;
	}

	
	public function initTransUnits()
	{
		if ($this->collTransUnits === null) {
			$this->collTransUnits = array();
		}
	}

	
	public function getTransUnits($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTransUnitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTransUnits === null) {
			if ($this->isNew()) {
			   $this->collTransUnits = array();
			} else {

				$criteria->add(TransUnitPeer::MSG_COLLECTION_ID, $this->getId());

				TransUnitPeer::addSelectColumns($criteria);
				$this->collTransUnits = TransUnitPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TransUnitPeer::MSG_COLLECTION_ID, $this->getId());

				TransUnitPeer::addSelectColumns($criteria);
				if (!isset($this->lastTransUnitCriteria) || !$this->lastTransUnitCriteria->equals($criteria)) {
					$this->collTransUnits = TransUnitPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTransUnitCriteria = $criteria;
		return $this->collTransUnits;
	}

	
	public function countTransUnits($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTransUnitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TransUnitPeer::MSG_COLLECTION_ID, $this->getId());

		return TransUnitPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTransUnit(TransUnit $l)
	{
		$this->collTransUnits[] = $l;
		$l->setMsgCollection($this);
	}


	
	public function getTransUnitsJoinCatalogue($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTransUnitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTransUnits === null) {
			if ($this->isNew()) {
				$this->collTransUnits = array();
			} else {

				$criteria->add(TransUnitPeer::MSG_COLLECTION_ID, $this->getId());

				$this->collTransUnits = TransUnitPeer::doSelectJoinCatalogue($criteria, $con);
			}
		} else {
									
			$criteria->add(TransUnitPeer::MSG_COLLECTION_ID, $this->getId());

			if (!isset($this->lastTransUnitCriteria) || !$this->lastTransUnitCriteria->equals($criteria)) {
				$this->collTransUnits = TransUnitPeer::doSelectJoinCatalogue($criteria, $con);
			}
		}
		$this->lastTransUnitCriteria = $criteria;

		return $this->collTransUnits;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMsgCollection:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMsgCollection::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 