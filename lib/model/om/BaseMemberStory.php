<?php


abstract class BaseMemberStory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $slug;


	
	protected $sort_order = 0;

	
	protected $collMemberStoryI18ns;

	
	protected $lastMemberStoryI18nCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSlug()
	{

		return $this->slug;
	}

	
	public function getSortOrder()
	{

		return $this->sort_order;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MemberStoryPeer::ID;
		}

	} 
	
	public function setSlug($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->slug !== $v) {
			$this->slug = $v;
			$this->modifiedColumns[] = MemberStoryPeer::SLUG;
		}

	} 
	
	public function setSortOrder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sort_order !== $v || $v === 0) {
			$this->sort_order = $v;
			$this->modifiedColumns[] = MemberStoryPeer::SORT_ORDER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->slug = $rs->getString($startcol + 1);

			$this->sort_order = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MemberStory object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStory:delete:pre') as $callable)
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
			$con = Propel::getConnection(MemberStoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MemberStoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMemberStory:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStory:save:pre') as $callable)
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
			$con = Propel::getConnection(MemberStoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMemberStory:save:post') as $callable)
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
					$pk = MemberStoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MemberStoryPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMemberStoryI18ns !== null) {
				foreach($this->collMemberStoryI18ns as $referrerFK) {
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


			if (($retval = MemberStoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMemberStoryI18ns !== null) {
					foreach($this->collMemberStoryI18ns as $referrerFK) {
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
		$pos = MemberStoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSlug();
				break;
			case 2:
				return $this->getSortOrder();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberStoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSlug(),
			$keys[2] => $this->getSortOrder(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MemberStoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSlug($value);
				break;
			case 2:
				$this->setSortOrder($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberStoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSlug($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSortOrder($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberStoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberStoryPeer::ID)) $criteria->add(MemberStoryPeer::ID, $this->id);
		if ($this->isColumnModified(MemberStoryPeer::SLUG)) $criteria->add(MemberStoryPeer::SLUG, $this->slug);
		if ($this->isColumnModified(MemberStoryPeer::SORT_ORDER)) $criteria->add(MemberStoryPeer::SORT_ORDER, $this->sort_order);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MemberStoryPeer::DATABASE_NAME);

		$criteria->add(MemberStoryPeer::ID, $this->id);

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

		$copyObj->setSlug($this->slug);

		$copyObj->setSortOrder($this->sort_order);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMemberStoryI18ns() as $relObj) {
				$copyObj->addMemberStoryI18n($relObj->copy($deepCopy));
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
			self::$peer = new MemberStoryPeer();
		}
		return self::$peer;
	}

	
	public function initMemberStoryI18ns()
	{
		if ($this->collMemberStoryI18ns === null) {
			$this->collMemberStoryI18ns = array();
		}
	}

	
	public function getMemberStoryI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStoryI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberStoryI18ns === null) {
			if ($this->isNew()) {
			   $this->collMemberStoryI18ns = array();
			} else {

				$criteria->add(MemberStoryI18nPeer::ID, $this->getId());

				MemberStoryI18nPeer::addSelectColumns($criteria);
				$this->collMemberStoryI18ns = MemberStoryI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberStoryI18nPeer::ID, $this->getId());

				MemberStoryI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberStoryI18nCriteria) || !$this->lastMemberStoryI18nCriteria->equals($criteria)) {
					$this->collMemberStoryI18ns = MemberStoryI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberStoryI18nCriteria = $criteria;
		return $this->collMemberStoryI18ns;
	}

	
	public function countMemberStoryI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberStoryI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberStoryI18nPeer::ID, $this->getId());

		return MemberStoryI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberStoryI18n(MemberStoryI18n $l)
	{
		$this->collMemberStoryI18ns[] = $l;
		$l->setMemberStory($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getLinkName()
  {
    $obj = $this->getCurrentMemberStoryI18n();

    return ($obj ? $obj->getLinkName() : null);
  }

  public function setLinkName($value)
  {
    $this->getCurrentMemberStoryI18n()->setLinkName($value);
  }

  public function getTitle()
  {
    $obj = $this->getCurrentMemberStoryI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentMemberStoryI18n()->setTitle($value);
  }

  public function getKeywords()
  {
    $obj = $this->getCurrentMemberStoryI18n();

    return ($obj ? $obj->getKeywords() : null);
  }

  public function setKeywords($value)
  {
    $this->getCurrentMemberStoryI18n()->setKeywords($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentMemberStoryI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentMemberStoryI18n()->setDescription($value);
  }

  public function getContent()
  {
    $obj = $this->getCurrentMemberStoryI18n();

    return ($obj ? $obj->getContent() : null);
  }

  public function setContent($value)
  {
    $this->getCurrentMemberStoryI18n()->setContent($value);
  }

  protected $current_i18n = array();

  public function getCurrentMemberStoryI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = MemberStoryI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setMemberStoryI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setMemberStoryI18nForCulture(new MemberStoryI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setMemberStoryI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addMemberStoryI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMemberStory:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMemberStory::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 