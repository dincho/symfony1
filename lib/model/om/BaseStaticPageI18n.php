<?php


abstract class BaseStaticPageI18n extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $link_name;


	
	protected $title;


	
	protected $keywords;


	
	protected $description;


	
	protected $content;


	
	protected $id;


	
	protected $culture;

	
	protected $aStaticPage;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getLinkName()
	{

		return $this->link_name;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getKeywords()
	{

		return $this->keywords;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCulture()
	{

		return $this->culture;
	}

	
	public function setLinkName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->link_name !== $v) {
			$this->link_name = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::LINK_NAME;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::TITLE;
		}

	} 
	
	public function setKeywords($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->keywords !== $v) {
			$this->keywords = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::KEYWORDS;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::DESCRIPTION;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::CONTENT;
		}

	} 
	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::ID;
		}

		if ($this->aStaticPage !== null && $this->aStaticPage->getId() !== $v) {
			$this->aStaticPage = null;
		}

	} 
	
	public function setCulture($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->culture !== $v) {
			$this->culture = $v;
			$this->modifiedColumns[] = StaticPageI18nPeer::CULTURE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->link_name = $rs->getString($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->keywords = $rs->getString($startcol + 2);

			$this->description = $rs->getString($startcol + 3);

			$this->content = $rs->getString($startcol + 4);

			$this->id = $rs->getInt($startcol + 5);

			$this->culture = $rs->getString($startcol + 6);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating StaticPageI18n object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPageI18n:delete:pre') as $callable)
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
			$con = Propel::getConnection(StaticPageI18nPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			StaticPageI18nPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseStaticPageI18n:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPageI18n:save:pre') as $callable)
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
			$con = Propel::getConnection(StaticPageI18nPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseStaticPageI18n:save:post') as $callable)
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


												
			if ($this->aStaticPage !== null) {
				if ($this->aStaticPage->isModified() || $this->aStaticPage->getCurrentStaticPageI18n()->isModified()) {
					$affectedRows += $this->aStaticPage->save($con);
				}
				$this->setStaticPage($this->aStaticPage);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = StaticPageI18nPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += StaticPageI18nPeer::doUpdate($this, $con);
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


												
			if ($this->aStaticPage !== null) {
				if (!$this->aStaticPage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aStaticPage->getValidationFailures());
				}
			}


			if (($retval = StaticPageI18nPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StaticPageI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getLinkName();
				break;
			case 1:
				return $this->getTitle();
				break;
			case 2:
				return $this->getKeywords();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getContent();
				break;
			case 5:
				return $this->getId();
				break;
			case 6:
				return $this->getCulture();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StaticPageI18nPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getLinkName(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getKeywords(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getContent(),
			$keys[5] => $this->getId(),
			$keys[6] => $this->getCulture(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = StaticPageI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setLinkName($value);
				break;
			case 1:
				$this->setTitle($value);
				break;
			case 2:
				$this->setKeywords($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setContent($value);
				break;
			case 5:
				$this->setId($value);
				break;
			case 6:
				$this->setCulture($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = StaticPageI18nPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setLinkName($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setKeywords($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCulture($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(StaticPageI18nPeer::DATABASE_NAME);

		if ($this->isColumnModified(StaticPageI18nPeer::LINK_NAME)) $criteria->add(StaticPageI18nPeer::LINK_NAME, $this->link_name);
		if ($this->isColumnModified(StaticPageI18nPeer::TITLE)) $criteria->add(StaticPageI18nPeer::TITLE, $this->title);
		if ($this->isColumnModified(StaticPageI18nPeer::KEYWORDS)) $criteria->add(StaticPageI18nPeer::KEYWORDS, $this->keywords);
		if ($this->isColumnModified(StaticPageI18nPeer::DESCRIPTION)) $criteria->add(StaticPageI18nPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(StaticPageI18nPeer::CONTENT)) $criteria->add(StaticPageI18nPeer::CONTENT, $this->content);
		if ($this->isColumnModified(StaticPageI18nPeer::ID)) $criteria->add(StaticPageI18nPeer::ID, $this->id);
		if ($this->isColumnModified(StaticPageI18nPeer::CULTURE)) $criteria->add(StaticPageI18nPeer::CULTURE, $this->culture);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(StaticPageI18nPeer::DATABASE_NAME);

		$criteria->add(StaticPageI18nPeer::ID, $this->id);
		$criteria->add(StaticPageI18nPeer::CULTURE, $this->culture);

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

		$copyObj->setLinkName($this->link_name);

		$copyObj->setTitle($this->title);

		$copyObj->setKeywords($this->keywords);

		$copyObj->setDescription($this->description);

		$copyObj->setContent($this->content);


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
			self::$peer = new StaticPageI18nPeer();
		}
		return self::$peer;
	}

	
	public function setStaticPage($v)
	{


		if ($v === null) {
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
		}


		$this->aStaticPage = $v;
	}


	
	public function getStaticPage($con = null)
	{
		if ($this->aStaticPage === null && ($this->id !== null)) {
						include_once 'lib/model/om/BaseStaticPagePeer.php';

			$this->aStaticPage = StaticPagePeer::retrieveByPK($this->id, $con);

			
		}
		return $this->aStaticPage;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseStaticPageI18n:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseStaticPageI18n::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 