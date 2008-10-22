<?php


abstract class BaseImbraQuestion extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;


	
	protected $explain_title;


	
	protected $positive_answer;


	
	protected $negative_answer;

	
	protected $collMemberImbraAnswers;

	
	protected $lastMemberImbraAnswerCriteria = null;

	
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

	
	public function getExplainTitle()
	{

		return $this->explain_title;
	}

	
	public function getPositiveAnswer()
	{

		return $this->positive_answer;
	}

	
	public function getNegativeAnswer()
	{

		return $this->negative_answer;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ImbraQuestionPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = ImbraQuestionPeer::TITLE;
		}

	} 
	
	public function setExplainTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->explain_title !== $v) {
			$this->explain_title = $v;
			$this->modifiedColumns[] = ImbraQuestionPeer::EXPLAIN_TITLE;
		}

	} 
	
	public function setPositiveAnswer($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->positive_answer !== $v) {
			$this->positive_answer = $v;
			$this->modifiedColumns[] = ImbraQuestionPeer::POSITIVE_ANSWER;
		}

	} 
	
	public function setNegativeAnswer($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->negative_answer !== $v) {
			$this->negative_answer = $v;
			$this->modifiedColumns[] = ImbraQuestionPeer::NEGATIVE_ANSWER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->explain_title = $rs->getString($startcol + 2);

			$this->positive_answer = $rs->getString($startcol + 3);

			$this->negative_answer = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ImbraQuestion object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestion:delete:pre') as $callable)
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
			$con = Propel::getConnection(ImbraQuestionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ImbraQuestionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseImbraQuestion:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestion:save:pre') as $callable)
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
			$con = Propel::getConnection(ImbraQuestionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseImbraQuestion:save:post') as $callable)
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
					$pk = ImbraQuestionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ImbraQuestionPeer::doUpdate($this, $con);
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


			if (($retval = ImbraQuestionPeer::doValidate($this, $columns)) !== true) {
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
		$pos = ImbraQuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getExplainTitle();
				break;
			case 3:
				return $this->getPositiveAnswer();
				break;
			case 4:
				return $this->getNegativeAnswer();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraQuestionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getExplainTitle(),
			$keys[3] => $this->getPositiveAnswer(),
			$keys[4] => $this->getNegativeAnswer(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ImbraQuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setExplainTitle($value);
				break;
			case 3:
				$this->setPositiveAnswer($value);
				break;
			case 4:
				$this->setNegativeAnswer($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraQuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setExplainTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPositiveAnswer($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNegativeAnswer($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ImbraQuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(ImbraQuestionPeer::ID)) $criteria->add(ImbraQuestionPeer::ID, $this->id);
		if ($this->isColumnModified(ImbraQuestionPeer::TITLE)) $criteria->add(ImbraQuestionPeer::TITLE, $this->title);
		if ($this->isColumnModified(ImbraQuestionPeer::EXPLAIN_TITLE)) $criteria->add(ImbraQuestionPeer::EXPLAIN_TITLE, $this->explain_title);
		if ($this->isColumnModified(ImbraQuestionPeer::POSITIVE_ANSWER)) $criteria->add(ImbraQuestionPeer::POSITIVE_ANSWER, $this->positive_answer);
		if ($this->isColumnModified(ImbraQuestionPeer::NEGATIVE_ANSWER)) $criteria->add(ImbraQuestionPeer::NEGATIVE_ANSWER, $this->negative_answer);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ImbraQuestionPeer::DATABASE_NAME);

		$criteria->add(ImbraQuestionPeer::ID, $this->id);

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

		$copyObj->setExplainTitle($this->explain_title);

		$copyObj->setPositiveAnswer($this->positive_answer);

		$copyObj->setNegativeAnswer($this->negative_answer);


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
			self::$peer = new ImbraQuestionPeer();
		}
		return self::$peer;
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

				$criteria->add(MemberImbraAnswerPeer::IMBRA_QUESTION_ID, $this->getId());

				MemberImbraAnswerPeer::addSelectColumns($criteria);
				$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberImbraAnswerPeer::IMBRA_QUESTION_ID, $this->getId());

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

		$criteria->add(MemberImbraAnswerPeer::IMBRA_QUESTION_ID, $this->getId());

		return MemberImbraAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberImbraAnswer(MemberImbraAnswer $l)
	{
		$this->collMemberImbraAnswers[] = $l;
		$l->setImbraQuestion($this);
	}


	
	public function getMemberImbraAnswersJoinMemberImbra($criteria = null, $con = null)
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

				$criteria->add(MemberImbraAnswerPeer::IMBRA_QUESTION_ID, $this->getId());

				$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelectJoinMemberImbra($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberImbraAnswerPeer::IMBRA_QUESTION_ID, $this->getId());

			if (!isset($this->lastMemberImbraAnswerCriteria) || !$this->lastMemberImbraAnswerCriteria->equals($criteria)) {
				$this->collMemberImbraAnswers = MemberImbraAnswerPeer::doSelectJoinMemberImbra($criteria, $con);
			}
		}
		$this->lastMemberImbraAnswerCriteria = $criteria;

		return $this->collMemberImbraAnswers;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseImbraQuestion:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseImbraQuestion::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 