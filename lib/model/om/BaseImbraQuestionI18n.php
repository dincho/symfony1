<?php


abstract class BaseImbraQuestionI18n extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $title;


	
	protected $explain_title;


	
	protected $positive_answer;


	
	protected $negative_answer;


	
	protected $id;


	
	protected $culture;

	
	protected $aImbraQuestion;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
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

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCulture()
	{

		return $this->culture;
	}

	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = ImbraQuestionI18nPeer::TITLE;
		}

	} 
	
	public function setExplainTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->explain_title !== $v) {
			$this->explain_title = $v;
			$this->modifiedColumns[] = ImbraQuestionI18nPeer::EXPLAIN_TITLE;
		}

	} 
	
	public function setPositiveAnswer($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->positive_answer !== $v) {
			$this->positive_answer = $v;
			$this->modifiedColumns[] = ImbraQuestionI18nPeer::POSITIVE_ANSWER;
		}

	} 
	
	public function setNegativeAnswer($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->negative_answer !== $v) {
			$this->negative_answer = $v;
			$this->modifiedColumns[] = ImbraQuestionI18nPeer::NEGATIVE_ANSWER;
		}

	} 
	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ImbraQuestionI18nPeer::ID;
		}

		if ($this->aImbraQuestion !== null && $this->aImbraQuestion->getId() !== $v) {
			$this->aImbraQuestion = null;
		}

	} 
	
	public function setCulture($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->culture !== $v) {
			$this->culture = $v;
			$this->modifiedColumns[] = ImbraQuestionI18nPeer::CULTURE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->title = $rs->getString($startcol + 0);

			$this->explain_title = $rs->getString($startcol + 1);

			$this->positive_answer = $rs->getString($startcol + 2);

			$this->negative_answer = $rs->getString($startcol + 3);

			$this->id = $rs->getInt($startcol + 4);

			$this->culture = $rs->getString($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ImbraQuestionI18n object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionI18n:delete:pre') as $callable)
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
			$con = Propel::getConnection(ImbraQuestionI18nPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ImbraQuestionI18nPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseImbraQuestionI18n:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionI18n:save:pre') as $callable)
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
			$con = Propel::getConnection(ImbraQuestionI18nPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseImbraQuestionI18n:save:post') as $callable)
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


												
			if ($this->aImbraQuestion !== null) {
				if ($this->aImbraQuestion->isModified() || $this->aImbraQuestion->getCurrentImbraQuestionI18n()->isModified()) {
					$affectedRows += $this->aImbraQuestion->save($con);
				}
				$this->setImbraQuestion($this->aImbraQuestion);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ImbraQuestionI18nPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += ImbraQuestionI18nPeer::doUpdate($this, $con);
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


												
			if ($this->aImbraQuestion !== null) {
				if (!$this->aImbraQuestion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aImbraQuestion->getValidationFailures());
				}
			}


			if (($retval = ImbraQuestionI18nPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ImbraQuestionI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getTitle();
				break;
			case 1:
				return $this->getExplainTitle();
				break;
			case 2:
				return $this->getPositiveAnswer();
				break;
			case 3:
				return $this->getNegativeAnswer();
				break;
			case 4:
				return $this->getId();
				break;
			case 5:
				return $this->getCulture();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraQuestionI18nPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getTitle(),
			$keys[1] => $this->getExplainTitle(),
			$keys[2] => $this->getPositiveAnswer(),
			$keys[3] => $this->getNegativeAnswer(),
			$keys[4] => $this->getId(),
			$keys[5] => $this->getCulture(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ImbraQuestionI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setTitle($value);
				break;
			case 1:
				$this->setExplainTitle($value);
				break;
			case 2:
				$this->setPositiveAnswer($value);
				break;
			case 3:
				$this->setNegativeAnswer($value);
				break;
			case 4:
				$this->setId($value);
				break;
			case 5:
				$this->setCulture($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraQuestionI18nPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setTitle($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setExplainTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPositiveAnswer($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNegativeAnswer($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCulture($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ImbraQuestionI18nPeer::DATABASE_NAME);

		if ($this->isColumnModified(ImbraQuestionI18nPeer::TITLE)) $criteria->add(ImbraQuestionI18nPeer::TITLE, $this->title);
		if ($this->isColumnModified(ImbraQuestionI18nPeer::EXPLAIN_TITLE)) $criteria->add(ImbraQuestionI18nPeer::EXPLAIN_TITLE, $this->explain_title);
		if ($this->isColumnModified(ImbraQuestionI18nPeer::POSITIVE_ANSWER)) $criteria->add(ImbraQuestionI18nPeer::POSITIVE_ANSWER, $this->positive_answer);
		if ($this->isColumnModified(ImbraQuestionI18nPeer::NEGATIVE_ANSWER)) $criteria->add(ImbraQuestionI18nPeer::NEGATIVE_ANSWER, $this->negative_answer);
		if ($this->isColumnModified(ImbraQuestionI18nPeer::ID)) $criteria->add(ImbraQuestionI18nPeer::ID, $this->id);
		if ($this->isColumnModified(ImbraQuestionI18nPeer::CULTURE)) $criteria->add(ImbraQuestionI18nPeer::CULTURE, $this->culture);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ImbraQuestionI18nPeer::DATABASE_NAME);

		$criteria->add(ImbraQuestionI18nPeer::ID, $this->id);
		$criteria->add(ImbraQuestionI18nPeer::CULTURE, $this->culture);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getCulture();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setCulture($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitle($this->title);

		$copyObj->setExplainTitle($this->explain_title);

		$copyObj->setPositiveAnswer($this->positive_answer);

		$copyObj->setNegativeAnswer($this->negative_answer);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setCulture(NULL); 
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
			self::$peer = new ImbraQuestionI18nPeer();
		}
		return self::$peer;
	}

	
	public function setImbraQuestion($v)
	{


		if ($v === null) {
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
		}


		$this->aImbraQuestion = $v;
	}


	
	public function getImbraQuestion($con = null)
	{
		if ($this->aImbraQuestion === null && ($this->id !== null)) {
						include_once 'lib/model/om/BaseImbraQuestionPeer.php';

			$this->aImbraQuestion = ImbraQuestionPeer::retrieveByPK($this->id, $con);

			
		}
		return $this->aImbraQuestion;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseImbraQuestionI18n:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseImbraQuestionI18n::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 