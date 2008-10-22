<?php


abstract class BaseMatchWeight extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;


	
	protected $number;

	
	protected $collSearchCritDescs;

	
	protected $lastSearchCritDescCriteria = null;

	
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

	
	public function getNumber()
	{

		return $this->number;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MatchWeightPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = MatchWeightPeer::TITLE;
		}

	} 
	
	public function setNumber($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->number !== $v) {
			$this->number = $v;
			$this->modifiedColumns[] = MatchWeightPeer::NUMBER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->number = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MatchWeight object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMatchWeight:delete:pre') as $callable)
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
			$con = Propel::getConnection(MatchWeightPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MatchWeightPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMatchWeight:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMatchWeight:save:pre') as $callable)
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
			$con = Propel::getConnection(MatchWeightPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMatchWeight:save:post') as $callable)
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
					$pk = MatchWeightPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MatchWeightPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collSearchCritDescs !== null) {
				foreach($this->collSearchCritDescs as $referrerFK) {
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


			if (($retval = MatchWeightPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSearchCritDescs !== null) {
					foreach($this->collSearchCritDescs as $referrerFK) {
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
		$pos = MatchWeightPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			case 2:
				return $this->getNumber();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MatchWeightPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getNumber(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MatchWeightPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			case 2:
				$this->setNumber($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MatchWeightPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNumber($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MatchWeightPeer::DATABASE_NAME);

		if ($this->isColumnModified(MatchWeightPeer::ID)) $criteria->add(MatchWeightPeer::ID, $this->id);
		if ($this->isColumnModified(MatchWeightPeer::TITLE)) $criteria->add(MatchWeightPeer::TITLE, $this->title);
		if ($this->isColumnModified(MatchWeightPeer::NUMBER)) $criteria->add(MatchWeightPeer::NUMBER, $this->number);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MatchWeightPeer::DATABASE_NAME);

		$criteria->add(MatchWeightPeer::ID, $this->id);

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

		$copyObj->setNumber($this->number);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getSearchCritDescs() as $relObj) {
				$copyObj->addSearchCritDesc($relObj->copy($deepCopy));
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
			self::$peer = new MatchWeightPeer();
		}
		return self::$peer;
	}

	
	public function initSearchCritDescs()
	{
		if ($this->collSearchCritDescs === null) {
			$this->collSearchCritDescs = array();
		}
	}

	
	public function getSearchCritDescs($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSearchCritDescPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSearchCritDescs === null) {
			if ($this->isNew()) {
			   $this->collSearchCritDescs = array();
			} else {

				$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

				SearchCritDescPeer::addSelectColumns($criteria);
				$this->collSearchCritDescs = SearchCritDescPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

				SearchCritDescPeer::addSelectColumns($criteria);
				if (!isset($this->lastSearchCritDescCriteria) || !$this->lastSearchCritDescCriteria->equals($criteria)) {
					$this->collSearchCritDescs = SearchCritDescPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSearchCritDescCriteria = $criteria;
		return $this->collSearchCritDescs;
	}

	
	public function countSearchCritDescs($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSearchCritDescPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

		return SearchCritDescPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSearchCritDesc(SearchCritDesc $l)
	{
		$this->collSearchCritDescs[] = $l;
		$l->setMatchWeight($this);
	}


	
	public function getSearchCritDescsJoinSearchCriteria($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSearchCritDescPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSearchCritDescs === null) {
			if ($this->isNew()) {
				$this->collSearchCritDescs = array();
			} else {

				$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinSearchCriteria($criteria, $con);
			}
		} else {
									
			$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

			if (!isset($this->lastSearchCritDescCriteria) || !$this->lastSearchCritDescCriteria->equals($criteria)) {
				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinSearchCriteria($criteria, $con);
			}
		}
		$this->lastSearchCritDescCriteria = $criteria;

		return $this->collSearchCritDescs;
	}


	
	public function getSearchCritDescsJoinDescQuestion($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSearchCritDescPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSearchCritDescs === null) {
			if ($this->isNew()) {
				$this->collSearchCritDescs = array();
			} else {

				$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinDescQuestion($criteria, $con);
			}
		} else {
									
			$criteria->add(SearchCritDescPeer::MATCH_WEIGHT_ID, $this->getId());

			if (!isset($this->lastSearchCritDescCriteria) || !$this->lastSearchCritDescCriteria->equals($criteria)) {
				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinDescQuestion($criteria, $con);
			}
		}
		$this->lastSearchCritDescCriteria = $criteria;

		return $this->collSearchCritDescs;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMatchWeight:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMatchWeight::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 