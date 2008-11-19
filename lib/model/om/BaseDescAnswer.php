<?php


abstract class BaseDescAnswer extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $desc_question_id;


	
	protected $title;


	
	protected $search_title;


	
	protected $desc_title;

	
	protected $aDescQuestion;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getDescQuestionId()
	{

		return $this->desc_question_id;
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = DescAnswerPeer::ID;
		}

	} 
	
	public function setDescQuestionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->desc_question_id !== $v) {
			$this->desc_question_id = $v;
			$this->modifiedColumns[] = DescAnswerPeer::DESC_QUESTION_ID;
		}

		if ($this->aDescQuestion !== null && $this->aDescQuestion->getId() !== $v) {
			$this->aDescQuestion = null;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = DescAnswerPeer::TITLE;
		}

	} 
	
	public function setSearchTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->search_title !== $v) {
			$this->search_title = $v;
			$this->modifiedColumns[] = DescAnswerPeer::SEARCH_TITLE;
		}

	} 
	
	public function setDescTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->desc_title !== $v) {
			$this->desc_title = $v;
			$this->modifiedColumns[] = DescAnswerPeer::DESC_TITLE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->desc_question_id = $rs->getInt($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->search_title = $rs->getString($startcol + 3);

			$this->desc_title = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating DescAnswer object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseDescAnswer:delete:pre') as $callable)
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
			$con = Propel::getConnection(DescAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DescAnswerPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseDescAnswer:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseDescAnswer:save:pre') as $callable)
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
			$con = Propel::getConnection(DescAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseDescAnswer:save:post') as $callable)
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


												
			if ($this->aDescQuestion !== null) {
				if ($this->aDescQuestion->isModified()) {
					$affectedRows += $this->aDescQuestion->save($con);
				}
				$this->setDescQuestion($this->aDescQuestion);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DescAnswerPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DescAnswerPeer::doUpdate($this, $con);
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


												
			if ($this->aDescQuestion !== null) {
				if (!$this->aDescQuestion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDescQuestion->getValidationFailures());
				}
			}


			if (($retval = DescAnswerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DescAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getDescQuestionId();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getSearchTitle();
				break;
			case 4:
				return $this->getDescTitle();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DescAnswerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDescQuestionId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getSearchTitle(),
			$keys[4] => $this->getDescTitle(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DescAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDescQuestionId($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setSearchTitle($value);
				break;
			case 4:
				$this->setDescTitle($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DescAnswerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDescQuestionId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSearchTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescTitle($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DescAnswerPeer::DATABASE_NAME);

		if ($this->isColumnModified(DescAnswerPeer::ID)) $criteria->add(DescAnswerPeer::ID, $this->id);
		if ($this->isColumnModified(DescAnswerPeer::DESC_QUESTION_ID)) $criteria->add(DescAnswerPeer::DESC_QUESTION_ID, $this->desc_question_id);
		if ($this->isColumnModified(DescAnswerPeer::TITLE)) $criteria->add(DescAnswerPeer::TITLE, $this->title);
		if ($this->isColumnModified(DescAnswerPeer::SEARCH_TITLE)) $criteria->add(DescAnswerPeer::SEARCH_TITLE, $this->search_title);
		if ($this->isColumnModified(DescAnswerPeer::DESC_TITLE)) $criteria->add(DescAnswerPeer::DESC_TITLE, $this->desc_title);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DescAnswerPeer::DATABASE_NAME);

		$criteria->add(DescAnswerPeer::ID, $this->id);

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

		$copyObj->setDescQuestionId($this->desc_question_id);

		$copyObj->setTitle($this->title);

		$copyObj->setSearchTitle($this->search_title);

		$copyObj->setDescTitle($this->desc_title);


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
			self::$peer = new DescAnswerPeer();
		}
		return self::$peer;
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
    if (!$callable = sfMixer::getCallable('BaseDescAnswer:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseDescAnswer::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 