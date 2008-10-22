<?php


abstract class BaseMemberImbra extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_id;


	
	protected $imbra_status_id;


	
	protected $text;


	
	protected $name;


	
	protected $dob;


	
	protected $address;


	
	protected $city;


	
	protected $state_id;


	
	protected $zip;


	
	protected $phone;


	
	protected $created_at;

	
	protected $aMember;

	
	protected $aImbraStatus;

	
	protected $aState;

	
	protected $collMemberImbraAnswers;

	
	protected $lastMemberImbraAnswerCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMemberId()
	{

		return $this->member_id;
	}

	
	public function getImbraStatusId()
	{

		return $this->imbra_status_id;
	}

	
	public function getText()
	{

		return $this->text;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getDob()
	{

		return $this->dob;
	}

	
	public function getAddress()
	{

		return $this->address;
	}

	
	public function getCity()
	{

		return $this->city;
	}

	
	public function getStateId()
	{

		return $this->state_id;
	}

	
	public function getZip()
	{

		return $this->zip;
	}

	
	public function getPhone()
	{

		return $this->phone;
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberImbraPeer::ID;
		}

	} 
	
	public function setMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = MemberImbraPeer::MEMBER_ID;
		}

		if ($this->aMember !== null && $this->aMember->getId() !== $v) {
			$this->aMember = null;
		}

	} 
	
	public function setImbraStatusId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->imbra_status_id !== $v) {
			$this->imbra_status_id = $v;
			$this->modifiedColumns[] = MemberImbraPeer::IMBRA_STATUS_ID;
		}

		if ($this->aImbraStatus !== null && $this->aImbraStatus->getId() !== $v) {
			$this->aImbraStatus = null;
		}

	} 
	
	public function setText($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->text !== $v) {
			$this->text = $v;
			$this->modifiedColumns[] = MemberImbraPeer::TEXT;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = MemberImbraPeer::NAME;
		}

	} 
	
	public function setDob($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->dob !== $v) {
			$this->dob = $v;
			$this->modifiedColumns[] = MemberImbraPeer::DOB;
		}

	} 
	
	public function setAddress($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->address !== $v) {
			$this->address = $v;
			$this->modifiedColumns[] = MemberImbraPeer::ADDRESS;
		}

	} 
	
	public function setCity($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->city !== $v) {
			$this->city = $v;
			$this->modifiedColumns[] = MemberImbraPeer::CITY;
		}

	} 
	
	public function setStateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->state_id !== $v) {
			$this->state_id = $v;
			$this->modifiedColumns[] = MemberImbraPeer::STATE_ID;
		}

		if ($this->aState !== null && $this->aState->getId() !== $v) {
			$this->aState = null;
		}

	} 
	
	public function setZip($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->zip !== $v) {
			$this->zip = $v;
			$this->modifiedColumns[] = MemberImbraPeer::ZIP;
		}

	} 
	
	public function setPhone($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone !== $v) {
			$this->phone = $v;
			$this->modifiedColumns[] = MemberImbraPeer::PHONE;
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
			$this->modifiedColumns[] = MemberImbraPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_id = $rs->getInt($startcol + 1);

			$this->imbra_status_id = $rs->getInt($startcol + 2);

			$this->text = $rs->getString($startcol + 3);

			$this->name = $rs->getString($startcol + 4);

			$this->dob = $rs->getString($startcol + 5);

			$this->address = $rs->getString($startcol + 6);

			$this->city = $rs->getString($startcol + 7);

			$this->state_id = $rs->getInt($startcol + 8);

			$this->zip = $rs->getString($startcol + 9);

			$this->phone = $rs->getString($startcol + 10);

			$this->created_at = $rs->getTimestamp($startcol + 11, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MemberImbra object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbra:delete:pre') as $callable)
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
			$con = Propel::getConnection(MemberImbraPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberImbraPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMemberImbra:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbra:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(MemberImbraPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MemberImbraPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMemberImbra:save:post') as $callable)
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


												
			if ($this->aMember !== null) {
				if ($this->aMember->isModified()) {
					$affectedRows += $this->aMember->save($con);
				}
				$this->setMember($this->aMember);
			}

			if ($this->aImbraStatus !== null) {
				if ($this->aImbraStatus->isModified()) {
					$affectedRows += $this->aImbraStatus->save($con);
				}
				$this->setImbraStatus($this->aImbraStatus);
			}

			if ($this->aState !== null) {
				if ($this->aState->isModified()) {
					$affectedRows += $this->aState->save($con);
				}
				$this->setState($this->aState);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MemberImbraPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberImbraPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMemberImbraAnswers !== null) {
				foreach($this->collMemberImbraAnswers as $referrerFK) {
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


												
			if ($this->aMember !== null) {
				if (!$this->aMember->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMember->getValidationFailures());
				}
			}

			if ($this->aImbraStatus !== null) {
				if (!$this->aImbraStatus->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aImbraStatus->getValidationFailures());
				}
			}

			if ($this->aState !== null) {
				if (!$this->aState->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aState->getValidationFailures());
				}
			}


			if (($retval = MemberImbraPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMemberImbraAnswers !== null) {
					foreach($this->collMemberImbraAnswers as $referrerFK) {
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
		$pos = MemberImbraPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMemberId();
				break;
			case 2:
				return $this->getImbraStatusId();
				break;
			case 3:
				return $this->getText();
				break;
			case 4:
				return $this->getName();
				break;
			case 5:
				return $this->getDob();
				break;
			case 6:
				return $this->getAddress();
				break;
			case 7:
				return $this->getCity();
				break;
			case 8:
				return $this->getStateId();
				break;
			case 9:
				return $this->getZip();
				break;
			case 10:
				return $this->getPhone();
				break;
			case 11:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberImbraPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberId(),
			$keys[2] => $this->getImbraStatusId(),
			$keys[3] => $this->getText(),
			$keys[4] => $this->getName(),
			$keys[5] => $this->getDob(),
			$keys[6] => $this->getAddress(),
			$keys[7] => $this->getCity(),
			$keys[8] => $this->getStateId(),
			$keys[9] => $this->getZip(),
			$keys[10] => $this->getPhone(),
			$keys[11] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberImbraPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMemberId($value);
				break;
			case 2:
				$this->setImbraStatusId($value);
				break;
			case 3:
				$this->setText($value);
				break;
			case 4:
				$this->setName($value);
				break;
			case 5:
				$this->setDob($value);
				break;
			case 6:
				$this->setAddress($value);
				break;
			case 7:
				$this->setCity($value);
				break;
			case 8:
				$this->setStateId($value);
				break;
			case 9:
				$this->setZip($value);
				break;
			case 10:
				$this->setPhone($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberImbraPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setImbraStatusId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setText($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDob($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAddress($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCity($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setStateId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setZip($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPhone($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberImbraPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberImbraPeer::ID)) $criteria->add(MemberImbraPeer::ID, $this->id);
		if ($this->isColumnModified(MemberImbraPeer::MEMBER_ID)) $criteria->add(MemberImbraPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(MemberImbraPeer::IMBRA_STATUS_ID)) $criteria->add(MemberImbraPeer::IMBRA_STATUS_ID, $this->imbra_status_id);
		if ($this->isColumnModified(MemberImbraPeer::TEXT)) $criteria->add(MemberImbraPeer::TEXT, $this->text);
		if ($this->isColumnModified(MemberImbraPeer::NAME)) $criteria->add(MemberImbraPeer::NAME, $this->name);
		if ($this->isColumnModified(MemberImbraPeer::DOB)) $criteria->add(MemberImbraPeer::DOB, $this->dob);
		if ($this->isColumnModified(MemberImbraPeer::ADDRESS)) $criteria->add(MemberImbraPeer::ADDRESS, $this->address);
		if ($this->isColumnModified(MemberImbraPeer::CITY)) $criteria->add(MemberImbraPeer::CITY, $this->city);
		if ($this->isColumnModified(MemberImbraPeer::STATE_ID)) $criteria->add(MemberImbraPeer::STATE_ID, $this->state_id);
		if ($this->isColumnModified(MemberImbraPeer::ZIP)) $criteria->add(MemberImbraPeer::ZIP, $this->zip);
		if ($this->isColumnModified(MemberImbraPeer::PHONE)) $criteria->add(MemberImbraPeer::PHONE, $this->phone);
		if ($this->isColumnModified(MemberImbraPeer::CREATED_AT)) $criteria->add(MemberImbraPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberImbraPeer::DATABASE_NAME);

		$criteria->add(MemberImbraPeer::ID, $this->id);

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

		$copyObj->setMemberId($this->member_id);

		$copyObj->setImbraStatusId($this->imbra_status_id);

		$copyObj->setText($this->text);

		$copyObj->setName($this->name);

		$copyObj->setDob($this->dob);

		$copyObj->setAddress($this->address);

		$copyObj->setCity($this->city);

		$copyObj->setStateId($this->state_id);

		$copyObj->setZip($this->zip);

		$copyObj->setPhone($this->phone);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMemberImbraAnswers() as $relObj) {
				$copyObj->addMemberImbraAnswer($relObj->copy($deepCopy));
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
			self::$peer = new MemberImbraPeer();
		}
		return self::$peer;
	}

	
	public function setMember($v)
	{


		if ($v === null) {
			$this->setMemberId(NULL);
		} else {
			$this->setMemberId($v->getId());
		}


		$this->aMember = $v;
	}


	
	public function getMember($con = null)
	{
		if ($this->aMember === null && ($this->member_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMember = MemberPeer::retrieveByPK($this->member_id, $con);

			
		}
		return $this->aMember;
	}

	
	public function setImbraStatus($v)
	{


		if ($v === null) {
			$this->setImbraStatusId(NULL);
		} else {
			$this->setImbraStatusId($v->getId());
		}


		$this->aImbraStatus = $v;
	}


	
	public function getImbraStatus($con = null)
	{
		if ($this->aImbraStatus === null && ($this->imbra_status_id !== null)) {
						include_once 'lib/model/om/BaseImbraStatusPeer.php';

			$this->aImbraStatus = ImbraStatusPeer::retrieveByPK($this->imbra_status_id, $con);

			
		}
		return $this->aImbraStatus;
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

	
	public function initMemberImbraAnswers()
	{
		if ($this->collMemberImbraAnswers === null) {
			$this->collMemberImbraAnswers = array();
		}
	}

	
	public function getMemberImbraAnswers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbraAnswers === null) {
			if ($this->isNew()) {
			   $this->collMemberImbraAnswers = array();
			} else {

				$criteria->add(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, $this->getId());

				MemberImbraAnswerPeer::addSelectColumns($criteria);
				$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, $this->getId());

				MemberImbraAnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberImbraAnswerCriteria) || !$this->lastMemberImbraAnswerCriteria->equals($criteria)) {
					$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberImbraAnswerCriteria = $criteria;
		return $this->collMemberImbraAnswers;
	}

	
	public function countMemberImbraAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, $this->getId());

		return MemberImbraAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberImbraAnswer(MemberImbraAnswer $l)
	{
		$this->collMemberImbraAnswers[] = $l;
		$l->setMemberImbra($this);
	}


	
	public function getMemberImbraAnswersJoinImbraQuestion($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberImbraAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberImbraAnswers === null) {
			if ($this->isNew()) {
				$this->collMemberImbraAnswers = array();
			} else {

				$criteria->add(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, $this->getId());

				$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelectJoinImbraQuestion($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, $this->getId());

			if (!isset($this->lastMemberImbraAnswerCriteria) || !$this->lastMemberImbraAnswerCriteria->equals($criteria)) {
				$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelectJoinImbraQuestion($criteria, $con);
			}
		}
		$this->lastMemberImbraAnswerCriteria = $criteria;

		return $this->collMemberImbraAnswers;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMemberImbra:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMemberImbra::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 