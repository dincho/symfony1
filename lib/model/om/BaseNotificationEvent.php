<?php


abstract class BaseNotificationEvent extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $notification_id;


	
	protected $event;

	
	protected $aNotification;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getNotificationId()
	{

		return $this->notification_id;
	}

	
	public function getEvent()
	{

		return $this->event;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = NotificationEventPeer::ID;
		}

	} 
	
	public function setNotificationId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->notification_id !== $v) {
			$this->notification_id = $v;
			$this->modifiedColumns[] = NotificationEventPeer::NOTIFICATION_ID;
		}

		if ($this->aNotification !== null && $this->aNotification->getId() !== $v) {
			$this->aNotification = null;
		}

	} 
	
	public function setEvent($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->event !== $v) {
			$this->event = $v;
			$this->modifiedColumns[] = NotificationEventPeer::EVENT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->notification_id = $rs->getInt($startcol + 1);

			$this->event = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating NotificationEvent object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseNotificationEvent:delete:pre') as $callable)
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
			$con = Propel::getConnection(NotificationEventPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			NotificationEventPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseNotificationEvent:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseNotificationEvent:save:pre') as $callable)
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
			$con = Propel::getConnection(NotificationEventPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseNotificationEvent:save:post') as $callable)
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


												
			if ($this->aNotification !== null) {
				if ($this->aNotification->isModified()) {
					$affectedRows += $this->aNotification->save($con);
				}
				$this->setNotification($this->aNotification);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = NotificationEventPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += NotificationEventPeer::doUpdate($this, $con);
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


												
			if ($this->aNotification !== null) {
				if (!$this->aNotification->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNotification->getValidationFailures());
				}
			}


			if (($retval = NotificationEventPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NotificationEventPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getNotificationId();
				break;
			case 2:
				return $this->getEvent();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NotificationEventPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getNotificationId(),
			$keys[2] => $this->getEvent(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NotificationEventPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setNotificationId($value);
				break;
			case 2:
				$this->setEvent($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NotificationEventPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNotificationId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setEvent($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(NotificationEventPeer::DATABASE_NAME);

		if ($this->isColumnModified(NotificationEventPeer::ID)) $criteria->add(NotificationEventPeer::ID, $this->id);
		if ($this->isColumnModified(NotificationEventPeer::NOTIFICATION_ID)) $criteria->add(NotificationEventPeer::NOTIFICATION_ID, $this->notification_id);
		if ($this->isColumnModified(NotificationEventPeer::EVENT)) $criteria->add(NotificationEventPeer::EVENT, $this->event);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(NotificationEventPeer::DATABASE_NAME);

		$criteria->add(NotificationEventPeer::ID, $this->id);

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

		$copyObj->setNotificationId($this->notification_id);

		$copyObj->setEvent($this->event);


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
			self::$peer = new NotificationEventPeer();
		}
		return self::$peer;
	}

	
	public function setNotification($v)
	{


		if ($v === null) {
			$this->setNotificationId(NULL);
		} else {
			$this->setNotificationId($v->getId());
		}


		$this->aNotification = $v;
	}


	
	public function getNotification($con = null)
	{
		if ($this->aNotification === null && ($this->notification_id !== null)) {
						include_once 'lib/model/om/BaseNotificationPeer.php';

			$this->aNotification = NotificationPeer::retrieveByPK($this->notification_id, $con);

			
		}
		return $this->aNotification;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseNotificationEvent:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseNotificationEvent::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 