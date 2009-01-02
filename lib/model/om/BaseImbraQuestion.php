<?php


abstract class BaseImbraQuestion extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $only_explain = false;

	
	protected $collImbraQuestionI18ns;

	
	protected $lastImbraQuestionI18nCriteria = null;

	
	protected $collMemberImbraAnswers;

	
	protected $lastMemberImbraAnswerCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getOnlyExplain()
	{

		return $this->only_explain;
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
	
	public function setOnlyExplain($v)
	{

		if ($this->only_explain !== $v || $v === false) {
			$this->only_explain = $v;
			$this->modifiedColumns[] = ImbraQuestionPeer::ONLY_EXPLAIN;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->only_explain = $rs->getBoolean($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
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

			if ($this->collImbraQuestionI18ns !== null) {
				foreach($this->collImbraQuestionI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

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


				if ($this->collImbraQuestionI18ns !== null) {
					foreach($this->collImbraQuestionI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
				return $this->getOnlyExplain();
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
			$keys[1] => $this->getOnlyExplain(),
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
				$this->setOnlyExplain($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraQuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOnlyExplain($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ImbraQuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(ImbraQuestionPeer::ID)) $criteria->add(ImbraQuestionPeer::ID, $this->id);
		if ($this->isColumnModified(ImbraQuestionPeer::ONLY_EXPLAIN)) $criteria->add(ImbraQuestionPeer::ONLY_EXPLAIN, $this->only_explain);

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

		$copyObj->setOnlyExplain($this->only_explain);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getImbraQuestionI18ns() as $relObj) {
				$copyObj->addImbraQuestionI18n($relObj->copy($deepCopy));
			}

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

	
	public function initImbraQuestionI18ns()
	{
		if ($this->collImbraQuestionI18ns === null) {
			$this->collImbraQuestionI18ns = array();
		}
	}

	
	public function getImbraQuestionI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseImbraQuestionI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collImbraQuestionI18ns === null) {
			if ($this->isNew()) {
			   $this->collImbraQuestionI18ns = array();
			} else {

				$criteria->add(ImbraQuestionI18nPeer::ID, $this->getId());

				ImbraQuestionI18nPeer::addSelectColumns($criteria);
				$this->collImbraQuestionI18ns = ImbraQuestionI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ImbraQuestionI18nPeer::ID, $this->getId());

				ImbraQuestionI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastImbraQuestionI18nCriteria) || !$this->lastImbraQuestionI18nCriteria->equals($criteria)) {
					$this->collImbraQuestionI18ns = ImbraQuestionI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastImbraQuestionI18nCriteria = $criteria;
		return $this->collImbraQuestionI18ns;
	}

	
	public function countImbraQuestionI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseImbraQuestionI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ImbraQuestionI18nPeer::ID, $this->getId());

		return ImbraQuestionI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addImbraQuestionI18n(ImbraQuestionI18n $l)
	{
		$this->collImbraQuestionI18ns[] = $l;
		$l->setImbraQuestion($this);
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

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getTitle()
  {
    $obj = $this->getCurrentImbraQuestionI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentImbraQuestionI18n()->setTitle($value);
  }

  public function getExplainTitle()
  {
    $obj = $this->getCurrentImbraQuestionI18n();

    return ($obj ? $obj->getExplainTitle() : null);
  }

  public function setExplainTitle($value)
  {
    $this->getCurrentImbraQuestionI18n()->setExplainTitle($value);
  }

  public function getPositiveAnswer()
  {
    $obj = $this->getCurrentImbraQuestionI18n();

    return ($obj ? $obj->getPositiveAnswer() : null);
  }

  public function setPositiveAnswer($value)
  {
    $this->getCurrentImbraQuestionI18n()->setPositiveAnswer($value);
  }

  public function getNegativeAnswer()
  {
    $obj = $this->getCurrentImbraQuestionI18n();

    return ($obj ? $obj->getNegativeAnswer() : null);
  }

  public function setNegativeAnswer($value)
  {
    $this->getCurrentImbraQuestionI18n()->setNegativeAnswer($value);
  }

  protected $current_i18n = array();

  public function getCurrentImbraQuestionI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ImbraQuestionI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setImbraQuestionI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setImbraQuestionI18nForCulture(new ImbraQuestionI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setImbraQuestionI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addImbraQuestionI18n($object);
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