<?php


abstract class BaseMemberStory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $culture;


	
	protected $slug;


	
	protected $sort_order = 0;


	
	protected $link_name;


	
	protected $title;


	
	protected $keywords;


	
	protected $description;


	
	protected $content;


	
	protected $stock_photo_id;

	
	protected $aStockPhoto;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCulture()
	{

		return $this->culture;
	}

	
	public function getSlug()
	{

		return $this->slug;
	}

	
	public function getSortOrder()
	{

		return $this->sort_order;
	}

	
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

	
	public function getStockPhotoId()
	{

		return $this->stock_photo_id;
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
	
	public function setCulture($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->culture !== $v) {
			$this->culture = $v;
			$this->modifiedColumns[] = MemberStoryPeer::CULTURE;
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
	
	public function setLinkName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->link_name !== $v) {
			$this->link_name = $v;
			$this->modifiedColumns[] = MemberStoryPeer::LINK_NAME;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = MemberStoryPeer::TITLE;
		}

	} 
	
	public function setKeywords($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->keywords !== $v) {
			$this->keywords = $v;
			$this->modifiedColumns[] = MemberStoryPeer::KEYWORDS;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = MemberStoryPeer::DESCRIPTION;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = MemberStoryPeer::CONTENT;
		}

	} 
	
	public function setStockPhotoId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->stock_photo_id !== $v) {
			$this->stock_photo_id = $v;
			$this->modifiedColumns[] = MemberStoryPeer::STOCK_PHOTO_ID;
		}

		if ($this->aStockPhoto !== null && $this->aStockPhoto->getId() !== $v) {
			$this->aStockPhoto = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->culture = $rs->getString($startcol + 1);

			$this->slug = $rs->getString($startcol + 2);

			$this->sort_order = $rs->getInt($startcol + 3);

			$this->link_name = $rs->getString($startcol + 4);

			$this->title = $rs->getString($startcol + 5);

			$this->keywords = $rs->getString($startcol + 6);

			$this->description = $rs->getString($startcol + 7);

			$this->content = $rs->getString($startcol + 8);

			$this->stock_photo_id = $rs->getInt($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
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


												
			if ($this->aStockPhoto !== null) {
				if ($this->aStockPhoto->isModified()) {
					$affectedRows += $this->aStockPhoto->save($con);
				}
				$this->setStockPhoto($this->aStockPhoto);
			}


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


												
			if ($this->aStockPhoto !== null) {
				if (!$this->aStockPhoto->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aStockPhoto->getValidationFailures());
				}
			}


			if (($retval = MemberStoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
				return $this->getCulture();
				break;
			case 2:
				return $this->getSlug();
				break;
			case 3:
				return $this->getSortOrder();
				break;
			case 4:
				return $this->getLinkName();
				break;
			case 5:
				return $this->getTitle();
				break;
			case 6:
				return $this->getKeywords();
				break;
			case 7:
				return $this->getDescription();
				break;
			case 8:
				return $this->getContent();
				break;
			case 9:
				return $this->getStockPhotoId();
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
			$keys[1] => $this->getCulture(),
			$keys[2] => $this->getSlug(),
			$keys[3] => $this->getSortOrder(),
			$keys[4] => $this->getLinkName(),
			$keys[5] => $this->getTitle(),
			$keys[6] => $this->getKeywords(),
			$keys[7] => $this->getDescription(),
			$keys[8] => $this->getContent(),
			$keys[9] => $this->getStockPhotoId(),
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
				$this->setCulture($value);
				break;
			case 2:
				$this->setSlug($value);
				break;
			case 3:
				$this->setSortOrder($value);
				break;
			case 4:
				$this->setLinkName($value);
				break;
			case 5:
				$this->setTitle($value);
				break;
			case 6:
				$this->setKeywords($value);
				break;
			case 7:
				$this->setDescription($value);
				break;
			case 8:
				$this->setContent($value);
				break;
			case 9:
				$this->setStockPhotoId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MemberStoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCulture($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSlug($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSortOrder($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLinkName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTitle($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setKeywords($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setContent($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setStockPhotoId($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MemberStoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(MemberStoryPeer::ID)) $criteria->add(MemberStoryPeer::ID, $this->id);
		if ($this->isColumnModified(MemberStoryPeer::CULTURE)) $criteria->add(MemberStoryPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(MemberStoryPeer::SLUG)) $criteria->add(MemberStoryPeer::SLUG, $this->slug);
		if ($this->isColumnModified(MemberStoryPeer::SORT_ORDER)) $criteria->add(MemberStoryPeer::SORT_ORDER, $this->sort_order);
		if ($this->isColumnModified(MemberStoryPeer::LINK_NAME)) $criteria->add(MemberStoryPeer::LINK_NAME, $this->link_name);
		if ($this->isColumnModified(MemberStoryPeer::TITLE)) $criteria->add(MemberStoryPeer::TITLE, $this->title);
		if ($this->isColumnModified(MemberStoryPeer::KEYWORDS)) $criteria->add(MemberStoryPeer::KEYWORDS, $this->keywords);
		if ($this->isColumnModified(MemberStoryPeer::DESCRIPTION)) $criteria->add(MemberStoryPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(MemberStoryPeer::CONTENT)) $criteria->add(MemberStoryPeer::CONTENT, $this->content);
		if ($this->isColumnModified(MemberStoryPeer::STOCK_PHOTO_ID)) $criteria->add(MemberStoryPeer::STOCK_PHOTO_ID, $this->stock_photo_id);

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

		$copyObj->setCulture($this->culture);

		$copyObj->setSlug($this->slug);

		$copyObj->setSortOrder($this->sort_order);

		$copyObj->setLinkName($this->link_name);

		$copyObj->setTitle($this->title);

		$copyObj->setKeywords($this->keywords);

		$copyObj->setDescription($this->description);

		$copyObj->setContent($this->content);

		$copyObj->setStockPhotoId($this->stock_photo_id);


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

	
	public function setStockPhoto($v)
	{


		if ($v === null) {
			$this->setStockPhotoId(NULL);
		} else {
			$this->setStockPhotoId($v->getId());
		}


		$this->aStockPhoto = $v;
	}


	
	public function getStockPhoto($con = null)
	{
		if ($this->aStockPhoto === null && ($this->stock_photo_id !== null)) {
						include_once 'lib/model/om/BaseStockPhotoPeer.php';

			$this->aStockPhoto = StockPhotoPeer::retrieveByPK($this->stock_photo_id, $con);

			
		}
		return $this->aStockPhoto;
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