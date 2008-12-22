<?php


abstract class BaseImbraReplyTemplate extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $user_id;


	
	protected $title;


	
	protected $subject;


	
	protected $body;


	
	protected $footer;


	
	protected $mail_from;


	
	protected $reply_to;


	
	protected $bcc;


	
	protected $created_at;

	
	protected $aUser;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getTitle()
	{

		return $this->title;
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

	
	public function getMailFrom()
	{

		return $this->mail_from;
	}

	
	public function getReplyTo()
	{

		return $this->reply_to;
	}

	
	public function getBcc()
	{

		return $this->bcc;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
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
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::TITLE;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::SUBJECT;
		}

	} 
	
	public function setBody($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::BODY;
		}

	} 
	
	public function setFooter($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->footer !== $v) {
			$this->footer = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::FOOTER;
		}

	} 
	
	public function setMailFrom($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mail_from !== $v) {
			$this->mail_from = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::MAIL_FROM;
		}

	} 
	
	public function setReplyTo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->reply_to !== $v) {
			$this->reply_to = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::REPLY_TO;
		}

	} 
	
	public function setBcc($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bcc !== $v) {
			$this->bcc = $v;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::BCC;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = ImbraReplyTemplatePeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->user_id = $rs->getInt($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->subject = $rs->getString($startcol + 3);

			$this->body = $rs->getString($startcol + 4);

			$this->footer = $rs->getString($startcol + 5);

			$this->mail_from = $rs->getString($startcol + 6);

			$this->reply_to = $rs->getString($startcol + 7);

			$this->bcc = $rs->getString($startcol + 8);

			$this->created_at = $rs->getTimestamp($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ImbraReplyTemplate object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraReplyTemplate:delete:pre') as $callable)
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
			$con = Propel::getConnection(ImbraReplyTemplatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ImbraReplyTemplatePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseImbraReplyTemplate:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraReplyTemplate:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(ImbraReplyTemplatePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ImbraReplyTemplatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseImbraReplyTemplate:save:post') as $callable)
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


												
			if ($this->aUser !== null) {
				if ($this->aUser->isModified()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ImbraReplyTemplatePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ImbraReplyTemplatePeer::doUpdate($this, $con);
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


												
			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}


			if (($retval = ImbraReplyTemplatePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ImbraReplyTemplatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getSubject();
				break;
			case 4:
				return $this->getBody();
				break;
			case 5:
				return $this->getFooter();
				break;
			case 6:
				return $this->getMailFrom();
				break;
			case 7:
				return $this->getReplyTo();
				break;
			case 8:
				return $this->getBcc();
				break;
			case 9:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraReplyTemplatePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getSubject(),
			$keys[4] => $this->getBody(),
			$keys[5] => $this->getFooter(),
			$keys[6] => $this->getMailFrom(),
			$keys[7] => $this->getReplyTo(),
			$keys[8] => $this->getBcc(),
			$keys[9] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ImbraReplyTemplatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setSubject($value);
				break;
			case 4:
				$this->setBody($value);
				break;
			case 5:
				$this->setFooter($value);
				break;
			case 6:
				$this->setMailFrom($value);
				break;
			case 7:
				$this->setReplyTo($value);
				break;
			case 8:
				$this->setBcc($value);
				break;
			case 9:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImbraReplyTemplatePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSubject($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setBody($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFooter($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMailFrom($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setReplyTo($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setBcc($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ImbraReplyTemplatePeer::DATABASE_NAME);

		if ($this->isColumnModified(ImbraReplyTemplatePeer::ID)) $criteria->add(ImbraReplyTemplatePeer::ID, $this->id);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::USER_ID)) $criteria->add(ImbraReplyTemplatePeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::TITLE)) $criteria->add(ImbraReplyTemplatePeer::TITLE, $this->title);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::SUBJECT)) $criteria->add(ImbraReplyTemplatePeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::BODY)) $criteria->add(ImbraReplyTemplatePeer::BODY, $this->body);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::FOOTER)) $criteria->add(ImbraReplyTemplatePeer::FOOTER, $this->footer);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::MAIL_FROM)) $criteria->add(ImbraReplyTemplatePeer::MAIL_FROM, $this->mail_from);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::REPLY_TO)) $criteria->add(ImbraReplyTemplatePeer::REPLY_TO, $this->reply_to);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::BCC)) $criteria->add(ImbraReplyTemplatePeer::BCC, $this->bcc);
		if ($this->isColumnModified(ImbraReplyTemplatePeer::CREATED_AT)) $criteria->add(ImbraReplyTemplatePeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ImbraReplyTemplatePeer::DATABASE_NAME);

		$criteria->add(ImbraReplyTemplatePeer::ID, $this->id);

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

		$copyObj->setUserId($this->user_id);

		$copyObj->setTitle($this->title);

		$copyObj->setSubject($this->subject);

		$copyObj->setBody($this->body);

		$copyObj->setFooter($this->footer);

		$copyObj->setMailFrom($this->mail_from);

		$copyObj->setReplyTo($this->reply_to);

		$copyObj->setBcc($this->bcc);

		$copyObj->setCreatedAt($this->created_at);


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
			self::$peer = new ImbraReplyTemplatePeer();
		}
		return self::$peer;
	}

	
	public function setUser($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->aUser = $v;
	}


	
	public function getUser($con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUser = UserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->aUser;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseImbraReplyTemplate:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseImbraReplyTemplate::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 