<?php


abstract class BaseFeedback extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $mailbox = 1;


	
	protected $member_id;


	
	protected $mail_from;


	
	protected $name_from;


	
	protected $mail_to;


	
	protected $name_to;


	
	protected $bcc;


	
	protected $subject;


	
	protected $body;


	
	protected $is_read = false;


	
	protected $created_at;

	
	protected $aMember;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMailbox()
	{

		return $this->mailbox;
	}

	
	public function getMemberId()
	{

		return $this->member_id;
	}

	
	public function getMailFrom()
	{

		return $this->mail_from;
	}

	
	public function getNameFrom()
	{

		return $this->name_from;
	}

	
	public function getMailTo()
	{

		return $this->mail_to;
	}

	
	public function getNameTo()
	{

		return $this->name_to;
	}

	
	public function getBcc()
	{

		return $this->bcc;
	}

	
	public function getSubject()
	{

		return $this->subject;
	}

	
	public function getBody()
	{

		return $this->body;
	}

	
	public function getIsRead()
	{

		return $this->is_read;
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
			$this->modifiedColumns[] = FeedbackPeer::ID;
		}

	} 
	
	public function setMailbox($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->mailbox !== $v || $v === 1) {
			$this->mailbox = $v;
			$this->modifiedColumns[] = FeedbackPeer::MAILBOX;
		}

	} 
	
	public function setMemberId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = FeedbackPeer::MEMBER_ID;
		}

		if ($this->aMember !== null && $this->aMember->getId() !== $v) {
			$this->aMember = null;
		}

	} 
	
	public function setMailFrom($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mail_from !== $v) {
			$this->mail_from = $v;
			$this->modifiedColumns[] = FeedbackPeer::MAIL_FROM;
		}

	} 
	
	public function setNameFrom($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name_from !== $v) {
			$this->name_from = $v;
			$this->modifiedColumns[] = FeedbackPeer::NAME_FROM;
		}

	} 
	
	public function setMailTo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mail_to !== $v) {
			$this->mail_to = $v;
			$this->modifiedColumns[] = FeedbackPeer::MAIL_TO;
		}

	} 
	
	public function setNameTo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name_to !== $v) {
			$this->name_to = $v;
			$this->modifiedColumns[] = FeedbackPeer::NAME_TO;
		}

	} 
	
	public function setBcc($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bcc !== $v) {
			$this->bcc = $v;
			$this->modifiedColumns[] = FeedbackPeer::BCC;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = FeedbackPeer::SUBJECT;
		}

	} 
	
	public function setBody($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = FeedbackPeer::BODY;
		}

	} 
	
	public function setIsRead($v)
	{

		if ($this->is_read !== $v || $v === false) {
			$this->is_read = $v;
			$this->modifiedColumns[] = FeedbackPeer::IS_READ;
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
			$this->modifiedColumns[] = FeedbackPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->mailbox = $rs->getInt($startcol + 1);

			$this->member_id = $rs->getInt($startcol + 2);

			$this->mail_from = $rs->getString($startcol + 3);

			$this->name_from = $rs->getString($startcol + 4);

			$this->mail_to = $rs->getString($startcol + 5);

			$this->name_to = $rs->getString($startcol + 6);

			$this->bcc = $rs->getString($startcol + 7);

			$this->subject = $rs->getString($startcol + 8);

			$this->body = $rs->getString($startcol + 9);

			$this->is_read = $rs->getBoolean($startcol + 10);

			$this->created_at = $rs->getTimestamp($startcol + 11, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Feedback object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedback:delete:pre') as $callable)
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
			$con = Propel::getConnection(FeedbackPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			FeedbackPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseFeedback:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedback:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(FeedbackPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(FeedbackPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseFeedback:save:post') as $callable)
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


												
			if ($this->aMember !== null) {
				if ($this->aMember->isModified()) {
					$affectedRows += $this->aMember->save($con);
				}
				$this->setMember($this->aMember);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = FeedbackPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += FeedbackPeer::doUpdate($this, $con);
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


												
			if ($this->aMember !== null) {
				if (!$this->aMember->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMember->getValidationFailures());
				}
			}


			if (($retval = FeedbackPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FeedbackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMailbox();
				break;
			case 2:
				return $this->getMemberId();
				break;
			case 3:
				return $this->getMailFrom();
				break;
			case 4:
				return $this->getNameFrom();
				break;
			case 5:
				return $this->getMailTo();
				break;
			case 6:
				return $this->getNameTo();
				break;
			case 7:
				return $this->getBcc();
				break;
			case 8:
				return $this->getSubject();
				break;
			case 9:
				return $this->getBody();
				break;
			case 10:
				return $this->getIsRead();
				break;
			case 11:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FeedbackPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMailbox(),
			$keys[2] => $this->getMemberId(),
			$keys[3] => $this->getMailFrom(),
			$keys[4] => $this->getNameFrom(),
			$keys[5] => $this->getMailTo(),
			$keys[6] => $this->getNameTo(),
			$keys[7] => $this->getBcc(),
			$keys[8] => $this->getSubject(),
			$keys[9] => $this->getBody(),
			$keys[10] => $this->getIsRead(),
			$keys[11] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FeedbackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMailbox($value);
				break;
			case 2:
				$this->setMemberId($value);
				break;
			case 3:
				$this->setMailFrom($value);
				break;
			case 4:
				$this->setNameFrom($value);
				break;
			case 5:
				$this->setMailTo($value);
				break;
			case 6:
				$this->setNameTo($value);
				break;
			case 7:
				$this->setBcc($value);
				break;
			case 8:
				$this->setSubject($value);
				break;
			case 9:
				$this->setBody($value);
				break;
			case 10:
				$this->setIsRead($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FeedbackPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMailbox($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMemberId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMailFrom($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNameFrom($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMailTo($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setNameTo($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setBcc($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSubject($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setBody($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsRead($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(FeedbackPeer::DATABASE_NAME);

		if ($this->isColumnModified(FeedbackPeer::ID)) $criteria->add(FeedbackPeer::ID, $this->id);
		if ($this->isColumnModified(FeedbackPeer::MAILBOX)) $criteria->add(FeedbackPeer::MAILBOX, $this->mailbox);
		if ($this->isColumnModified(FeedbackPeer::MEMBER_ID)) $criteria->add(FeedbackPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(FeedbackPeer::MAIL_FROM)) $criteria->add(FeedbackPeer::MAIL_FROM, $this->mail_from);
		if ($this->isColumnModified(FeedbackPeer::NAME_FROM)) $criteria->add(FeedbackPeer::NAME_FROM, $this->name_from);
		if ($this->isColumnModified(FeedbackPeer::MAIL_TO)) $criteria->add(FeedbackPeer::MAIL_TO, $this->mail_to);
		if ($this->isColumnModified(FeedbackPeer::NAME_TO)) $criteria->add(FeedbackPeer::NAME_TO, $this->name_to);
		if ($this->isColumnModified(FeedbackPeer::BCC)) $criteria->add(FeedbackPeer::BCC, $this->bcc);
		if ($this->isColumnModified(FeedbackPeer::SUBJECT)) $criteria->add(FeedbackPeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(FeedbackPeer::BODY)) $criteria->add(FeedbackPeer::BODY, $this->body);
		if ($this->isColumnModified(FeedbackPeer::IS_READ)) $criteria->add(FeedbackPeer::IS_READ, $this->is_read);
		if ($this->isColumnModified(FeedbackPeer::CREATED_AT)) $criteria->add(FeedbackPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(FeedbackPeer::DATABASE_NAME);

		$criteria->add(FeedbackPeer::ID, $this->id);

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

		$copyObj->setMailbox($this->mailbox);

		$copyObj->setMemberId($this->member_id);

		$copyObj->setMailFrom($this->mail_from);

		$copyObj->setNameFrom($this->name_from);

		$copyObj->setMailTo($this->mail_to);

		$copyObj->setNameTo($this->name_to);

		$copyObj->setBcc($this->bcc);

		$copyObj->setSubject($this->subject);

		$copyObj->setBody($this->body);

		$copyObj->setIsRead($this->is_read);

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
			self::$peer = new FeedbackPeer();
		}
		return self::$peer;
	}

	
	public function setMember($v)
	{


		if ($v === null) {
			$this->setMemberId(NULL);
		} else {
			$this->setMemberId($v->getId());
		}


		$this->aMember = $v;
	}


	
	public function getMember($con = null)
	{
		if ($this->aMember === null && ($this->member_id !== null)) {
						include_once 'lib/model/om/BaseMemberPeer.php';

			$this->aMember = MemberPeer::retrieveByPK($this->member_id, $con);

			
		}
		return $this->aMember;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseFeedback:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseFeedback::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 