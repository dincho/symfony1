<?php


abstract class BaseMemberImbraAnswer extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_imbra_id;


	
	protected $imbra_question_id;


	
	protected $answer = false;


	
	protected $explanation;

	
	protected $aMemberImbra;

	
	protected $aImbraQuestion;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMemberImbraId()
	{

		return $this->member_imbra_id;
	}

	
	public function getImbraQuestionId()
	{

		return $this->imbra_question_id;
	}

	
	public function getAnswer()
	{

		return $this->answer;
	}

	
	public function getExplanation()
	{

		return $this->explanation;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberImbraAnswerPeer::ID;
		}

	} 
	
	public function setMemberImbraId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_imbra_id !== $v) {
			$this->member_imbra_id = $v;
			$this->modifiedColumns[] = MemberImbraAnswerPeer::MEMBER_IMBRA_ID;
		}

		if ($this->aMemberImbra !== null && $this->aMemberImbra->getId() !== $v) {
			$this->aMemberImbra = null;
		}

	} 
	
	public function setImbraQuestionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->imbra_question_id !== $v) {
			$this->imbra_question_id = $v;
			$this->modifiedColumns[] = MemberImbraAnswerPeer::IMBRA_QUESTION_ID;
		}

		if ($this->aImbraQuestion !== null && $this->aImbraQuestion->getId() !== $v) {
			$this->aImbraQuestion = null;
		}

	} 
	
	public function setAnswer($v)
	{

		if ($this->answer !== $v || $v === false) {
			$this->answer = $v;
			$this->modifiedColumns[] = MemberImbraAnswerPeer::ANSWER;
		}

	} 
	
	public function setExplanation($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->explanation !== $v) {
			$this->explanation = $v;
			$this->modifiedColumns[] = MemberImbraAnswerPeer::EXPLANATION;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_imbra_id = $rs->getInt($startcol + 1);

			$this->imbra_question_id = $rs->getInt($startcol + 2);

			$this->answer = $rs->getBoolean($startcol + 3);

			$this->explanation = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MemberImbraAnswer object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbraAnswer:delete:pre') as $callable)
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
			$con = Propel::getConnection(MemberImbraAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberImbraAnswerPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMemberImbraAnswer:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbraAnswer:save:pre') as $callable)
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
			$con = Propel::getConnection(MemberImbraAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMemberImbraAnswer:save:post') as $callable)
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


												
			if ($this->aMemberImbra !== null) {
				if ($this->aMemberImbra->isModified()) {
					$affectedRows += $this->aMemberImbra->save($con);
				}
				$this->setMemberImbra($this->aMemberImbra);
			}

			if ($this->aImbraQuestion !== null) {
				if ($this->aImbraQuestion->isModified()) {
					$affectedRows += $this->aImbraQuestion->save($con);
				}
				$this->setImbraQuestion($this->aImbraQuestion);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MemberImbraAnswerPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberImbraAnswerPeer::doUpdate($this, $con);
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


												
			if ($this->aMemberImbra !== null) {
				if (!$this->aMemberImbra->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMemberImbra->getValidationFailures());
				}
			}

			if ($this->aImbraQuestion !== null) {
				if (!$this->aImbraQuestion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aImbraQuestion->getValidationFailures());
				}
			}


			if (($retval = MemberImbraAnswerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberImbraAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMemberImbraId();
				break;
			case 2:
				return $this->getImbraQuestionId();
				break;
			case 3:
				return $this->getAnswer();
				break;
			case 4:
				return $this->getExplanation();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberImbraAnswerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberImbraId(),
			$keys[2] => $this->getImbraQuestionId(),
			$keys[3] => $this->getAnswer(),
			$keys[4] => $this->getExplanation(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberImbraAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMemberImbraId($value);
				break;
			case 2:
				$this->setImbraQuestionId($value);
				break;
			case 3:
				$this->setAnswer($value);
				break;
			case 4:
				$this->setExplanation($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberImbraAnswerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberImbraId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setImbraQuestionId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAnswer($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setExplanation($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberImbraAnswerPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberImbraAnswerPeer::ID)) $criteria->add(MemberImbraAnswerPeer::ID, $this->id);
		if ($this->isColumnModified(MemberImbraAnswerPeer::MEMBER_IMBRA_ID)) $criteria->add(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, $this->member_imbra_id);
		if ($this->isColumnModified(MemberImbraAnswerPeer::IMBRA_QUESTION_ID)) $criteria->add(MemberImbraAnswerPeer::IMBRA_QUESTION_ID, $this->imbra_question_id);
		if ($this->isColumnModified(MemberImbraAnswerPeer::ANSWER)) $criteria->add(MemberImbraAnswerPeer::ANSWER, $this->answer);
		if ($this->isColumnModified(MemberImbraAnswerPeer::EXPLANATION)) $criteria->add(MemberImbraAnswerPeer::EXPLANATION, $this->explanation);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberImbraAnswerPeer::DATABASE_NAME);

		$criteria->add(MemberImbraAnswerPeer::ID, $this->id);

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

		$copyObj->setMemberImbraId($this->member_imbra_id);

		$copyObj->setImbraQuestionId($this->imbra_question_id);

		$copyObj->setAnswer($this->answer);

		$copyObj->setExplanation($this->explanation);


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
			self::$peer = new MemberImbraAnswerPeer();
		}
		return self::$peer;
	}

	
	public function setMemberImbra($v)
	{


		if ($v === null) {
			$this->setMemberImbraId(NULL);
		} else {
			$this->setMemberImbraId($v->getId());
		}


		$this->aMemberImbra = $v;
	}


	
	public function getMemberImbra($con = null)
	{
		if ($this->aMemberImbra === null && ($this->member_imbra_id !== null)) {
						include_once 'lib/model/om/BaseMemberImbraPeer.php';

			$this->aMemberImbra = MemberImbraPeer::retrieveByPK($this->member_imbra_id, $con);

			
		}
		return $this->aMemberImbra;
	}

	
	public function setImbraQuestion($v)
	{


		if ($v === null) {
			$this->setImbraQuestionId(NULL);
		} else {
			$this->setImbraQuestionId($v->getId());
		}


		$this->aImbraQuestion = $v;
	}


	
	public function getImbraQuestion($con = null)
	{
		if ($this->aImbraQuestion === null && ($this->imbra_question_id !== null)) {
						include_once 'lib/model/om/BaseImbraQuestionPeer.php';

			$this->aImbraQuestion = ImbraQuestionPeer::retrieveByPK($this->imbra_question_id, $con);

			
		}
		return $this->aImbraQuestion;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMemberImbraAnswer:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMemberImbraAnswer::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 