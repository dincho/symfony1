<?php


abstract class BaseIpnHistory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $parameters;


	
	protected $request_ip;


	
	protected $txn_type;


	
	protected $txn_id;


	
	protected $subscr_id;


	
	protected $payment_status;


	
	protected $paypal_response;


	
	protected $created_at;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getParameters()
	{

		return $this->parameters;
	}

	
	public function getRequestIp()
	{

		return $this->request_ip;
	}

	
	public function getTxnType()
	{

		return $this->txn_type;
	}

	
	public function getTxnId()
	{

		return $this->txn_id;
	}

	
	public function getSubscrId()
	{

		return $this->subscr_id;
	}

	
	public function getPaymentStatus()
	{

		return $this->payment_status;
	}

	
	public function getPaypalResponse()
	{

		return $this->paypal_response;
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
			$this->modifiedColumns[] = IpnHistoryPeer::ID;
		}

	} 
	
	public function setParameters($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->parameters !== $v) {
			$this->parameters = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::PARAMETERS;
		}

	} 
	
	public function setRequestIp($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->request_ip !== $v) {
			$this->request_ip = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::REQUEST_IP;
		}

	} 
	
	public function setTxnType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->txn_type !== $v) {
			$this->txn_type = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::TXN_TYPE;
		}

	} 
	
	public function setTxnId($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->txn_id !== $v) {
			$this->txn_id = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::TXN_ID;
		}

	} 
	
	public function setSubscrId($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subscr_id !== $v) {
			$this->subscr_id = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::SUBSCR_ID;
		}

	} 
	
	public function setPaymentStatus($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->payment_status !== $v) {
			$this->payment_status = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::PAYMENT_STATUS;
		}

	} 
	
	public function setPaypalResponse($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->paypal_response !== $v) {
			$this->paypal_response = $v;
			$this->modifiedColumns[] = IpnHistoryPeer::PAYPAL_RESPONSE;
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
			$this->modifiedColumns[] = IpnHistoryPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->parameters = $rs->getString($startcol + 1);

			$this->request_ip = $rs->getInt($startcol + 2);

			$this->txn_type = $rs->getString($startcol + 3);

			$this->txn_id = $rs->getString($startcol + 4);

			$this->subscr_id = $rs->getString($startcol + 5);

			$this->payment_status = $rs->getString($startcol + 6);

			$this->paypal_response = $rs->getString($startcol + 7);

			$this->created_at = $rs->getTimestamp($startcol + 8, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating IpnHistory object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseIpnHistory:delete:pre') as $callable)
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
			$con = Propel::getConnection(IpnHistoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			IpnHistoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseIpnHistory:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseIpnHistory:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(IpnHistoryPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(IpnHistoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseIpnHistory:save:post') as $callable)
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
					$pk = IpnHistoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += IpnHistoryPeer::doUpdate($this, $con);
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


			if (($retval = IpnHistoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = IpnHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getParameters();
				break;
			case 2:
				return $this->getRequestIp();
				break;
			case 3:
				return $this->getTxnType();
				break;
			case 4:
				return $this->getTxnId();
				break;
			case 5:
				return $this->getSubscrId();
				break;
			case 6:
				return $this->getPaymentStatus();
				break;
			case 7:
				return $this->getPaypalResponse();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = IpnHistoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getParameters(),
			$keys[2] => $this->getRequestIp(),
			$keys[3] => $this->getTxnType(),
			$keys[4] => $this->getTxnId(),
			$keys[5] => $this->getSubscrId(),
			$keys[6] => $this->getPaymentStatus(),
			$keys[7] => $this->getPaypalResponse(),
			$keys[8] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = IpnHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setParameters($value);
				break;
			case 2:
				$this->setRequestIp($value);
				break;
			case 3:
				$this->setTxnType($value);
				break;
			case 4:
				$this->setTxnId($value);
				break;
			case 5:
				$this->setSubscrId($value);
				break;
			case 6:
				$this->setPaymentStatus($value);
				break;
			case 7:
				$this->setPaypalResponse($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = IpnHistoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setParameters($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRequestIp($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTxnType($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTxnId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSubscrId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPaymentStatus($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPaypalResponse($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(IpnHistoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(IpnHistoryPeer::ID)) $criteria->add(IpnHistoryPeer::ID, $this->id);
		if ($this->isColumnModified(IpnHistoryPeer::PARAMETERS)) $criteria->add(IpnHistoryPeer::PARAMETERS, $this->parameters);
		if ($this->isColumnModified(IpnHistoryPeer::REQUEST_IP)) $criteria->add(IpnHistoryPeer::REQUEST_IP, $this->request_ip);
		if ($this->isColumnModified(IpnHistoryPeer::TXN_TYPE)) $criteria->add(IpnHistoryPeer::TXN_TYPE, $this->txn_type);
		if ($this->isColumnModified(IpnHistoryPeer::TXN_ID)) $criteria->add(IpnHistoryPeer::TXN_ID, $this->txn_id);
		if ($this->isColumnModified(IpnHistoryPeer::SUBSCR_ID)) $criteria->add(IpnHistoryPeer::SUBSCR_ID, $this->subscr_id);
		if ($this->isColumnModified(IpnHistoryPeer::PAYMENT_STATUS)) $criteria->add(IpnHistoryPeer::PAYMENT_STATUS, $this->payment_status);
		if ($this->isColumnModified(IpnHistoryPeer::PAYPAL_RESPONSE)) $criteria->add(IpnHistoryPeer::PAYPAL_RESPONSE, $this->paypal_response);
		if ($this->isColumnModified(IpnHistoryPeer::CREATED_AT)) $criteria->add(IpnHistoryPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(IpnHistoryPeer::DATABASE_NAME);

		$criteria->add(IpnHistoryPeer::ID, $this->id);

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

		$copyObj->setParameters($this->parameters);

		$copyObj->setRequestIp($this->request_ip);

		$copyObj->setTxnType($this->txn_type);

		$copyObj->setTxnId($this->txn_id);

		$copyObj->setSubscrId($this->subscr_id);

		$copyObj->setPaymentStatus($this->payment_status);

		$copyObj->setPaypalResponse($this->paypal_response);

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
			self::$peer = new IpnHistoryPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseIpnHistory:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseIpnHistory::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 