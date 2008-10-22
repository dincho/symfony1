<?php


abstract class BaseFlagCategory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;

	
	protected $collFlags;

	
	protected $lastFlagCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = FlagCategoryPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = FlagCategoryPeer::TITLE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating FlagCategory object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseFlagCategory:delete:pre') as $callable)
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
			$con = Propel::getConnection(FlagCategoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			FlagCategoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseFlagCategory:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseFlagCategory:save:pre') as $callable)
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
			$con = Propel::getConnection(FlagCategoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseFlagCategory:save:post') as $callable)
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
					$pk = FlagCategoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += FlagCategoryPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collFlags !== null) {
				foreach($this->collFlags as $referrerFK) {
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


			if (($retval = FlagCategoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collFlags !== null) {
					foreach($this->collFlags as $referrerFK) {
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
		$pos = FlagCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTitle();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FlagCategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FlagCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTitle($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FlagCategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(FlagCategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(FlagCategoryPeer::ID)) $criteria->add(FlagCategoryPeer::ID, $this->id);
		if ($this->isColumnModified(FlagCategoryPeer::TITLE)) $criteria->add(FlagCategoryPeer::TITLE, $this->title);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(FlagCategoryPeer::DATABASE_NAME);

		$criteria->add(FlagCategoryPeer::ID, $this->id);

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

		$copyObj->setTitle($this->title);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getFlags() as $relObj) {
				$copyObj->addFlag($relObj->copy($deepCopy));
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
			self::$peer = new FlagCategoryPeer();
		}
		return self::$peer;
	}

	
	public function initFlags()
	{
		if ($this->collFlags === null) {
			$this->collFlags = array();
		}
	}

	
	public function getFlags($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlags === null) {
			if ($this->isNew()) {
			   $this->collFlags = array();
			} else {

				$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

				FlagPeer::addSelectColumns($criteria);
				$this->collFlags = FlagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

				FlagPeer::addSelectColumns($criteria);
				if (!isset($this->lastFlagCriteria) || !$this->lastFlagCriteria->equals($criteria)) {
					$this->collFlags = FlagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFlagCriteria = $criteria;
		return $this->collFlags;
	}

	
	public function countFlags($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

		return FlagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFlag(Flag $l)
	{
		$this->collFlags[] = $l;
		$l->setFlagCategory($this);
	}


	
	public function getFlagsJoinMemberRelatedByMemberId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlags === null) {
			if ($this->isNew()) {
				$this->collFlags = array();
			} else {

				$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

				$this->collFlags = FlagPeer::doSelectJoinMemberRelatedByMemberId($criteria, $con);
			}
		} else {
									
			$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

			if (!isset($this->lastFlagCriteria) || !$this->lastFlagCriteria->equals($criteria)) {
				$this->collFlags = FlagPeer::doSelectJoinMemberRelatedByMemberId($criteria, $con);
			}
		}
		$this->lastFlagCriteria = $criteria;

		return $this->collFlags;
	}


	
	public function getFlagsJoinMemberRelatedByFlaggerId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFlags === null) {
			if ($this->isNew()) {
				$this->collFlags = array();
			} else {

				$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

				$this->collFlags = FlagPeer::doSelectJoinMemberRelatedByFlaggerId($criteria, $con);
			}
		} else {
									
			$criteria->add(FlagPeer::FLAG_CATEGORY_ID, $this->getId());

			if (!isset($this->lastFlagCriteria) || !$this->lastFlagCriteria->equals($criteria)) {
				$this->collFlags = FlagPeer::doSelectJoinMemberRelatedByFlaggerId($criteria, $con);
			}
		}
		$this->lastFlagCriteria = $criteria;

		return $this->collFlags;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseFlagCategory:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseFlagCategory::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 