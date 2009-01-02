<?php


abstract class BaseTransCollection extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;

	
	protected $collMsgCollections;

	
	protected $lastMsgCollectionCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
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
			$this->modifiedColumns[] = TransCollectionPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = TransCollectionPeer::NAME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TransCollection object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTransCollection:delete:pre') as $callable)
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
			$con = Propel::getConnection(TransCollectionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TransCollectionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTransCollection:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTransCollection:save:pre') as $callable)
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
			$con = Propel::getConnection(TransCollectionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTransCollection:save:post') as $callable)
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
					$pk = TransCollectionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TransCollectionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMsgCollections !== null) {
				foreach($this->collMsgCollections as $referrerFK) {
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


			if (($retval = TransCollectionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMsgCollections !== null) {
					foreach($this->collMsgCollections as $referrerFK) {
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
		$pos = TransCollectionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransCollectionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransCollectionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransCollectionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TransCollectionPeer::DATABASE_NAME);

		if ($this->isColumnModified(TransCollectionPeer::ID)) $criteria->add(TransCollectionPeer::ID, $this->id);
		if ($this->isColumnModified(TransCollectionPeer::NAME)) $criteria->add(TransCollectionPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TransCollectionPeer::DATABASE_NAME);

		$criteria->add(TransCollectionPeer::ID, $this->id);

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

		$copyObj->setName($this->name);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMsgCollections() as $relObj) {
				$copyObj->addMsgCollection($relObj->copy($deepCopy));
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
			self::$peer = new TransCollectionPeer();
		}
		return self::$peer;
	}

	
	public function initMsgCollections()
	{
		if ($this->collMsgCollections === null) {
			$this->collMsgCollections = array();
		}
	}

	
	public function getMsgCollections($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMsgCollectionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMsgCollections === null) {
			if ($this->isNew()) {
			   $this->collMsgCollections = array();
			} else {

				$criteria->add(MsgCollectionPeer::TRANS_COLLECTION_ID, $this->getId());

				MsgCollectionPeer::addSelectColumns($criteria);
				$this->collMsgCollections = MsgCollectionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MsgCollectionPeer::TRANS_COLLECTION_ID, $this->getId());

				MsgCollectionPeer::addSelectColumns($criteria);
				if (!isset($this->lastMsgCollectionCriteria) || !$this->lastMsgCollectionCriteria->equals($criteria)) {
					$this->collMsgCollections = MsgCollectionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMsgCollectionCriteria = $criteria;
		return $this->collMsgCollections;
	}

	
	public function countMsgCollections($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMsgCollectionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MsgCollectionPeer::TRANS_COLLECTION_ID, $this->getId());

		return MsgCollectionPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMsgCollection(MsgCollection $l)
	{
		$this->collMsgCollections[] = $l;
		$l->setTransCollection($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTransCollection:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTransCollection::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 