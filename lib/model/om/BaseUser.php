<?php


abstract class BaseUser extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $username;


	
	protected $password;


	
	protected $first_name;


	
	protected $last_name;


	
	protected $email;


	
	protected $phone;


	
	protected $must_change_pwd = false;


	
	protected $is_superuser = false;


	
	protected $is_enabled = false;


	
	protected $last_login;


	
	protected $created_at;

	
	protected $collMembers;

	
	protected $lastMemberCriteria = null;

	
	protected $collMemberNotes;

	
	protected $lastMemberNoteCriteria = null;

	
	protected $collSuspendedByFlags;

	
	protected $lastSuspendedByFlagCriteria = null;

	
	protected $collPermissionss;

	
	protected $lastPermissionsCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUsername()
	{

		return $this->username;
	}

	
	public function getPassword()
	{

		return $this->password;
	}

	
	public function getFirstName()
	{

		return $this->first_name;
	}

	
	public function getLastName()
	{

		return $this->last_name;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getPhone()
	{

		return $this->phone;
	}

	
	public function getMustChangePwd()
	{

		return $this->must_change_pwd;
	}

	
	public function getIsSuperuser()
	{

		return $this->is_superuser;
	}

	
	public function getIsEnabled()
	{

		return $this->is_enabled;
	}

	
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{

		if ($this->last_login === null || $this->last_login === '') {
			return null;
		} elseif (!is_int($this->last_login)) {
						$ts = strtotime($this->last_login);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_login] as date/time value: " . var_export($this->last_login, true));
			}
		} else {
			$ts = $this->last_login;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
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
			$this->modifiedColumns[] = UserPeer::ID;
		}

	} 
	
	public function setUsername($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = UserPeer::USERNAME;
		}

	} 
	
	public function setPassword($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD;
		}

	} 
	
	public function setFirstName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->first_name !== $v) {
			$this->first_name = $v;
			$this->modifiedColumns[] = UserPeer::FIRST_NAME;
		}

	} 
	
	public function setLastName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->last_name !== $v) {
			$this->last_name = $v;
			$this->modifiedColumns[] = UserPeer::LAST_NAME;
		}

	} 
	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL;
		}

	} 
	
	public function setPhone($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone !== $v) {
			$this->phone = $v;
			$this->modifiedColumns[] = UserPeer::PHONE;
		}

	} 
	
	public function setMustChangePwd($v)
	{

		if ($this->must_change_pwd !== $v || $v === false) {
			$this->must_change_pwd = $v;
			$this->modifiedColumns[] = UserPeer::MUST_CHANGE_PWD;
		}

	} 
	
	public function setIsSuperuser($v)
	{

		if ($this->is_superuser !== $v || $v === false) {
			$this->is_superuser = $v;
			$this->modifiedColumns[] = UserPeer::IS_SUPERUSER;
		}

	} 
	
	public function setIsEnabled($v)
	{

		if ($this->is_enabled !== $v || $v === false) {
			$this->is_enabled = $v;
			$this->modifiedColumns[] = UserPeer::IS_ENABLED;
		}

	} 
	
	public function setLastLogin($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_login] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_login !== $ts) {
			$this->last_login = $ts;
			$this->modifiedColumns[] = UserPeer::LAST_LOGIN;
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
			$this->modifiedColumns[] = UserPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->username = $rs->getString($startcol + 1);

			$this->password = $rs->getString($startcol + 2);

			$this->first_name = $rs->getString($startcol + 3);

			$this->last_name = $rs->getString($startcol + 4);

			$this->email = $rs->getString($startcol + 5);

			$this->phone = $rs->getString($startcol + 6);

			$this->must_change_pwd = $rs->getBoolean($startcol + 7);

			$this->is_superuser = $rs->getBoolean($startcol + 8);

			$this->is_enabled = $rs->getBoolean($startcol + 9);

			$this->last_login = $rs->getTimestamp($startcol + 10, null);

			$this->created_at = $rs->getTimestamp($startcol + 11, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseUser:delete:pre') as $callable)
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			UserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseUser:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseUser:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(UserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseUser:save:post') as $callable)
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
					$pk = UserPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collMembers !== null) {
				foreach($this->collMembers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberNotes !== null) {
				foreach($this->collMemberNotes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSuspendedByFlags !== null) {
				foreach($this->collSuspendedByFlags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPermissionss !== null) {
				foreach($this->collPermissionss as $referrerFK) {
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


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMembers !== null) {
					foreach($this->collMembers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberNotes !== null) {
					foreach($this->collMemberNotes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSuspendedByFlags !== null) {
					foreach($this->collSuspendedByFlags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPermissionss !== null) {
					foreach($this->collPermissionss as $referrerFK) {
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
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUsername();
				break;
			case 2:
				return $this->getPassword();
				break;
			case 3:
				return $this->getFirstName();
				break;
			case 4:
				return $this->getLastName();
				break;
			case 5:
				return $this->getEmail();
				break;
			case 6:
				return $this->getPhone();
				break;
			case 7:
				return $this->getMustChangePwd();
				break;
			case 8:
				return $this->getIsSuperuser();
				break;
			case 9:
				return $this->getIsEnabled();
				break;
			case 10:
				return $this->getLastLogin();
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
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getPassword(),
			$keys[3] => $this->getFirstName(),
			$keys[4] => $this->getLastName(),
			$keys[5] => $this->getEmail(),
			$keys[6] => $this->getPhone(),
			$keys[7] => $this->getMustChangePwd(),
			$keys[8] => $this->getIsSuperuser(),
			$keys[9] => $this->getIsEnabled(),
			$keys[10] => $this->getLastLogin(),
			$keys[11] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUsername($value);
				break;
			case 2:
				$this->setPassword($value);
				break;
			case 3:
				$this->setFirstName($value);
				break;
			case 4:
				$this->setLastName($value);
				break;
			case 5:
				$this->setEmail($value);
				break;
			case 6:
				$this->setPhone($value);
				break;
			case 7:
				$this->setMustChangePwd($value);
				break;
			case 8:
				$this->setIsSuperuser($value);
				break;
			case 9:
				$this->setIsEnabled($value);
				break;
			case 10:
				$this->setLastLogin($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPassword($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFirstName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLastName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPhone($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMustChangePwd($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsSuperuser($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsEnabled($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLastLogin($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::USERNAME)) $criteria->add(UserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(UserPeer::PASSWORD)) $criteria->add(UserPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(UserPeer::FIRST_NAME)) $criteria->add(UserPeer::FIRST_NAME, $this->first_name);
		if ($this->isColumnModified(UserPeer::LAST_NAME)) $criteria->add(UserPeer::LAST_NAME, $this->last_name);
		if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(UserPeer::PHONE)) $criteria->add(UserPeer::PHONE, $this->phone);
		if ($this->isColumnModified(UserPeer::MUST_CHANGE_PWD)) $criteria->add(UserPeer::MUST_CHANGE_PWD, $this->must_change_pwd);
		if ($this->isColumnModified(UserPeer::IS_SUPERUSER)) $criteria->add(UserPeer::IS_SUPERUSER, $this->is_superuser);
		if ($this->isColumnModified(UserPeer::IS_ENABLED)) $criteria->add(UserPeer::IS_ENABLED, $this->is_enabled);
		if ($this->isColumnModified(UserPeer::LAST_LOGIN)) $criteria->add(UserPeer::LAST_LOGIN, $this->last_login);
		if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $this->id);

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

		$copyObj->setUsername($this->username);

		$copyObj->setPassword($this->password);

		$copyObj->setFirstName($this->first_name);

		$copyObj->setLastName($this->last_name);

		$copyObj->setEmail($this->email);

		$copyObj->setPhone($this->phone);

		$copyObj->setMustChangePwd($this->must_change_pwd);

		$copyObj->setIsSuperuser($this->is_superuser);

		$copyObj->setIsEnabled($this->is_enabled);

		$copyObj->setLastLogin($this->last_login);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getMembers() as $relObj) {
				$copyObj->addMember($relObj->copy($deepCopy));
			}

			foreach($this->getMemberNotes() as $relObj) {
				$copyObj->addMemberNote($relObj->copy($deepCopy));
			}

			foreach($this->getSuspendedByFlags() as $relObj) {
				$copyObj->addSuspendedByFlag($relObj->copy($deepCopy));
			}

			foreach($this->getPermissionss() as $relObj) {
				$copyObj->addPermissions($relObj->copy($deepCopy));
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
			self::$peer = new UserPeer();
		}
		return self::$peer;
	}

	
	public function initMembers()
	{
		if ($this->collMembers === null) {
			$this->collMembers = array();
		}
	}

	
	public function getMembers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
			   $this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				$this->collMembers = MemberPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				MemberPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
					$this->collMembers = MemberPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberCriteria = $criteria;
		return $this->collMembers;
	}

	
	public function countMembers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

		return MemberPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMember(Member $l)
	{
		$this->collMembers[] = $l;
		$l->setUser($this);
	}


	
	public function getMembersJoinMemberStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberStatus($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinState($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinState($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinMemberPhoto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberPhoto($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinSubscription($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinSubscription($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}


	
	public function getMembersJoinMemberCounter($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMembers === null) {
			if ($this->isNew()) {
				$this->collMembers = array();
			} else {

				$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberPeer::REVIEWED_BY_ID, $this->getId());

			if (!isset($this->lastMemberCriteria) || !$this->lastMemberCriteria->equals($criteria)) {
				$this->collMembers = MemberPeer::doSelectJoinMemberCounter($criteria, $con);
			}
		}
		$this->lastMemberCriteria = $criteria;

		return $this->collMembers;
	}

	
	public function initMemberNotes()
	{
		if ($this->collMemberNotes === null) {
			$this->collMemberNotes = array();
		}
	}

	
	public function getMemberNotes($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberNotePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberNotes === null) {
			if ($this->isNew()) {
			   $this->collMemberNotes = array();
			} else {

				$criteria->add(MemberNotePeer::USER_ID, $this->getId());

				MemberNotePeer::addSelectColumns($criteria);
				$this->collMemberNotes = MemberNotePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MemberNotePeer::USER_ID, $this->getId());

				MemberNotePeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberNoteCriteria) || !$this->lastMemberNoteCriteria->equals($criteria)) {
					$this->collMemberNotes = MemberNotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberNoteCriteria = $criteria;
		return $this->collMemberNotes;
	}

	
	public function countMemberNotes($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMemberNotePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MemberNotePeer::USER_ID, $this->getId());

		return MemberNotePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMemberNote(MemberNote $l)
	{
		$this->collMemberNotes[] = $l;
		$l->setUser($this);
	}


	
	public function getMemberNotesJoinMember($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMemberNotePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberNotes === null) {
			if ($this->isNew()) {
				$this->collMemberNotes = array();
			} else {

				$criteria->add(MemberNotePeer::USER_ID, $this->getId());

				$this->collMemberNotes = MemberNotePeer::doSelectJoinMember($criteria, $con);
			}
		} else {
									
			$criteria->add(MemberNotePeer::USER_ID, $this->getId());

			if (!isset($this->lastMemberNoteCriteria) || !$this->lastMemberNoteCriteria->equals($criteria)) {
				$this->collMemberNotes = MemberNotePeer::doSelectJoinMember($criteria, $con);
			}
		}
		$this->lastMemberNoteCriteria = $criteria;

		return $this->collMemberNotes;
	}

	
	public function initSuspendedByFlags()
	{
		if ($this->collSuspendedByFlags === null) {
			$this->collSuspendedByFlags = array();
		}
	}

	
	public function getSuspendedByFlags($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSuspendedByFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSuspendedByFlags === null) {
			if ($this->isNew()) {
			   $this->collSuspendedByFlags = array();
			} else {

				$criteria->add(SuspendedByFlagPeer::CONFIRMED_BY, $this->getId());

				SuspendedByFlagPeer::addSelectColumns($criteria);
				$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SuspendedByFlagPeer::CONFIRMED_BY, $this->getId());

				SuspendedByFlagPeer::addSelectColumns($criteria);
				if (!isset($this->lastSuspendedByFlagCriteria) || !$this->lastSuspendedByFlagCriteria->equals($criteria)) {
					$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSuspendedByFlagCriteria = $criteria;
		return $this->collSuspendedByFlags;
	}

	
	public function countSuspendedByFlags($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSuspendedByFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SuspendedByFlagPeer::CONFIRMED_BY, $this->getId());

		return SuspendedByFlagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSuspendedByFlag(SuspendedByFlag $l)
	{
		$this->collSuspendedByFlags[] = $l;
		$l->setUser($this);
	}


	
	public function getSuspendedByFlagsJoinMember($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSuspendedByFlagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSuspendedByFlags === null) {
			if ($this->isNew()) {
				$this->collSuspendedByFlags = array();
			} else {

				$criteria->add(SuspendedByFlagPeer::CONFIRMED_BY, $this->getId());

				$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelectJoinMember($criteria, $con);
			}
		} else {
									
			$criteria->add(SuspendedByFlagPeer::CONFIRMED_BY, $this->getId());

			if (!isset($this->lastSuspendedByFlagCriteria) || !$this->lastSuspendedByFlagCriteria->equals($criteria)) {
				$this->collSuspendedByFlags = SuspendedByFlagPeer::doSelectJoinMember($criteria, $con);
			}
		}
		$this->lastSuspendedByFlagCriteria = $criteria;

		return $this->collSuspendedByFlags;
	}

	
	public function initPermissionss()
	{
		if ($this->collPermissionss === null) {
			$this->collPermissionss = array();
		}
	}

	
	public function getPermissionss($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BasePermissionsPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPermissionss === null) {
			if ($this->isNew()) {
			   $this->collPermissionss = array();
			} else {

				$criteria->add(PermissionsPeer::ID, $this->getId());

				PermissionsPeer::addSelectColumns($criteria);
				$this->collPermissionss = PermissionsPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PermissionsPeer::ID, $this->getId());

				PermissionsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPermissionsCriteria) || !$this->lastPermissionsCriteria->equals($criteria)) {
					$this->collPermissionss = PermissionsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPermissionsCriteria = $criteria;
		return $this->collPermissionss;
	}

	
	public function countPermissionss($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BasePermissionsPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PermissionsPeer::ID, $this->getId());

		return PermissionsPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addPermissions(Permissions $l)
	{
		$this->collPermissionss[] = $l;
		$l->setUser($this);
	}


	
	public function getPermissionssJoinGroups($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BasePermissionsPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPermissionss === null) {
			if ($this->isNew()) {
				$this->collPermissionss = array();
			} else {

				$criteria->add(PermissionsPeer::ID, $this->getId());

				$this->collPermissionss = PermissionsPeer::doSelectJoinGroups($criteria, $con);
			}
		} else {
									
			$criteria->add(PermissionsPeer::ID, $this->getId());

			if (!isset($this->lastPermissionsCriteria) || !$this->lastPermissionsCriteria->equals($criteria)) {
				$this->collPermissionss = PermissionsPeer::doSelectJoinGroups($criteria, $con);
			}
		}
		$this->lastPermissionsCriteria = $criteria;

		return $this->collPermissionss;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseUser:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseUser::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 