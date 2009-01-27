<?php


abstract class BaseState extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $country;


	
	protected $title;


	
	protected $info;

	
	protected $collStatePhotos;

	
	protected $lastStatePhotoCriteria = null;

	
	protected $collMembers;

	
	protected $lastMemberCriteria = null;

	
	protected $collMemberImbras;

	
	protected $lastMemberImbraCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCountry()
	{

		return $this->country;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getInfo()
	{

		return $this->info;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = StatePeer::ID;
		}

	} 
	
	public function setCountry($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->country !== $v) {
			$this->country = $v;
			$this->modifiedColumns[] = StatePeer::COUNTRY;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = StatePeer::TITLE;
		}

	} 
	
	public function setInfo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->info !== $v) {
			$this->info = $v;
			$this->modifiedColumns[] = StatePeer::INFO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->country = $rs->getString($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->info = $rs->getString($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating State object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseState:delete:pre') as $callable)
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
			$con = Propel::getConnection(StatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			StatePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseState:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseState:save:pre') as $callable)
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
			$con = Propel::getConnection(StatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseState:save:post') as $callable)
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
					$pk = StatePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += StatePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collStatePhotos !== null) {
				foreach($this->collStatePhotos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMembers !== null) {
				foreach($this->collMembers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberImbras !== null) {
				foreach($this->collMemberImbras as $referrerFK) {
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


			if (($retval = StatePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collStatePhotos !== null) {
					foreach($this->collStatePhotos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMembers !== null) {
					foreach($this->collMembers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberImbras !== null) {
					foreach($this->collMemberImbras as $referrerFK) {
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
		$pos = StatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCountry();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getInfo();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StatePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCountry(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getInfo(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCountry($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setInfo($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StatePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCountry($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInfo($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(StatePeer::DATABASE_NAME);

		if ($this->isColumnModified(StatePeer::ID)) $criteria->add(StatePeer::ID, $this->id);
		if ($this->isColumnModified(StatePeer::COUNTRY)) $criteria->add(StatePeer::COUNTRY, $this->country);
		if ($this->isColumnModified(StatePeer::TITLE)) $criteria->add(StatePeer::TITLE, $this->title);
		if ($this->isColumnModified(StatePeer::INFO)) $criteria->add(StatePeer::INFO, $this->info);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(StatePeer::DATABASE_NAME);

		$criteria->add(StatePeer::ID, $this->id);

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

		$copyObj->setCountry($this->country);

		$copyObj->setTitle($this->title);

		$copyObj->setInfo($this->info);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getStatePhotos() as $relObj) {
				$copyObj->addStatePhoto($relObj->copy($deepCopy));
			}

			foreach($this->getMembers() as $relObj) {
				$copyObj->addMember($relObj->copy($deepCopy));
			}

			foreach($this->getMemberImbras() as $relObj) {
				$copyObj->addMemberImbra($relObj->copy($deepCopy));
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
			self::$peer = new StatePeer();
		}
		return self::$peer;
	}

	
	public function initStatePhotos()
	{
		if ($this->collStatePhotos === null) {
			$this->collStatePhotos = array();
		}
	}

	
	public function getStatePhotos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseStatePhotoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collStatePhotos === null) {
			if ($this->isNew()) {
			   $this->collStatePhotos = array();
			} else {

				$criteria->add(StatePhotoPeer::STATE_ID, $this->getId());

				StatePhotoPeer::addSelectColumns($criteria);
				$this->collStatePhotos = StatePhotoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(StatePhotoPeer::STATE_ID, $this->getId());

				StatePhotoPeer::addSelectColumns($criteria);
				if (!isset($this->lastStatePhotoCriteria) || !$this->lastStatePhotoCriteria->equals($criteria)) {
					$this->collStatePhotos = StatePhotoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastStatePhotoCriteria = $criteria;
		return $this->collStatePhotos;
	}

	
	public function countStatePhotos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseStatePhotoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(StatePhotoPeer::STATE_ID, $this->getId());

		return StatePhotoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addStatePhoto(StatePhoto $l)
	{
		$this->collStatePhotos[] = $l;
		$l->setState($this);
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

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				$this->collMembers = MemberPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

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

		$criteria->add(MemberPeer::STATE_ID, $this->getId());

		return MemberPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMember(Member $l)
	{
		$this->collMembers[] = $l;
		$l->setState($this);
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

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::STATE_ID, $this->getId());

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

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::STATE_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinUser($criteria, $con);
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

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::STATE_ID, $this->getId());

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

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::STATE_ID, $this->getId());

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

				$criteria->add(MemberPeer::STATE_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::STATE_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}

	
	public function initMemberImbras()
	{
		if ($this->collMemberImbras === null) {
			$this->collMemberImbras = array();
		}
	}

	
	public function getMemberImbras($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbras === null) {
			if ($this->isNew()) {
			   $this->collMemberImbras = array();
			} else {

				$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

				MemberImbraPeer::addSelectColumns($criteria);
				$this->collMemberImbras = MemberImbraPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

				MemberImbraPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberImbraCriteria) || !$this->lastMemberImbraCriteria->equals($criteria)) {
					$this->collMemberImbras = MemberImbraPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberImbraCriteria = $criteria;
		return $this->collMemberImbras;
	}

	
	public function countMemberImbras($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

		return MemberImbraPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberImbra(MemberImbra $l)
	{
		$this->collMemberImbras[] = $l;
		$l->setState($this);
	}


	
	public function getMemberImbrasJoinMember($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbras === null) {
			if ($this->isNew()) {
				$this->collMemberImbras = array();
			} else {

				$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

				$this->collMemberImbras = MemberImbraPeer::doSelectJoinMember($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

			if (!isset($this->lastMemberImbraCriteria) || !$this->lastMemberImbraCriteria->equals($criteria)) {
				$this->collMemberImbras = MemberImbraPeer::doSelectJoinMember($criteria, $con);
			}
		}
		$this->lastMemberImbraCriteria = $criteria;

		return $this->collMemberImbras;
	}


	
	public function getMemberImbrasJoinImbraStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbras === null) {
			if ($this->isNew()) {
				$this->collMemberImbras = array();
			} else {

				$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

				$this->collMemberImbras = MemberImbraPeer::doSelectJoinImbraStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberImbraPeer::STATE_ID, $this->getId());

			if (!isset($this->lastMemberImbraCriteria) || !$this->lastMemberImbraCriteria->equals($criteria)) {
				$this->collMemberImbras = MemberImbraPeer::doSelectJoinImbraStatus($criteria, $con);
			}
		}
		$this->lastMemberImbraCriteria = $criteria;

		return $this->collMemberImbras;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseState:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseState::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 