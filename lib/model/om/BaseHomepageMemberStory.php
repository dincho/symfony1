<?php


abstract class BaseHomepageMemberStory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $member_stories;


	
	protected $homepage_culture;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMemberStories()
	{

		return $this->member_stories;
	}

	
	public function getHomepageCulture()
	{

		return $this->homepage_culture;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = HomepageMemberStoryPeer::ID;
		}

	} 
	
	public function setMemberStories($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->member_stories !== $v) {
			$this->member_stories = $v;
			$this->modifiedColumns[] = HomepageMemberStoryPeer::MEMBER_STORIES;
		}

	} 
	
	public function setHomepageCulture($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->homepage_culture !== $v) {
			$this->homepage_culture = $v;
			$this->modifiedColumns[] = HomepageMemberStoryPeer::HOMEPAGE_CULTURE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->member_stories = $rs->getString($startcol + 1);

			$this->homepage_culture = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating HomepageMemberStory object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseHomepageMemberStory:delete:pre') as $callable)
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
			$con = Propel::getConnection(HomepageMemberStoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			HomepageMemberStoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseHomepageMemberStory:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseHomepageMemberStory:save:pre') as $callable)
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
			$con = Propel::getConnection(HomepageMemberStoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseHomepageMemberStory:save:post') as $callable)
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
					$pk = HomepageMemberStoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += HomepageMemberStoryPeer::doUpdate($this, $con);
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


			if (($retval = HomepageMemberStoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HomepageMemberStoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMemberStories();
				break;
			case 2:
				return $this->getHomepageCulture();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HomepageMemberStoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMemberStories(),
			$keys[2] => $this->getHomepageCulture(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HomepageMemberStoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMemberStories($value);
				break;
			case 2:
				$this->setHomepageCulture($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HomepageMemberStoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMemberStories($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setHomepageCulture($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(HomepageMemberStoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(HomepageMemberStoryPeer::ID)) $criteria->add(HomepageMemberStoryPeer::ID, $this->id);
		if ($this->isColumnModified(HomepageMemberStoryPeer::MEMBER_STORIES)) $criteria->add(HomepageMemberStoryPeer::MEMBER_STORIES, $this->member_stories);
		if ($this->isColumnModified(HomepageMemberStoryPeer::HOMEPAGE_CULTURE)) $criteria->add(HomepageMemberStoryPeer::HOMEPAGE_CULTURE, $this->homepage_culture);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(HomepageMemberStoryPeer::DATABASE_NAME);

		$criteria->add(HomepageMemberStoryPeer::ID, $this->id);

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

		$copyObj->setMemberStories($this->member_stories);

		$copyObj->setHomepageCulture($this->homepage_culture);


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
			self::$peer = new HomepageMemberStoryPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseHomepageMemberStory:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseHomepageMemberStory::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 