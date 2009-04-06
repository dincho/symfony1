<?php


abstract class BaseStaticPage extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $slug;


	
	protected $has_mini_menu = false;

	
	protected $collStaticPageI18ns;

	
	protected $lastStaticPageI18nCriteria = null;

	
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

	
	public function getHasMiniMenu()
	{

		return $this->has_mini_menu;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = StaticPagePeer::ID;
		}

	} 
	
	public function setSlug($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->slug !== $v) {
			$this->slug = $v;
			$this->modifiedColumns[] = StaticPagePeer::SLUG;
		}

	} 
	
	public function setHasMiniMenu($v)
	{

		if ($this->has_mini_menu !== $v || $v === false) {
			$this->has_mini_menu = $v;
			$this->modifiedColumns[] = StaticPagePeer::HAS_MINI_MENU;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->slug = $rs->getString($startcol + 1);

			$this->has_mini_menu = $rs->getBoolean($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating StaticPage object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPage:delete:pre') as $callable)
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
			$con = Propel::getConnection(StaticPagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			StaticPagePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseStaticPage:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPage:save:pre') as $callable)
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
			$con = Propel::getConnection(StaticPagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseStaticPage:save:post') as $callable)
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
					$pk = StaticPagePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += StaticPagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collStaticPageI18ns !== null) {
				foreach($this->collStaticPageI18ns as $referrerFK) {
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


			if (($retval = StaticPagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collStaticPageI18ns !== null) {
					foreach($this->collStaticPageI18ns as $referrerFK) {
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
		$pos = StaticPagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getHasMiniMenu();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StaticPagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSlug(),
			$keys[2] => $this->getHasMiniMenu(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StaticPagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setHasMiniMenu($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StaticPagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSlug($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setHasMiniMenu($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(StaticPagePeer::DATABASE_NAME);

		if ($this->isColumnModified(StaticPagePeer::ID)) $criteria->add(StaticPagePeer::ID, $this->id);
		if ($this->isColumnModified(StaticPagePeer::SLUG)) $criteria->add(StaticPagePeer::SLUG, $this->slug);
		if ($this->isColumnModified(StaticPagePeer::HAS_MINI_MENU)) $criteria->add(StaticPagePeer::HAS_MINI_MENU, $this->has_mini_menu);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(StaticPagePeer::DATABASE_NAME);

		$criteria->add(StaticPagePeer::ID, $this->id);

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

		$copyObj->setHasMiniMenu($this->has_mini_menu);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getStaticPageI18ns() as $relObj) {
				$copyObj->addStaticPageI18n($relObj->copy($deepCopy));
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
			self::$peer = new StaticPagePeer();
		}
		return self::$peer;
	}

	
	public function initStaticPageI18ns()
	{
		if ($this->collStaticPageI18ns === null) {
			$this->collStaticPageI18ns = array();
		}
	}

	
	public function getStaticPageI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseStaticPageI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collStaticPageI18ns === null) {
			if ($this->isNew()) {
			   $this->collStaticPageI18ns = array();
			} else {

				$criteria->add(StaticPageI18nPeer::ID, $this->getId());

				StaticPageI18nPeer::addSelectColumns($criteria);
				$this->collStaticPageI18ns = StaticPageI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(StaticPageI18nPeer::ID, $this->getId());

				StaticPageI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastStaticPageI18nCriteria) || !$this->lastStaticPageI18nCriteria->equals($criteria)) {
					$this->collStaticPageI18ns = StaticPageI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastStaticPageI18nCriteria = $criteria;
		return $this->collStaticPageI18ns;
	}

	
	public function countStaticPageI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseStaticPageI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(StaticPageI18nPeer::ID, $this->getId());

		return StaticPageI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addStaticPageI18n(StaticPageI18n $l)
	{
		$this->collStaticPageI18ns[] = $l;
		$l->setStaticPage($this);
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
    $obj = $this->getCurrentStaticPageI18n();

    return ($obj ? $obj->getLinkName() : null);
  }

  public function setLinkName($value)
  {
    $this->getCurrentStaticPageI18n()->setLinkName($value);
  }

  public function getTitle()
  {
    $obj = $this->getCurrentStaticPageI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentStaticPageI18n()->setTitle($value);
  }

  public function getKeywords()
  {
    $obj = $this->getCurrentStaticPageI18n();

    return ($obj ? $obj->getKeywords() : null);
  }

  public function setKeywords($value)
  {
    $this->getCurrentStaticPageI18n()->setKeywords($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentStaticPageI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentStaticPageI18n()->setDescription($value);
  }

  public function getContent()
  {
    $obj = $this->getCurrentStaticPageI18n();

    return ($obj ? $obj->getContent() : null);
  }

  public function setContent($value)
  {
    $this->getCurrentStaticPageI18n()->setContent($value);
  }

  protected $current_i18n = array();

  public function getCurrentStaticPageI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = StaticPageI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setStaticPageI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setStaticPageI18nForCulture(new StaticPageI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setStaticPageI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addStaticPageI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseStaticPage:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseStaticPage::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 