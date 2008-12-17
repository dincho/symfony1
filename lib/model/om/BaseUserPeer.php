<?php


abstract class BaseUserPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'user';

	
	const CLASS_DEFAULT = 'lib.model.User';

	
	const NUM_COLUMNS = 30;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'user.ID';

	
	const USERNAME = 'user.USERNAME';

	
	const PASSWORD = 'user.PASSWORD';

	
	const FIRST_NAME = 'user.FIRST_NAME';

	
	const LAST_NAME = 'user.LAST_NAME';

	
	const EMAIL = 'user.EMAIL';

	
	const PHONE = 'user.PHONE';

	
	const DASHBOARD_MOD = 'user.DASHBOARD_MOD';

	
	const DASHBOARD_MOD_TYPE = 'user.DASHBOARD_MOD_TYPE';

	
	const MEMBERS_MOD = 'user.MEMBERS_MOD';

	
	const MEMBERS_MOD_TYPE = 'user.MEMBERS_MOD_TYPE';

	
	const CONTENT_MOD = 'user.CONTENT_MOD';

	
	const CONTENT_MOD_TYPE = 'user.CONTENT_MOD_TYPE';

	
	const SUBSCRIPTIONS_MOD = 'user.SUBSCRIPTIONS_MOD';

	
	const SUBSCRIPTIONS_MOD_TYPE = 'user.SUBSCRIPTIONS_MOD_TYPE';

	
	const MESSAGES_MOD = 'user.MESSAGES_MOD';

	
	const MESSAGES_MOD_TYPE = 'user.MESSAGES_MOD_TYPE';

	
	const FLAGS_MOD = 'user.FLAGS_MOD';

	
	const FLAGS_MOD_TYPE = 'user.FLAGS_MOD_TYPE';

	
	const IMBRA_MOD = 'user.IMBRA_MOD';

	
	const IMBRA_MOD_TYPE = 'user.IMBRA_MOD_TYPE';

	
	const REPORTS_MOD = 'user.REPORTS_MOD';

	
	const REPORTS_MOD_TYPE = 'user.REPORTS_MOD_TYPE';

	
	const USERS_MOD = 'user.USERS_MOD';

	
	const USERS_MOD_TYPE = 'user.USERS_MOD_TYPE';

	
	const MUST_CHANGE_PWD = 'user.MUST_CHANGE_PWD';

	
	const IS_SUPERUSER = 'user.IS_SUPERUSER';

	
	const IS_ENABLED = 'user.IS_ENABLED';

	
	const LAST_LOGIN = 'user.LAST_LOGIN';

	
	const CREATED_AT = 'user.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Password', 'FirstName', 'LastName', 'Email', 'Phone', 'DashboardMod', 'DashboardModType', 'MembersMod', 'MembersModType', 'ContentMod', 'ContentModType', 'SubscriptionsMod', 'SubscriptionsModType', 'MessagesMod', 'MessagesModType', 'FlagsMod', 'FlagsModType', 'ImbraMod', 'ImbraModType', 'ReportsMod', 'ReportsModType', 'UsersMod', 'UsersModType', 'MustChangePwd', 'IsSuperuser', 'IsEnabled', 'LastLogin', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (UserPeer::ID, UserPeer::USERNAME, UserPeer::PASSWORD, UserPeer::FIRST_NAME, UserPeer::LAST_NAME, UserPeer::EMAIL, UserPeer::PHONE, UserPeer::DASHBOARD_MOD, UserPeer::DASHBOARD_MOD_TYPE, UserPeer::MEMBERS_MOD, UserPeer::MEMBERS_MOD_TYPE, UserPeer::CONTENT_MOD, UserPeer::CONTENT_MOD_TYPE, UserPeer::SUBSCRIPTIONS_MOD, UserPeer::SUBSCRIPTIONS_MOD_TYPE, UserPeer::MESSAGES_MOD, UserPeer::MESSAGES_MOD_TYPE, UserPeer::FLAGS_MOD, UserPeer::FLAGS_MOD_TYPE, UserPeer::IMBRA_MOD, UserPeer::IMBRA_MOD_TYPE, UserPeer::REPORTS_MOD, UserPeer::REPORTS_MOD_TYPE, UserPeer::USERS_MOD, UserPeer::USERS_MOD_TYPE, UserPeer::MUST_CHANGE_PWD, UserPeer::IS_SUPERUSER, UserPeer::IS_ENABLED, UserPeer::LAST_LOGIN, UserPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'password', 'first_name', 'last_name', 'email', 'phone', 'dashboard_mod', 'dashboard_mod_type', 'members_mod', 'members_mod_type', 'content_mod', 'content_mod_type', 'subscriptions_mod', 'subscriptions_mod_type', 'messages_mod', 'messages_mod_type', 'flags_mod', 'flags_mod_type', 'imbra_mod', 'imbra_mod_type', 'reports_mod', 'reports_mod_type', 'users_mod', 'users_mod_type', 'must_change_pwd', 'is_superuser', 'is_enabled', 'last_login', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Password' => 2, 'FirstName' => 3, 'LastName' => 4, 'Email' => 5, 'Phone' => 6, 'DashboardMod' => 7, 'DashboardModType' => 8, 'MembersMod' => 9, 'MembersModType' => 10, 'ContentMod' => 11, 'ContentModType' => 12, 'SubscriptionsMod' => 13, 'SubscriptionsModType' => 14, 'MessagesMod' => 15, 'MessagesModType' => 16, 'FlagsMod' => 17, 'FlagsModType' => 18, 'ImbraMod' => 19, 'ImbraModType' => 20, 'ReportsMod' => 21, 'ReportsModType' => 22, 'UsersMod' => 23, 'UsersModType' => 24, 'MustChangePwd' => 25, 'IsSuperuser' => 26, 'IsEnabled' => 27, 'LastLogin' => 28, 'CreatedAt' => 29, ),
		BasePeer::TYPE_COLNAME => array (UserPeer::ID => 0, UserPeer::USERNAME => 1, UserPeer::PASSWORD => 2, UserPeer::FIRST_NAME => 3, UserPeer::LAST_NAME => 4, UserPeer::EMAIL => 5, UserPeer::PHONE => 6, UserPeer::DASHBOARD_MOD => 7, UserPeer::DASHBOARD_MOD_TYPE => 8, UserPeer::MEMBERS_MOD => 9, UserPeer::MEMBERS_MOD_TYPE => 10, UserPeer::CONTENT_MOD => 11, UserPeer::CONTENT_MOD_TYPE => 12, UserPeer::SUBSCRIPTIONS_MOD => 13, UserPeer::SUBSCRIPTIONS_MOD_TYPE => 14, UserPeer::MESSAGES_MOD => 15, UserPeer::MESSAGES_MOD_TYPE => 16, UserPeer::FLAGS_MOD => 17, UserPeer::FLAGS_MOD_TYPE => 18, UserPeer::IMBRA_MOD => 19, UserPeer::IMBRA_MOD_TYPE => 20, UserPeer::REPORTS_MOD => 21, UserPeer::REPORTS_MOD_TYPE => 22, UserPeer::USERS_MOD => 23, UserPeer::USERS_MOD_TYPE => 24, UserPeer::MUST_CHANGE_PWD => 25, UserPeer::IS_SUPERUSER => 26, UserPeer::IS_ENABLED => 27, UserPeer::LAST_LOGIN => 28, UserPeer::CREATED_AT => 29, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'password' => 2, 'first_name' => 3, 'last_name' => 4, 'email' => 5, 'phone' => 6, 'dashboard_mod' => 7, 'dashboard_mod_type' => 8, 'members_mod' => 9, 'members_mod_type' => 10, 'content_mod' => 11, 'content_mod_type' => 12, 'subscriptions_mod' => 13, 'subscriptions_mod_type' => 14, 'messages_mod' => 15, 'messages_mod_type' => 16, 'flags_mod' => 17, 'flags_mod_type' => 18, 'imbra_mod' => 19, 'imbra_mod_type' => 20, 'reports_mod' => 21, 'reports_mod_type' => 22, 'users_mod' => 23, 'users_mod_type' => 24, 'must_change_pwd' => 25, 'is_superuser' => 26, 'is_enabled' => 27, 'last_login' => 28, 'created_at' => 29, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/UserMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.UserMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = UserPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(UserPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(UserPeer::ID);

		$criteria->addSelectColumn(UserPeer::USERNAME);

		$criteria->addSelectColumn(UserPeer::PASSWORD);

		$criteria->addSelectColumn(UserPeer::FIRST_NAME);

		$criteria->addSelectColumn(UserPeer::LAST_NAME);

		$criteria->addSelectColumn(UserPeer::EMAIL);

		$criteria->addSelectColumn(UserPeer::PHONE);

		$criteria->addSelectColumn(UserPeer::DASHBOARD_MOD);

		$criteria->addSelectColumn(UserPeer::DASHBOARD_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::MEMBERS_MOD);

		$criteria->addSelectColumn(UserPeer::MEMBERS_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::CONTENT_MOD);

		$criteria->addSelectColumn(UserPeer::CONTENT_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::SUBSCRIPTIONS_MOD);

		$criteria->addSelectColumn(UserPeer::SUBSCRIPTIONS_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::MESSAGES_MOD);

		$criteria->addSelectColumn(UserPeer::MESSAGES_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::FLAGS_MOD);

		$criteria->addSelectColumn(UserPeer::FLAGS_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::IMBRA_MOD);

		$criteria->addSelectColumn(UserPeer::IMBRA_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::REPORTS_MOD);

		$criteria->addSelectColumn(UserPeer::REPORTS_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::USERS_MOD);

		$criteria->addSelectColumn(UserPeer::USERS_MOD_TYPE);

		$criteria->addSelectColumn(UserPeer::MUST_CHANGE_PWD);

		$criteria->addSelectColumn(UserPeer::IS_SUPERUSER);

		$criteria->addSelectColumn(UserPeer::IS_ENABLED);

		$criteria->addSelectColumn(UserPeer::LAST_LOGIN);

		$criteria->addSelectColumn(UserPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(user.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT user.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(UserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = UserPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = UserPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return UserPeer::populateObjects(UserPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseUserPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseUserPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			UserPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = UserPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return UserPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseUserPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseUserPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(UserPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseUserPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseUserPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseUserPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseUserPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(UserPeer::ID);
			$selectCriteria->add(UserPeer::ID, $criteria->remove(UserPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseUserPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseUserPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(UserPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof User) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(UserPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(User $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(UserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(UserPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(UserPeer::DATABASE_NAME, UserPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = UserPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $pk);


		$v = UserPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(UserPeer::ID, $pks, Criteria::IN);
			$objs = UserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseUserPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/UserMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.UserMapBuilder');
}
