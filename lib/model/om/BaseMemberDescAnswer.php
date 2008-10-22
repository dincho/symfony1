<?php


abstract class BaseMemberDescAnswer extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_id;


	
	protected $desc_question_id;


	
	protected $desc_answer_id = 0;


	
	protected $other;


	
	protected $custom;

	
	protected $aMember;

	
	protected $aDescQuestion;

	
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

	
	public function getDescQuestionId()
	{

		return $this->desc_question_id;
	}

	
	public function getDescAnswerId()
	{

		return $this->desc_answer_id;
	}

	
	public function getOther()
	{

		return $this->other;
	}

	
	public function getCustom()
	{

		return $this->custom;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberDescAnswerPeer::ID;
		}

	} 
	
	public function setMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = MemberDescAnswerPeer::MEMBER_ID;
		}

		if ($this->aMember !== null && $this->aMember->getId() !== $v) {
			$this->aMember = null;
		}

	} 
	
	public function setDescQuestionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->desc_question_id !== $v) {
			$this->desc_question_id = $v;
			$this->modifiedColumns[] = MemberDescAnswerPeer::DESC_QUESTION_ID;
		}

		if ($this->aDescQuestion !== null && $this->aDescQuestion->getId() !== $v) {
			$this->aDescQuestion = null;
		}

	} 
	
	public function setDescAnswerId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->desc_answer_id !== $v || $v === 0) {
			$this->desc_answer_id = $v;
			$this->modifiedColumns[] = MemberDescAnswerPeer::DESC_ANSWER_ID;
		}

	} 
	
	public function setOther($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->other !== $v) {
			$this->other = $v;
			$this->modifiedColumns[] = MemberDescAnswerPeer::OTHER;
		}

	} 
	
	public function setCustom($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->custom !== $v) {
			$this->custom = $v;
			$this->modifiedColumns[] = MemberDescAnswerPeer::CUSTOM;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_id = $rs->getInt($startcol + 1);

			$this->desc_question_id = $rs->getInt($startcol + 2);

			$this->desc_answer_id = $rs->getInt($startcol + 3);

			$this->other = $rs->getString($startcol + 4);

			$this->custom = $rs->getString($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MemberDescAnswer object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberDescAnswer:delete:pre') as $callable)
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
			$con = Propel::getConnection(MemberDescAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberDescAnswerPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMemberDescAnswer:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberDescAnswer:save:pre') as $callable)
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
			$con = Propel::getConnection(MemberDescAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMemberDescAnswer:save:post') as $callable)
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

			if ($this->aDescQuestion !== null) {
				if ($this->aDescQuestion->isModified()) {
					$affectedRows += $this->aDescQuestion->save($con);
				}
				$this->setDescQuestion($this->aDescQuestion);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MemberDescAnswerPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberDescAnswerPeer::doUpdate($this, $con);
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


												
			if ($this->aMember !== null) {
				if (!$this->aMember->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMember->getValidationFailures());
				}
			}

			if ($this->aDescQuestion !== null) {
				if (!$this->aDescQuestion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDescQuestion->getValidationFailures());
				}
			}


			if (($retval = MemberDescAnswerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberDescAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDescQuestionId();
				break;
			case 3:
				return $this->getDescAnswerId();
				break;
			case 4:
				return $this->getOther();
				break;
			case 5:
				return $this->getCustom();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberDescAnswerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberId(),
			$keys[2] => $this->getDescQuestionId(),
			$keys[3] => $this->getDescAnswerId(),
			$keys[4] => $this->getOther(),
			$keys[5] => $this->getCustom(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberDescAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDescQuestionId($value);
				break;
			case 3:
				$this->setDescAnswerId($value);
				break;
			case 4:
				$this->setOther($value);
				break;
			case 5:
				$this->setCustom($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberDescAnswerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescQuestionId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescAnswerId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOther($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCustom($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberDescAnswerPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberDescAnswerPeer::ID)) $criteria->add(MemberDescAnswerPeer::ID, $this->id);
		if ($this->isColumnModified(MemberDescAnswerPeer::MEMBER_ID)) $criteria->add(MemberDescAnswerPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(MemberDescAnswerPeer::DESC_QUESTION_ID)) $criteria->add(MemberDescAnswerPeer::DESC_QUESTION_ID, $this->desc_question_id);
		if ($this->isColumnModified(MemberDescAnswerPeer::DESC_ANSWER_ID)) $criteria->add(MemberDescAnswerPeer::DESC_ANSWER_ID, $this->desc_answer_id);
		if ($this->isColumnModified(MemberDescAnswerPeer::OTHER)) $criteria->add(MemberDescAnswerPeer::OTHER, $this->other);
		if ($this->isColumnModified(MemberDescAnswerPeer::CUSTOM)) $criteria->add(MemberDescAnswerPeer::CUSTOM, $this->custom);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberDescAnswerPeer::DATABASE_NAME);

		$criteria->add(MemberDescAnswerPeer::ID, $this->id);

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

		$copyObj->setDescQuestionId($this->desc_question_id);

		$copyObj->setDescAnswerId($this->desc_answer_id);

		$copyObj->setOther($this->other);

		$copyObj->setCustom($this->custom);


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
			self::$peer = new MemberDescAnswerPeer();
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

	
	public function setDescQuestion($v)
	{


		if ($v === null) {
			$this->setDescQuestionId(NULL);
		} else {
			$this->setDescQuestionId($v->getId());
		}


		$this->aDescQuestion = $v;
	}


	
	public function getDescQuestion($con = null)
	{
		if ($this->aDescQuestion === null && ($this->desc_question_id !== null)) {
						include_once 'lib/model/om/BaseDescQuestionPeer.php';

			$this->aDescQuestion = DescQuestionPeer::retrieveByPK($this->desc_question_id, $con);

			
		}
		return $this->aDescQuestion;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMemberDescAnswer:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMemberDescAnswer::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 