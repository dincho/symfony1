<?php


abstract class BaseStockPhoto extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $file;


	
	protected $cropped;


	
	protected $gender = 'M';


	
	protected $homepages;


	
	protected $homepages_set;


	
	protected $homepages_pos;


	
	protected $updated_at;

	
	protected $collMemberStorys;

	
	protected $lastMemberStoryCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFile()
	{

		return $this->file;
	}

	
	public function getCropped()
	{

		return $this->cropped;
	}

	
	public function getGender()
	{

		return $this->gender;
	}

	
	public function getHomepages()
	{

		return $this->homepages;
	}

	
	public function getHomepagesSet()
	{

		return $this->homepages_set;
	}

	
	public function getHomepagesPos()
	{

		return $this->homepages_pos;
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
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
			$this->modifiedColumns[] = StockPhotoPeer::ID;
		}

	} 
	
	public function setFile($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->file !== $v) {
			$this->file = $v;
			$this->modifiedColumns[] = StockPhotoPeer::FILE;
		}

	} 
	
	public function setCropped($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->cropped !== $v) {
			$this->cropped = $v;
			$this->modifiedColumns[] = StockPhotoPeer::CROPPED;
		}

	} 
	
	public function setGender($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->gender !== $v || $v === 'M') {
			$this->gender = $v;
			$this->modifiedColumns[] = StockPhotoPeer::GENDER;
		}

	} 
	
	public function setHomepages($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->homepages !== $v) {
			$this->homepages = $v;
			$this->modifiedColumns[] = StockPhotoPeer::HOMEPAGES;
		}

	} 
	
	public function setHomepagesSet($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->homepages_set !== $v) {
			$this->homepages_set = $v;
			$this->modifiedColumns[] = StockPhotoPeer::HOMEPAGES_SET;
		}

	} 
	
	public function setHomepagesPos($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->homepages_pos !== $v) {
			$this->homepages_pos = $v;
			$this->modifiedColumns[] = StockPhotoPeer::HOMEPAGES_POS;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = StockPhotoPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->file = $rs->getString($startcol + 1);

			$this->cropped = $rs->getString($startcol + 2);

			$this->gender = $rs->getString($startcol + 3);

			$this->homepages = $rs->getString($startcol + 4);

			$this->homepages_set = $rs->getInt($startcol + 5);

			$this->homepages_pos = $rs->getInt($startcol + 6);

			$this->updated_at = $rs->getTimestamp($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating StockPhoto object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseStockPhoto:delete:pre') as $callable)
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
			$con = Propel::getConnection(StockPhotoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			StockPhotoPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseStockPhoto:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseStockPhoto:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isModified() && !$this->isColumnModified(StockPhotoPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(StockPhotoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseStockPhoto:save:post') as $callable)
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
					$pk = StockPhotoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += StockPhotoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMemberStorys !== null) {
				foreach($this->collMemberStorys as $referrerFK) {
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


			if (($retval = StockPhotoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMemberStorys !== null) {
					foreach($this->collMemberStorys as $referrerFK) {
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
		$pos = StockPhotoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFile();
				break;
			case 2:
				return $this->getCropped();
				break;
			case 3:
				return $this->getGender();
				break;
			case 4:
				return $this->getHomepages();
				break;
			case 5:
				return $this->getHomepagesSet();
				break;
			case 6:
				return $this->getHomepagesPos();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StockPhotoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFile(),
			$keys[2] => $this->getCropped(),
			$keys[3] => $this->getGender(),
			$keys[4] => $this->getHomepages(),
			$keys[5] => $this->getHomepagesSet(),
			$keys[6] => $this->getHomepagesPos(),
			$keys[7] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StockPhotoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFile($value);
				break;
			case 2:
				$this->setCropped($value);
				break;
			case 3:
				$this->setGender($value);
				break;
			case 4:
				$this->setHomepages($value);
				break;
			case 5:
				$this->setHomepagesSet($value);
				break;
			case 6:
				$this->setHomepagesPos($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StockPhotoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFile($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCropped($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setGender($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setHomepages($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setHomepagesSet($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setHomepagesPos($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(StockPhotoPeer::DATABASE_NAME);

		if ($this->isColumnModified(StockPhotoPeer::ID)) $criteria->add(StockPhotoPeer::ID, $this->id);
		if ($this->isColumnModified(StockPhotoPeer::FILE)) $criteria->add(StockPhotoPeer::FILE, $this->file);
		if ($this->isColumnModified(StockPhotoPeer::CROPPED)) $criteria->add(StockPhotoPeer::CROPPED, $this->cropped);
		if ($this->isColumnModified(StockPhotoPeer::GENDER)) $criteria->add(StockPhotoPeer::GENDER, $this->gender);
		if ($this->isColumnModified(StockPhotoPeer::HOMEPAGES)) $criteria->add(StockPhotoPeer::HOMEPAGES, $this->homepages);
		if ($this->isColumnModified(StockPhotoPeer::HOMEPAGES_SET)) $criteria->add(StockPhotoPeer::HOMEPAGES_SET, $this->homepages_set);
		if ($this->isColumnModified(StockPhotoPeer::HOMEPAGES_POS)) $criteria->add(StockPhotoPeer::HOMEPAGES_POS, $this->homepages_pos);
		if ($this->isColumnModified(StockPhotoPeer::UPDATED_AT)) $criteria->add(StockPhotoPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(StockPhotoPeer::DATABASE_NAME);

		$criteria->add(StockPhotoPeer::ID, $this->id);

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

		$copyObj->setFile($this->file);

		$copyObj->setCropped($this->cropped);

		$copyObj->setGender($this->gender);

		$copyObj->setHomepages($this->homepages);

		$copyObj->setHomepagesSet($this->homepages_set);

		$copyObj->setHomepagesPos($this->homepages_pos);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMemberStorys() as $relObj) {
				$copyObj->addMemberStory($relObj->copy($deepCopy));
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
			self::$peer = new StockPhotoPeer();
		}
		return self::$peer;
	}

	
	public function initMemberStorys()
	{
		if ($this->collMemberStorys === null) {
			$this->collMemberStorys = array();
		}
	}

	
	public function getMemberStorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberStorys === null) {
			if ($this->isNew()) {
			   $this->collMemberStorys = array();
			} else {

				$criteria->add(MemberStoryPeer::STOCK_PHOTO_ID, $this->getId());

				MemberStoryPeer::addSelectColumns($criteria);
				$this->collMemberStorys = MemberStoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberStoryPeer::STOCK_PHOTO_ID, $this->getId());

				MemberStoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberStoryCriteria) || !$this->lastMemberStoryCriteria->equals($criteria)) {
					$this->collMemberStorys = MemberStoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberStoryCriteria = $criteria;
		return $this->collMemberStorys;
	}

	
	public function countMemberStorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberStoryPeer::STOCK_PHOTO_ID, $this->getId());

		return MemberStoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberStory(MemberStory $l)
	{
		$this->collMemberStorys[] = $l;
		$l->setStockPhoto($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseStockPhoto:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseStockPhoto::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 