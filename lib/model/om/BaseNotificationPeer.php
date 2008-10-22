<?php


abstract class BaseNotificationPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'notification';

	
	const CLASS_DEFAULT = 'lib.model.Notification';

	
	const NUM_COLUMNS = 13;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'notification.ID';

	
	const NAME = 'notification.NAME';

	
	const SEND_FROM = 'notification.SEND_FROM';

	
	const SEND_TO = 'notification.SEND_TO';

	
	const REPLY_TO = 'notification.REPLY_TO';

	
	const BCC = 'notification.BCC';

	
	const TRIGGER_NAME = 'notification.TRIGGER_NAME';

	
	const SUBJECT = 'notification.SUBJECT';

	
	const BODY = 'notification.BODY';

	
	const IS_ACTIVE = 'notification.IS_ACTIVE';

	
	const TO_ADMINS = 'notification.TO_ADMINS';

	
	const DAYS = 'notification.DAYS';

	
	const WHN = 'notification.WHN';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'SendFrom', 'SendTo', 'ReplyTo', 'Bcc', 'TriggerName', 'Subject', 'Body', 'IsActive', 'ToAdmins', 'Days', 'Whn', ),
		BasePeer::TYPE_COLNAME => array (NotificationPeer::ID, NotificationPeer::NAME, NotificationPeer::SEND_FROM, NotificationPeer::SEND_TO, NotificationPeer::REPLY_TO, NotificationPeer::BCC, NotificationPeer::TRIGGER_NAME, NotificationPeer::SUBJECT, NotificationPeer::BODY, NotificationPeer::IS_ACTIVE, NotificationPeer::TO_ADMINS, NotificationPeer::DAYS, NotificationPeer::WHN, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'send_from', 'send_to', 'reply_to', 'bcc', 'trigger_name', 'subject', 'body', 'is_active', 'to_admins', 'days', 'whn', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'SendFrom' => 2, 'SendTo' => 3, 'ReplyTo' => 4, 'Bcc' => 5, 'TriggerName' => 6, 'Subject' => 7, 'Body' => 8, 'IsActive' => 9, 'ToAdmins' => 10, 'Days' => 11, 'Whn' => 12, ),
		BasePeer::TYPE_COLNAME => array (NotificationPeer::ID => 0, NotificationPeer::NAME => 1, NotificationPeer::SEND_FROM => 2, NotificationPeer::SEND_TO => 3, NotificationPeer::REPLY_TO => 4, NotificationPeer::BCC => 5, NotificationPeer::TRIGGER_NAME => 6, NotificationPeer::SUBJECT => 7, NotificationPeer::BODY => 8, NotificationPeer::IS_ACTIVE => 9, NotificationPeer::TO_ADMINS => 10, NotificationPeer::DAYS => 11, NotificationPeer::WHN => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'send_from' => 2, 'send_to' => 3, 'reply_to' => 4, 'bcc' => 5, 'trigger_name' => 6, 'subject' => 7, 'body' => 8, 'is_active' => 9, 'to_admins' => 10, 'days' => 11, 'whn' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/NotificationMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.NotificationMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = NotificationPeer::getTableMap();
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
		return str_replace(NotificationPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(NotificationPeer::ID);

		$criteria->addSelectColumn(NotificationPeer::NAME);

		$criteria->addSelectColumn(NotificationPeer::SEND_FROM);

		$criteria->addSelectColumn(NotificationPeer::SEND_TO);

		$criteria->addSelectColumn(NotificationPeer::REPLY_TO);

		$criteria->addSelectColumn(NotificationPeer::BCC);

		$criteria->addSelectColumn(NotificationPeer::TRIGGER_NAME);

		$criteria->addSelectColumn(NotificationPeer::SUBJECT);

		$criteria->addSelectColumn(NotificationPeer::BODY);

		$criteria->addSelectColumn(NotificationPeer::IS_ACTIVE);

		$criteria->addSelectColumn(NotificationPeer::TO_ADMINS);

		$criteria->addSelectColumn(NotificationPeer::DAYS);

		$criteria->addSelectColumn(NotificationPeer::WHN);

	}

	const COUNT = 'COUNT(notification.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT notification.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NotificationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NotificationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = NotificationPeer::doSelectRS($criteria, $con);
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
		$objects = NotificationPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return NotificationPeer::populateObjects(NotificationPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNotificationPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseNotificationPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			NotificationPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = NotificationPeer::getOMClass();
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
		return NotificationPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNotificationPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseNotificationPeer', $values, $con);
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

		$criteria->remove(NotificationPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseNotificationPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseNotificationPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNotificationPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseNotificationPeer', $values, $con);
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
			$comparison = $criteria->getComparison(NotificationPeer::ID);
			$selectCriteria->add(NotificationPeer::ID, $criteria->remove(NotificationPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseNotificationPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseNotificationPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(NotificationPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(NotificationPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Notification) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(NotificationPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Notification $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(NotificationPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(NotificationPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(NotificationPeer::DATABASE_NAME, NotificationPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = NotificationPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(NotificationPeer::DATABASE_NAME);

		$criteria->add(NotificationPeer::ID, $pk);


		$v = NotificationPeer::doSelect($criteria, $con);

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
			$criteria->add(NotificationPeer::ID, $pks, Criteria::IN);
			$objs = NotificationPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseNotificationPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/NotificationMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.NotificationMapBuilder');
}
