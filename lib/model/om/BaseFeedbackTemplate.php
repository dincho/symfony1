<?php


abstract class BaseFeedbackTemplate extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $mail_from;


	
	protected $reply_to;


	
	protected $bcc;


	
	protected $subject;


	
	protected $body;


	
	protected $footer;

	
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::NAME;
		}

	} 
	
	public function setMailFrom($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mail_from !== $v) {
			$this->mail_from = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::MAIL_FROM;
		}

	} 
	
	public function setReplyTo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->reply_to !== $v) {
			$this->reply_to = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::REPLY_TO;
		}

	} 
	
	public function setBcc($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bcc !== $v) {
			$this->bcc = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::BCC;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::SUBJECT;
		}

	} 
	
	public function setBody($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::BODY;
		}

	} 
	
	public function setFooter($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->footer !== $v) {
			$this->footer = $v;
			$this->modifiedColumns[] = FeedbackTemplatePeer::FOOTER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->mail_from = $rs->getString($startcol + 2);

			$this->reply_to = $rs->getString($startcol + 3);

			$this->bcc = $rs->getString($startcol + 4);

			$this->subject = $rs->getString($startcol + 5);

			$this->body = $rs->getString($startcol + 6);

			$this->footer = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating FeedbackTemplate object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackTemplate:delete:pre') as $callable)
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
			$con = Propel::getConnection(FeedbackTemplatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			FeedbackTemplatePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseFeedbackTemplate:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackTemplate:save:pre') as $callable)
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
			$con = Propel::getConnection(FeedbackTemplatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseFeedbackTemplate:save:post') as $callable)
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
					$pk = FeedbackTemplatePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += FeedbackTemplatePeer::doUpdate($this, $con);
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


			if (($retval = FeedbackTemplatePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FeedbackTemplatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getMailFrom();
				break;
			case 3:
				return $this->getReplyTo();
				break;
			case 4:
				return $this->getBcc();
				break;
			case 5:
				return $this->getSubject();
				break;
			case 6:
				return $this->getBody();
				break;
			case 7:
				return $this->getFooter();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FeedbackTemplatePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getMailFrom(),
			$keys[3] => $this->getReplyTo(),
			$keys[4] => $this->getBcc(),
			$keys[5] => $this->getSubject(),
			$keys[6] => $this->getBody(),
			$keys[7] => $this->getFooter(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FeedbackTemplatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setMailFrom($value);
				break;
			case 3:
				$this->setReplyTo($value);
				break;
			case 4:
				$this->setBcc($value);
				break;
			case 5:
				$this->setSubject($value);
				break;
			case 6:
				$this->setBody($value);
				break;
			case 7:
				$this->setFooter($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FeedbackTemplatePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMailFrom($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setReplyTo($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setBcc($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSubject($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setBody($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFooter($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(FeedbackTemplatePeer::DATABASE_NAME);

		if ($this->isColumnModified(FeedbackTemplatePeer::ID)) $criteria->add(FeedbackTemplatePeer::ID, $this->id);
		if ($this->isColumnModified(FeedbackTemplatePeer::NAME)) $criteria->add(FeedbackTemplatePeer::NAME, $this->name);
		if ($this->isColumnModified(FeedbackTemplatePeer::MAIL_FROM)) $criteria->add(FeedbackTemplatePeer::MAIL_FROM, $this->mail_from);
		if ($this->isColumnModified(FeedbackTemplatePeer::REPLY_TO)) $criteria->add(FeedbackTemplatePeer::REPLY_TO, $this->reply_to);
		if ($this->isColumnModified(FeedbackTemplatePeer::BCC)) $criteria->add(FeedbackTemplatePeer::BCC, $this->bcc);
		if ($this->isColumnModified(FeedbackTemplatePeer::SUBJECT)) $criteria->add(FeedbackTemplatePeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(FeedbackTemplatePeer::BODY)) $criteria->add(FeedbackTemplatePeer::BODY, $this->body);
		if ($this->isColumnModified(FeedbackTemplatePeer::FOOTER)) $criteria->add(FeedbackTemplatePeer::FOOTER, $this->footer);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(FeedbackTemplatePeer::DATABASE_NAME);

		$criteria->add(FeedbackTemplatePeer::ID, $this->id);

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

		$copyObj->setMailFrom($this->mail_from);

		$copyObj->setReplyTo($this->reply_to);

		$copyObj->setBcc($this->bcc);

		$copyObj->setSubject($this->subject);

		$copyObj->setBody($this->body);

		$copyObj->setFooter($this->footer);


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
			self::$peer = new FeedbackTemplatePeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseFeedbackTemplate:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseFeedbackTemplate::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 