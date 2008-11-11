<?php


abstract class BaseSearchCriteria extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ages;


	
	protected $ages_weight;


	
	protected $updated_at;

	
	protected $collMembers;

	
	protected $lastMemberCriteria = null;

	
	protected $collSearchCritDescs;

	
	protected $lastSearchCritDescCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getAges()
	{

		return $this->ages;
	}

	
	public function getAgesWeight()
	{

		return $this->ages_weight;
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SearchCriteriaPeer::ID;
		}

	} 
	
	public function setAges($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ages !== $v) {
			$this->ages = $v;
			$this->modifiedColumns[] = SearchCriteriaPeer::AGES;
		}

	} 
	
	public function setAgesWeight($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ages_weight !== $v) {
			$this->ages_weight = $v;
			$this->modifiedColumns[] = SearchCriteriaPeer::AGES_WEIGHT;
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
			$this->modifiedColumns[] = SearchCriteriaPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ages = $rs->getString($startcol + 1);

			$this->ages_weight = $rs->getInt($startcol + 2);

			$this->updated_at = $rs->getTimestamp($startcol + 3, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating SearchCriteria object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCriteria:delete:pre') as $callable)
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
			$con = Propel::getConnection(SearchCriteriaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SearchCriteriaPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseSearchCriteria:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCriteria:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isModified() && !$this->isColumnModified(SearchCriteriaPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SearchCriteriaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseSearchCriteria:save:post') as $callable)
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
					$pk = SearchCriteriaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SearchCriteriaPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMembers !== null) {
				foreach($this->collMembers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

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


			if (($retval = SearchCriteriaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMembers !== null) {
					foreach($this->collMembers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = SearchCriteriaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getAges();
				break;
			case 2:
				return $this->getAgesWeight();
				break;
			case 3:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SearchCriteriaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getAges(),
			$keys[2] => $this->getAgesWeight(),
			$keys[3] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SearchCriteriaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setAges($value);
				break;
			case 2:
				$this->setAgesWeight($value);
				break;
			case 3:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SearchCriteriaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAges($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAgesWeight($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUpdatedAt($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SearchCriteriaPeer::DATABASE_NAME);

		if ($this->isColumnModified(SearchCriteriaPeer::ID)) $criteria->add(SearchCriteriaPeer::ID, $this->id);
		if ($this->isColumnModified(SearchCriteriaPeer::AGES)) $criteria->add(SearchCriteriaPeer::AGES, $this->ages);
		if ($this->isColumnModified(SearchCriteriaPeer::AGES_WEIGHT)) $criteria->add(SearchCriteriaPeer::AGES_WEIGHT, $this->ages_weight);
		if ($this->isColumnModified(SearchCriteriaPeer::UPDATED_AT)) $criteria->add(SearchCriteriaPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SearchCriteriaPeer::DATABASE_NAME);

		$criteria->add(SearchCriteriaPeer::ID, $this->id);

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

		$copyObj->setAges($this->ages);

		$copyObj->setAgesWeight($this->ages_weight);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMembers() as $relObj) {
				$copyObj->addMember($relObj->copy($deepCopy));
			}

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
			self::$peer = new SearchCriteriaPeer();
		}
		return self::$peer;
	}

	
	public function initMembers()
	{
		if ($this->collMembers === null) {
			$this->collMembers = array();
		}
	}

	
	public function getMembers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
			   $this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				$this->collMembers = MemberPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
					$this->collMembers = MemberPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberCriteria = $criteria;
		return $this->collMembers;
	}

	
	public function countMembers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

		return MemberPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMember(Member $l)
	{
		$this->collMembers[] = $l;
		$l->setSearchCriteria($this);
	}


	
	public function getMembersJoinMemberStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinState($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinMemberPhoto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinSubscription($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinMemberCounter($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
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

				$criteria->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->getId());

				SearchCritDescPeer::addSelectColumns($criteria);
				$this->collSearchCritDescs = SearchCritDescPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->getId());

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

		$criteria->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->getId());

		return SearchCritDescPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSearchCritDesc(SearchCritDesc $l)
	{
		$this->collSearchCritDescs[] = $l;
		$l->setSearchCriteria($this);
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

				$criteria->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->getId());

				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinDescQuestion($criteria, $con);
			}
		} else {
									
			$criteria->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->getId());

			if (!isset($this->lastSearchCritDescCriteria) || !$this->lastSearchCritDescCriteria->equals($criteria)) {
				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinDescQuestion($criteria, $con);
			}
		}
		$this->lastSearchCritDescCriteria = $criteria;

		return $this->collSearchCritDescs;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseSearchCriteria:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseSearchCriteria::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 