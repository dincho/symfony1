<?php


abstract class BaseDescQuestion extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;


	
	protected $search_title;


	
	protected $desc_title;


	
	protected $factor_title;


	
	protected $type;


	
	protected $is_required = true;


	
	protected $select_greather = false;

	
	protected $collDescAnswers;

	
	protected $lastDescAnswerCriteria = null;

	
	protected $collMemberDescAnswers;

	
	protected $lastMemberDescAnswerCriteria = null;

	
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

	
	public function getSearchTitle()
	{

		return $this->search_title;
	}

	
	public function getDescTitle()
	{

		return $this->desc_title;
	}

	
	public function getFactorTitle()
	{

		return $this->factor_title;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getIsRequired()
	{

		return $this->is_required;
	}

	
	public function getSelectGreather()
	{

		return $this->select_greather;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = DescQuestionPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = DescQuestionPeer::TITLE;
		}

	} 
	
	public function setSearchTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->search_title !== $v) {
			$this->search_title = $v;
			$this->modifiedColumns[] = DescQuestionPeer::SEARCH_TITLE;
		}

	} 
	
	public function setDescTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->desc_title !== $v) {
			$this->desc_title = $v;
			$this->modifiedColumns[] = DescQuestionPeer::DESC_TITLE;
		}

	} 
	
	public function setFactorTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->factor_title !== $v) {
			$this->factor_title = $v;
			$this->modifiedColumns[] = DescQuestionPeer::FACTOR_TITLE;
		}

	} 
	
	public function setType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = DescQuestionPeer::TYPE;
		}

	} 
	
	public function setIsRequired($v)
	{

		if ($this->is_required !== $v || $v === true) {
			$this->is_required = $v;
			$this->modifiedColumns[] = DescQuestionPeer::IS_REQUIRED;
		}

	} 
	
	public function setSelectGreather($v)
	{

		if ($this->select_greather !== $v || $v === false) {
			$this->select_greather = $v;
			$this->modifiedColumns[] = DescQuestionPeer::SELECT_GREATHER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->search_title = $rs->getString($startcol + 2);

			$this->desc_title = $rs->getString($startcol + 3);

			$this->factor_title = $rs->getString($startcol + 4);

			$this->type = $rs->getString($startcol + 5);

			$this->is_required = $rs->getBoolean($startcol + 6);

			$this->select_greather = $rs->getBoolean($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating DescQuestion object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseDescQuestion:delete:pre') as $callable)
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
			$con = Propel::getConnection(DescQuestionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DescQuestionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseDescQuestion:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseDescQuestion:save:pre') as $callable)
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
			$con = Propel::getConnection(DescQuestionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseDescQuestion:save:post') as $callable)
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
					$pk = DescQuestionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DescQuestionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collDescAnswers !== null) {
				foreach($this->collDescAnswers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberDescAnswers !== null) {
				foreach($this->collMemberDescAnswers as $referrerFK) {
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


			if (($retval = DescQuestionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDescAnswers !== null) {
					foreach($this->collDescAnswers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberDescAnswers !== null) {
					foreach($this->collMemberDescAnswers as $referrerFK) {
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
		$pos = DescQuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSearchTitle();
				break;
			case 3:
				return $this->getDescTitle();
				break;
			case 4:
				return $this->getFactorTitle();
				break;
			case 5:
				return $this->getType();
				break;
			case 6:
				return $this->getIsRequired();
				break;
			case 7:
				return $this->getSelectGreather();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DescQuestionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getSearchTitle(),
			$keys[3] => $this->getDescTitle(),
			$keys[4] => $this->getFactorTitle(),
			$keys[5] => $this->getType(),
			$keys[6] => $this->getIsRequired(),
			$keys[7] => $this->getSelectGreather(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DescQuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSearchTitle($value);
				break;
			case 3:
				$this->setDescTitle($value);
				break;
			case 4:
				$this->setFactorTitle($value);
				break;
			case 5:
				$this->setType($value);
				break;
			case 6:
				$this->setIsRequired($value);
				break;
			case 7:
				$this->setSelectGreather($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DescQuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSearchTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFactorTitle($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setType($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsRequired($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setSelectGreather($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DescQuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(DescQuestionPeer::ID)) $criteria->add(DescQuestionPeer::ID, $this->id);
		if ($this->isColumnModified(DescQuestionPeer::TITLE)) $criteria->add(DescQuestionPeer::TITLE, $this->title);
		if ($this->isColumnModified(DescQuestionPeer::SEARCH_TITLE)) $criteria->add(DescQuestionPeer::SEARCH_TITLE, $this->search_title);
		if ($this->isColumnModified(DescQuestionPeer::DESC_TITLE)) $criteria->add(DescQuestionPeer::DESC_TITLE, $this->desc_title);
		if ($this->isColumnModified(DescQuestionPeer::FACTOR_TITLE)) $criteria->add(DescQuestionPeer::FACTOR_TITLE, $this->factor_title);
		if ($this->isColumnModified(DescQuestionPeer::TYPE)) $criteria->add(DescQuestionPeer::TYPE, $this->type);
		if ($this->isColumnModified(DescQuestionPeer::IS_REQUIRED)) $criteria->add(DescQuestionPeer::IS_REQUIRED, $this->is_required);
		if ($this->isColumnModified(DescQuestionPeer::SELECT_GREATHER)) $criteria->add(DescQuestionPeer::SELECT_GREATHER, $this->select_greather);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DescQuestionPeer::DATABASE_NAME);

		$criteria->add(DescQuestionPeer::ID, $this->id);

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

		$copyObj->setSearchTitle($this->search_title);

		$copyObj->setDescTitle($this->desc_title);

		$copyObj->setFactorTitle($this->factor_title);

		$copyObj->setType($this->type);

		$copyObj->setIsRequired($this->is_required);

		$copyObj->setSelectGreather($this->select_greather);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getDescAnswers() as $relObj) {
				$copyObj->addDescAnswer($relObj->copy($deepCopy));
			}

			foreach($this->getMemberDescAnswers() as $relObj) {
				$copyObj->addMemberDescAnswer($relObj->copy($deepCopy));
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
			self::$peer = new DescQuestionPeer();
		}
		return self::$peer;
	}

	
	public function initDescAnswers()
	{
		if ($this->collDescAnswers === null) {
			$this->collDescAnswers = array();
		}
	}

	
	public function getDescAnswers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDescAnswers === null) {
			if ($this->isNew()) {
			   $this->collDescAnswers = array();
			} else {

				$criteria->add(DescAnswerPeer::DESC_QUESTION_ID, $this->getId());

				DescAnswerPeer::addSelectColumns($criteria);
				$this->collDescAnswers = DescAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DescAnswerPeer::DESC_QUESTION_ID, $this->getId());

				DescAnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastDescAnswerCriteria) || !$this->lastDescAnswerCriteria->equals($criteria)) {
					$this->collDescAnswers = DescAnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDescAnswerCriteria = $criteria;
		return $this->collDescAnswers;
	}

	
	public function countDescAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DescAnswerPeer::DESC_QUESTION_ID, $this->getId());

		return DescAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addDescAnswer(DescAnswer $l)
	{
		$this->collDescAnswers[] = $l;
		$l->setDescQuestion($this);
	}

	
	public function initMemberDescAnswers()
	{
		if ($this->collMemberDescAnswers === null) {
			$this->collMemberDescAnswers = array();
		}
	}

	
	public function getMemberDescAnswers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberDescAnswers === null) {
			if ($this->isNew()) {
			   $this->collMemberDescAnswers = array();
			} else {

				$criteria->add(MemberDescAnswerPeer::DESC_QUESTION_ID, $this->getId());

				MemberDescAnswerPeer::addSelectColumns($criteria);
				$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberDescAnswerPeer::DESC_QUESTION_ID, $this->getId());

				MemberDescAnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberDescAnswerCriteria) || !$this->lastMemberDescAnswerCriteria->equals($criteria)) {
					$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberDescAnswerCriteria = $criteria;
		return $this->collMemberDescAnswers;
	}

	
	public function countMemberDescAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberDescAnswerPeer::DESC_QUESTION_ID, $this->getId());

		return MemberDescAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberDescAnswer(MemberDescAnswer $l)
	{
		$this->collMemberDescAnswers[] = $l;
		$l->setDescQuestion($this);
	}


	
	public function getMemberDescAnswersJoinMember($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberDescAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberDescAnswers === null) {
			if ($this->isNew()) {
				$this->collMemberDescAnswers = array();
			} else {

				$criteria->add(MemberDescAnswerPeer::DESC_QUESTION_ID, $this->getId());

				$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelectJoinMember($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberDescAnswerPeer::DESC_QUESTION_ID, $this->getId());

			if (!isset($this->lastMemberDescAnswerCriteria) || !$this->lastMemberDescAnswerCriteria->equals($criteria)) {
				$this->collMemberDescAnswers = MemberDescAnswerPeer::doSelectJoinMember($criteria, $con);
			}
		}
		$this->lastMemberDescAnswerCriteria = $criteria;

		return $this->collMemberDescAnswers;
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

				$criteria->add(SearchCritDescPeer::DESC_QUESTION_ID, $this->getId());

				SearchCritDescPeer::addSelectColumns($criteria);
				$this->collSearchCritDescs = SearchCritDescPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SearchCritDescPeer::DESC_QUESTION_ID, $this->getId());

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

		$criteria->add(SearchCritDescPeer::DESC_QUESTION_ID, $this->getId());

		return SearchCritDescPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSearchCritDesc(SearchCritDesc $l)
	{
		$this->collSearchCritDescs[] = $l;
		$l->setDescQuestion($this);
	}


	
	public function getSearchCritDescsJoinMember($criteria = null, $con = null)
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

				$criteria->add(SearchCritDescPeer::DESC_QUESTION_ID, $this->getId());

				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinMember($criteria, $con);
			}
		} else {
									
			$criteria->add(SearchCritDescPeer::DESC_QUESTION_ID, $this->getId());

			if (!isset($this->lastSearchCritDescCriteria) || !$this->lastSearchCritDescCriteria->equals($criteria)) {
				$this->collSearchCritDescs = SearchCritDescPeer::doSelectJoinMember($criteria, $con);
			}
		}
		$this->lastSearchCritDescCriteria = $criteria;

		return $this->collSearchCritDescs;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseDescQuestion:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseDescQuestion::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 