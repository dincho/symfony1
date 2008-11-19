<?php


abstract class BaseNotification extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $send_from;


	
	protected $send_to;


	
	protected $reply_to;


	
	protected $bcc;


	
	protected $trigger_name;


	
	protected $subject;


	
	protected $body;


	
	protected $footer;


	
	protected $is_active = false;


	
	protected $to_admins = false;


	
	protected $days;


	
	protected $whn;

	
	protected $collNotificationEvents;

	
	protected $lastNotificationEventCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getSendFrom()
	{

		return $this->send_from;
	}

	
	public function getSendTo()
	{

		return $this->send_to;
	}

	
	public function getReplyTo()
	{

		return $this->reply_to;
	}

	
	public function getBcc()
	{

		return $this->bcc;
	}

	
	public function getTriggerName()
	{

		return $this->trigger_name;
	}

	
	public function getSubject()
	{

		return $this->subject;
	}

	
	public function getBody()
	{

		return $this->body;
	}

	
	public function getFooter()
	{

		return $this->footer;
	}

	
	public function getIsActive()
	{

		return $this->is_active;
	}

	
	public function getToAdmins()
	{

		return $this->to_admins;
	}

	
	public function getDays()
	{

		return $this->days;
	}

	
	public function getWhn()
	{

		return $this->whn;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = NotificationPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = NotificationPeer::NAME;
		}

	} 
	
	public function setSendFrom($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->send_from !== $v) {
			$this->send_from = $v;
			$this->modifiedColumns[] = NotificationPeer::SEND_FROM;
		}

	} 
	
	public function setSendTo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->send_to !== $v) {
			$this->send_to = $v;
			$this->modifiedColumns[] = NotificationPeer::SEND_TO;
		}

	} 
	
	public function setReplyTo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->reply_to !== $v) {
			$this->reply_to = $v;
			$this->modifiedColumns[] = NotificationPeer::REPLY_TO;
		}

	} 
	
	public function setBcc($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bcc !== $v) {
			$this->bcc = $v;
			$this->modifiedColumns[] = NotificationPeer::BCC;
		}

	} 
	
	public function setTriggerName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->trigger_name !== $v) {
			$this->trigger_name = $v;
			$this->modifiedColumns[] = NotificationPeer::TRIGGER_NAME;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = NotificationPeer::SUBJECT;
		}

	} 
	
	public function setBody($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = NotificationPeer::BODY;
		}

	} 
	
	public function setFooter($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->footer !== $v) {
			$this->footer = $v;
			$this->modifiedColumns[] = NotificationPeer::FOOTER;
		}

	} 
	
	public function setIsActive($v)
	{

		if ($this->is_active !== $v || $v === false) {
			$this->is_active = $v;
			$this->modifiedColumns[] = NotificationPeer::IS_ACTIVE;
		}

	} 
	
	public function setToAdmins($v)
	{

		if ($this->to_admins !== $v || $v === false) {
			$this->to_admins = $v;
			$this->modifiedColumns[] = NotificationPeer::TO_ADMINS;
		}

	} 
	
	public function setDays($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->days !== $v) {
			$this->days = $v;
			$this->modifiedColumns[] = NotificationPeer::DAYS;
		}

	} 
	
	public function setWhn($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->whn !== $v) {
			$this->whn = $v;
			$this->modifiedColumns[] = NotificationPeer::WHN;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->send_from = $rs->getString($startcol + 2);

			$this->send_to = $rs->getString($startcol + 3);

			$this->reply_to = $rs->getString($startcol + 4);

			$this->bcc = $rs->getString($startcol + 5);

			$this->trigger_name = $rs->getString($startcol + 6);

			$this->subject = $rs->getString($startcol + 7);

			$this->body = $rs->getString($startcol + 8);

			$this->footer = $rs->getString($startcol + 9);

			$this->is_active = $rs->getBoolean($startcol + 10);

			$this->to_admins = $rs->getBoolean($startcol + 11);

			$this->days = $rs->getInt($startcol + 12);

			$this->whn = $rs->getString($startcol + 13);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 14; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Notification object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseNotification:delete:pre') as $callable)
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
			$con = Propel::getConnection(NotificationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			NotificationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseNotification:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseNotification:save:pre') as $callable)
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
			$con = Propel::getConnection(NotificationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseNotification:save:post') as $callable)
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
					$pk = NotificationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += NotificationPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collNotificationEvents !== null) {
				foreach($this->collNotificationEvents as $referrerFK) {
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


			if (($retval = NotificationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collNotificationEvents !== null) {
					foreach($this->collNotificationEvents as $referrerFK) {
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
		$pos = NotificationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getSendFrom();
				break;
			case 3:
				return $this->getSendTo();
				break;
			case 4:
				return $this->getReplyTo();
				break;
			case 5:
				return $this->getBcc();
				break;
			case 6:
				return $this->getTriggerName();
				break;
			case 7:
				return $this->getSubject();
				break;
			case 8:
				return $this->getBody();
				break;
			case 9:
				return $this->getFooter();
				break;
			case 10:
				return $this->getIsActive();
				break;
			case 11:
				return $this->getToAdmins();
				break;
			case 12:
				return $this->getDays();
				break;
			case 13:
				return $this->getWhn();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NotificationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getSendFrom(),
			$keys[3] => $this->getSendTo(),
			$keys[4] => $this->getReplyTo(),
			$keys[5] => $this->getBcc(),
			$keys[6] => $this->getTriggerName(),
			$keys[7] => $this->getSubject(),
			$keys[8] => $this->getBody(),
			$keys[9] => $this->getFooter(),
			$keys[10] => $this->getIsActive(),
			$keys[11] => $this->getToAdmins(),
			$keys[12] => $this->getDays(),
			$keys[13] => $this->getWhn(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NotificationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setSendFrom($value);
				break;
			case 3:
				$this->setSendTo($value);
				break;
			case 4:
				$this->setReplyTo($value);
				break;
			case 5:
				$this->setBcc($value);
				break;
			case 6:
				$this->setTriggerName($value);
				break;
			case 7:
				$this->setSubject($value);
				break;
			case 8:
				$this->setBody($value);
				break;
			case 9:
				$this->setFooter($value);
				break;
			case 10:
				$this->setIsActive($value);
				break;
			case 11:
				$this->setToAdmins($value);
				break;
			case 12:
				$this->setDays($value);
				break;
			case 13:
				$this->setWhn($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NotificationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSendFrom($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSendTo($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setReplyTo($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setBcc($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTriggerName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setSubject($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setBody($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFooter($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsActive($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setToAdmins($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setDays($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setWhn($arr[$keys[13]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(NotificationPeer::DATABASE_NAME);

		if ($this->isColumnModified(NotificationPeer::ID)) $criteria->add(NotificationPeer::ID, $this->id);
		if ($this->isColumnModified(NotificationPeer::NAME)) $criteria->add(NotificationPeer::NAME, $this->name);
		if ($this->isColumnModified(NotificationPeer::SEND_FROM)) $criteria->add(NotificationPeer::SEND_FROM, $this->send_from);
		if ($this->isColumnModified(NotificationPeer::SEND_TO)) $criteria->add(NotificationPeer::SEND_TO, $this->send_to);
		if ($this->isColumnModified(NotificationPeer::REPLY_TO)) $criteria->add(NotificationPeer::REPLY_TO, $this->reply_to);
		if ($this->isColumnModified(NotificationPeer::BCC)) $criteria->add(NotificationPeer::BCC, $this->bcc);
		if ($this->isColumnModified(NotificationPeer::TRIGGER_NAME)) $criteria->add(NotificationPeer::TRIGGER_NAME, $this->trigger_name);
		if ($this->isColumnModified(NotificationPeer::SUBJECT)) $criteria->add(NotificationPeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(NotificationPeer::BODY)) $criteria->add(NotificationPeer::BODY, $this->body);
		if ($this->isColumnModified(NotificationPeer::FOOTER)) $criteria->add(NotificationPeer::FOOTER, $this->footer);
		if ($this->isColumnModified(NotificationPeer::IS_ACTIVE)) $criteria->add(NotificationPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(NotificationPeer::TO_ADMINS)) $criteria->add(NotificationPeer::TO_ADMINS, $this->to_admins);
		if ($this->isColumnModified(NotificationPeer::DAYS)) $criteria->add(NotificationPeer::DAYS, $this->days);
		if ($this->isColumnModified(NotificationPeer::WHN)) $criteria->add(NotificationPeer::WHN, $this->whn);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(NotificationPeer::DATABASE_NAME);

		$criteria->add(NotificationPeer::ID, $this->id);

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

		$copyObj->setName($this->name);

		$copyObj->setSendFrom($this->send_from);

		$copyObj->setSendTo($this->send_to);

		$copyObj->setReplyTo($this->reply_to);

		$copyObj->setBcc($this->bcc);

		$copyObj->setTriggerName($this->trigger_name);

		$copyObj->setSubject($this->subject);

		$copyObj->setBody($this->body);

		$copyObj->setFooter($this->footer);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setToAdmins($this->to_admins);

		$copyObj->setDays($this->days);

		$copyObj->setWhn($this->whn);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getNotificationEvents() as $relObj) {
				$copyObj->addNotificationEvent($relObj->copy($deepCopy));
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
			self::$peer = new NotificationPeer();
		}
		return self::$peer;
	}

	
	public function initNotificationEvents()
	{
		if ($this->collNotificationEvents === null) {
			$this->collNotificationEvents = array();
		}
	}

	
	public function getNotificationEvents($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseNotificationEventPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationEvents === null) {
			if ($this->isNew()) {
			   $this->collNotificationEvents = array();
			} else {

				$criteria->add(NotificationEventPeer::NOTIFICATION_ID, $this->getId());

				NotificationEventPeer::addSelectColumns($criteria);
				$this->collNotificationEvents = NotificationEventPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(NotificationEventPeer::NOTIFICATION_ID, $this->getId());

				NotificationEventPeer::addSelectColumns($criteria);
				if (!isset($this->lastNotificationEventCriteria) || !$this->lastNotificationEventCriteria->equals($criteria)) {
					$this->collNotificationEvents = NotificationEventPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNotificationEventCriteria = $criteria;
		return $this->collNotificationEvents;
	}

	
	public function countNotificationEvents($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseNotificationEventPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(NotificationEventPeer::NOTIFICATION_ID, $this->getId());

		return NotificationEventPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addNotificationEvent(NotificationEvent $l)
	{
		$this->collNotificationEvents[] = $l;
		$l->setNotification($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseNotification:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseNotification::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 