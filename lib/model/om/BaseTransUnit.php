<?php


abstract class BaseTransUnit extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $cat_id = 1;


	
	protected $msg_collection_id;


	
	protected $source;


	
	protected $target;


	
	protected $comments;


	
	protected $author = '';


	
	protected $translated = false;


	
	protected $date_created = 0;


	
	protected $date_modified = 0;

	
	protected $aCatalogue;

	
	protected $aMsgCollection;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCatId()
	{

		return $this->cat_id;
	}

	
	public function getMsgCollectionId()
	{

		return $this->msg_collection_id;
	}

	
	public function getSource()
	{

		return $this->source;
	}

	
	public function getTarget()
	{

		return $this->target;
	}

	
	public function getComments()
	{

		return $this->comments;
	}

	
	public function getAuthor()
	{

		return $this->author;
	}

	
	public function getTranslated()
	{

		return $this->translated;
	}

	
	public function getDateCreated()
	{

		return $this->date_created;
	}

	
	public function getDateModified()
	{

		return $this->date_modified;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TransUnitPeer::ID;
		}

	} 
	
	public function setCatId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cat_id !== $v || $v === 1) {
			$this->cat_id = $v;
			$this->modifiedColumns[] = TransUnitPeer::CAT_ID;
		}

		if ($this->aCatalogue !== null && $this->aCatalogue->getCatId() !== $v) {
			$this->aCatalogue = null;
		}

	} 
	
	public function setMsgCollectionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->msg_collection_id !== $v) {
			$this->msg_collection_id = $v;
			$this->modifiedColumns[] = TransUnitPeer::MSG_COLLECTION_ID;
		}

		if ($this->aMsgCollection !== null && $this->aMsgCollection->getId() !== $v) {
			$this->aMsgCollection = null;
		}

	} 
	
	public function setSource($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->source !== $v) {
			$this->source = $v;
			$this->modifiedColumns[] = TransUnitPeer::SOURCE;
		}

	} 
	
	public function setTarget($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->target !== $v) {
			$this->target = $v;
			$this->modifiedColumns[] = TransUnitPeer::TARGET;
		}

	} 
	
	public function setComments($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->comments !== $v) {
			$this->comments = $v;
			$this->modifiedColumns[] = TransUnitPeer::COMMENTS;
		}

	} 
	
	public function setAuthor($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author !== $v || $v === '') {
			$this->author = $v;
			$this->modifiedColumns[] = TransUnitPeer::AUTHOR;
		}

	} 
	
	public function setTranslated($v)
	{

		if ($this->translated !== $v || $v === false) {
			$this->translated = $v;
			$this->modifiedColumns[] = TransUnitPeer::TRANSLATED;
		}

	} 
	
	public function setDateCreated($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->date_created !== $v || $v === 0) {
			$this->date_created = $v;
			$this->modifiedColumns[] = TransUnitPeer::DATE_CREATED;
		}

	} 
	
	public function setDateModified($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->date_modified !== $v || $v === 0) {
			$this->date_modified = $v;
			$this->modifiedColumns[] = TransUnitPeer::DATE_MODIFIED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->cat_id = $rs->getInt($startcol + 1);

			$this->msg_collection_id = $rs->getInt($startcol + 2);

			$this->source = $rs->getString($startcol + 3);

			$this->target = $rs->getString($startcol + 4);

			$this->comments = $rs->getString($startcol + 5);

			$this->author = $rs->getString($startcol + 6);

			$this->translated = $rs->getBoolean($startcol + 7);

			$this->date_created = $rs->getInt($startcol + 8);

			$this->date_modified = $rs->getInt($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TransUnit object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTransUnit:delete:pre') as $callable)
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
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TransUnitPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTransUnit:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTransUnit:save:pre') as $callable)
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
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTransUnit:save:post') as $callable)
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


												
			if ($this->aCatalogue !== null) {
				if ($this->aCatalogue->isModified()) {
					$affectedRows += $this->aCatalogue->save($con);
				}
				$this->setCatalogue($this->aCatalogue);
			}

			if ($this->aMsgCollection !== null) {
				if ($this->aMsgCollection->isModified()) {
					$affectedRows += $this->aMsgCollection->save($con);
				}
				$this->setMsgCollection($this->aMsgCollection);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TransUnitPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TransUnitPeer::doUpdate($this, $con);
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


												
			if ($this->aCatalogue !== null) {
				if (!$this->aCatalogue->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCatalogue->getValidationFailures());
				}
			}

			if ($this->aMsgCollection !== null) {
				if (!$this->aMsgCollection->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMsgCollection->getValidationFailures());
				}
			}


			if (($retval = TransUnitPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCatId();
				break;
			case 2:
				return $this->getMsgCollectionId();
				break;
			case 3:
				return $this->getSource();
				break;
			case 4:
				return $this->getTarget();
				break;
			case 5:
				return $this->getComments();
				break;
			case 6:
				return $this->getAuthor();
				break;
			case 7:
				return $this->getTranslated();
				break;
			case 8:
				return $this->getDateCreated();
				break;
			case 9:
				return $this->getDateModified();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransUnitPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCatId(),
			$keys[2] => $this->getMsgCollectionId(),
			$keys[3] => $this->getSource(),
			$keys[4] => $this->getTarget(),
			$keys[5] => $this->getComments(),
			$keys[6] => $this->getAuthor(),
			$keys[7] => $this->getTranslated(),
			$keys[8] => $this->getDateCreated(),
			$keys[9] => $this->getDateModified(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCatId($value);
				break;
			case 2:
				$this->setMsgCollectionId($value);
				break;
			case 3:
				$this->setSource($value);
				break;
			case 4:
				$this->setTarget($value);
				break;
			case 5:
				$this->setComments($value);
				break;
			case 6:
				$this->setAuthor($value);
				break;
			case 7:
				$this->setTranslated($value);
				break;
			case 8:
				$this->setDateCreated($value);
				break;
			case 9:
				$this->setDateModified($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransUnitPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCatId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMsgCollectionId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSource($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTarget($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setComments($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAuthor($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setTranslated($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setDateCreated($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDateModified($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TransUnitPeer::DATABASE_NAME);

		if ($this->isColumnModified(TransUnitPeer::ID)) $criteria->add(TransUnitPeer::ID, $this->id);
		if ($this->isColumnModified(TransUnitPeer::CAT_ID)) $criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);
		if ($this->isColumnModified(TransUnitPeer::MSG_COLLECTION_ID)) $criteria->add(TransUnitPeer::MSG_COLLECTION_ID, $this->msg_collection_id);
		if ($this->isColumnModified(TransUnitPeer::SOURCE)) $criteria->add(TransUnitPeer::SOURCE, $this->source);
		if ($this->isColumnModified(TransUnitPeer::TARGET)) $criteria->add(TransUnitPeer::TARGET, $this->target);
		if ($this->isColumnModified(TransUnitPeer::COMMENTS)) $criteria->add(TransUnitPeer::COMMENTS, $this->comments);
		if ($this->isColumnModified(TransUnitPeer::AUTHOR)) $criteria->add(TransUnitPeer::AUTHOR, $this->author);
		if ($this->isColumnModified(TransUnitPeer::TRANSLATED)) $criteria->add(TransUnitPeer::TRANSLATED, $this->translated);
		if ($this->isColumnModified(TransUnitPeer::DATE_CREATED)) $criteria->add(TransUnitPeer::DATE_CREATED, $this->date_created);
		if ($this->isColumnModified(TransUnitPeer::DATE_MODIFIED)) $criteria->add(TransUnitPeer::DATE_MODIFIED, $this->date_modified);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TransUnitPeer::DATABASE_NAME);

		$criteria->add(TransUnitPeer::ID, $this->id);

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

		$copyObj->setCatId($this->cat_id);

		$copyObj->setMsgCollectionId($this->msg_collection_id);

		$copyObj->setSource($this->source);

		$copyObj->setTarget($this->target);

		$copyObj->setComments($this->comments);

		$copyObj->setAuthor($this->author);

		$copyObj->setTranslated($this->translated);

		$copyObj->setDateCreated($this->date_created);

		$copyObj->setDateModified($this->date_modified);


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
			self::$peer = new TransUnitPeer();
		}
		return self::$peer;
	}

	
	public function setCatalogue($v)
	{


		if ($v === null) {
			$this->setCatId('1');
		} else {
			$this->setCatId($v->getCatId());
		}


		$this->aCatalogue = $v;
	}


	
	public function getCatalogue($con = null)
	{
		if ($this->aCatalogue === null && ($this->cat_id !== null)) {
						include_once 'lib/model/om/BaseCataloguePeer.php';

			$this->aCatalogue = CataloguePeer::retrieveByPK($this->cat_id, $con);

			
		}
		return $this->aCatalogue;
	}

	
	public function setMsgCollection($v)
	{


		if ($v === null) {
			$this->setMsgCollectionId(NULL);
		} else {
			$this->setMsgCollectionId($v->getId());
		}


		$this->aMsgCollection = $v;
	}


	
	public function getMsgCollection($con = null)
	{
		if ($this->aMsgCollection === null && ($this->msg_collection_id !== null)) {
						include_once 'lib/model/om/BaseMsgCollectionPeer.php';

			$this->aMsgCollection = MsgCollectionPeer::retrieveByPK($this->msg_collection_id, $con);

			
		}
		return $this->aMsgCollection;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTransUnit:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTransUnit::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 