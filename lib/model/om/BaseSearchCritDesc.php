<?php


abstract class BaseSearchCritDesc extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $search_criteria_id;


	
	protected $desc_question_id;


	
	protected $desc_answers;


	
	protected $match_weight;

	
	protected $aSearchCriteria;

	
	protected $aDescQuestion;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSearchCriteriaId()
	{

		return $this->search_criteria_id;
	}

	
	public function getDescQuestionId()
	{

		return $this->desc_question_id;
	}

	
	public function getDescAnswers()
	{

		return $this->desc_answers;
	}

	
	public function getMatchWeight()
	{

		return $this->match_weight;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SearchCritDescPeer::ID;
		}

	} 
	
	public function setSearchCriteriaId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->search_criteria_id !== $v) {
			$this->search_criteria_id = $v;
			$this->modifiedColumns[] = SearchCritDescPeer::SEARCH_CRITERIA_ID;
		}

		if ($this->aSearchCriteria !== null && $this->aSearchCriteria->getId() !== $v) {
			$this->aSearchCriteria = null;
		}

	} 
	
	public function setDescQuestionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->desc_question_id !== $v) {
			$this->desc_question_id = $v;
			$this->modifiedColumns[] = SearchCritDescPeer::DESC_QUESTION_ID;
		}

		if ($this->aDescQuestion !== null && $this->aDescQuestion->getId() !== $v) {
			$this->aDescQuestion = null;
		}

	} 
	
	public function setDescAnswers($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->desc_answers !== $v) {
			$this->desc_answers = $v;
			$this->modifiedColumns[] = SearchCritDescPeer::DESC_ANSWERS;
		}

	} 
	
	public function setMatchWeight($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->match_weight !== $v) {
			$this->match_weight = $v;
			$this->modifiedColumns[] = SearchCritDescPeer::MATCH_WEIGHT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->search_criteria_id = $rs->getInt($startcol + 1);

			$this->desc_question_id = $rs->getInt($startcol + 2);

			$this->desc_answers = $rs->getString($startcol + 3);

			$this->match_weight = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating SearchCritDesc object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCritDesc:delete:pre') as $callable)
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
			$con = Propel::getConnection(SearchCritDescPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SearchCritDescPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseSearchCritDesc:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCritDesc:save:pre') as $callable)
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
			$con = Propel::getConnection(SearchCritDescPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseSearchCritDesc:save:post') as $callable)
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


												
			if ($this->aSearchCriteria !== null) {
				if ($this->aSearchCriteria->isModified()) {
					$affectedRows += $this->aSearchCriteria->save($con);
				}
				$this->setSearchCriteria($this->aSearchCriteria);
			}

			if ($this->aDescQuestion !== null) {
				if ($this->aDescQuestion->isModified()) {
					$affectedRows += $this->aDescQuestion->save($con);
				}
				$this->setDescQuestion($this->aDescQuestion);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SearchCritDescPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SearchCritDescPeer::doUpdate($this, $con);
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


												
			if ($this->aSearchCriteria !== null) {
				if (!$this->aSearchCriteria->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSearchCriteria->getValidationFailures());
				}
			}

			if ($this->aDescQuestion !== null) {
				if (!$this->aDescQuestion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDescQuestion->getValidationFailures());
				}
			}


			if (($retval = SearchCritDescPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SearchCritDescPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSearchCriteriaId();
				break;
			case 2:
				return $this->getDescQuestionId();
				break;
			case 3:
				return $this->getDescAnswers();
				break;
			case 4:
				return $this->getMatchWeight();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SearchCritDescPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSearchCriteriaId(),
			$keys[2] => $this->getDescQuestionId(),
			$keys[3] => $this->getDescAnswers(),
			$keys[4] => $this->getMatchWeight(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SearchCritDescPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSearchCriteriaId($value);
				break;
			case 2:
				$this->setDescQuestionId($value);
				break;
			case 3:
				$this->setDescAnswers($value);
				break;
			case 4:
				$this->setMatchWeight($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SearchCritDescPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSearchCriteriaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescQuestionId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescAnswers($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMatchWeight($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SearchCritDescPeer::DATABASE_NAME);

		if ($this->isColumnModified(SearchCritDescPeer::ID)) $criteria->add(SearchCritDescPeer::ID, $this->id);
		if ($this->isColumnModified(SearchCritDescPeer::SEARCH_CRITERIA_ID)) $criteria->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->search_criteria_id);
		if ($this->isColumnModified(SearchCritDescPeer::DESC_QUESTION_ID)) $criteria->add(SearchCritDescPeer::DESC_QUESTION_ID, $this->desc_question_id);
		if ($this->isColumnModified(SearchCritDescPeer::DESC_ANSWERS)) $criteria->add(SearchCritDescPeer::DESC_ANSWERS, $this->desc_answers);
		if ($this->isColumnModified(SearchCritDescPeer::MATCH_WEIGHT)) $criteria->add(SearchCritDescPeer::MATCH_WEIGHT, $this->match_weight);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SearchCritDescPeer::DATABASE_NAME);

		$criteria->add(SearchCritDescPeer::ID, $this->id);

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

		$copyObj->setSearchCriteriaId($this->search_criteria_id);

		$copyObj->setDescQuestionId($this->desc_question_id);

		$copyObj->setDescAnswers($this->desc_answers);

		$copyObj->setMatchWeight($this->match_weight);


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
			self::$peer = new SearchCritDescPeer();
		}
		return self::$peer;
	}

	
	public function setSearchCriteria($v)
	{


		if ($v === null) {
			$this->setSearchCriteriaId(NULL);
		} else {
			$this->setSearchCriteriaId($v->getId());
		}


		$this->aSearchCriteria = $v;
	}


	
	public function getSearchCriteria($con = null)
	{
		if ($this->aSearchCriteria === null && ($this->search_criteria_id !== null)) {
						include_once 'lib/model/om/BaseSearchCriteriaPeer.php';

			$this->aSearchCriteria = SearchCriteriaPeer::retrieveByPK($this->search_criteria_id, $con);

			
		}
		return $this->aSearchCriteria;
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
    if (!$callable = sfMixer::getCallable('BaseSearchCritDesc:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseSearchCritDesc::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 