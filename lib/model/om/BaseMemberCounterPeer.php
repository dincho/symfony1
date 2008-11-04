<?php


abstract class BaseMemberCounterPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'member_counter';

	
	const CLASS_DEFAULT = 'lib.model.MemberCounter';

	
	const NUM_COLUMNS = 16;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'member_counter.ID';

	
	const CURRENT_FLAGS = 'member_counter.CURRENT_FLAGS';

	
	const TOTAL_FLAGS = 'member_counter.TOTAL_FLAGS';

	
	const SENT_FLAGS = 'member_counter.SENT_FLAGS';

	
	const SENT_WINKS = 'member_counter.SENT_WINKS';

	
	const RECEIVED_WINKS = 'member_counter.RECEIVED_WINKS';

	
	const READ_MESSAGES = 'member_counter.READ_MESSAGES';

	
	const SENT_MESSAGES = 'member_counter.SENT_MESSAGES';

	
	const RECEIVED_MESSAGES = 'member_counter.RECEIVED_MESSAGES';

	
	const REPLY_MESSAGES = 'member_counter.REPLY_MESSAGES';

	
	const UNSUSPENSIONS = 'member_counter.UNSUSPENSIONS';

	
	const ASSISTANT_CONTACTS = 'member_counter.ASSISTANT_CONTACTS';

	
	const PROFILE_VIEWS = 'member_counter.PROFILE_VIEWS';

	
	const MADE_PROFILE_VIEWS = 'member_counter.MADE_PROFILE_VIEWS';

	
	const HOTLIST = 'member_counter.HOTLIST';

	
	const ON_OTHERS_HOTLIST = 'member_counter.ON_OTHERS_HOTLIST';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CurrentFlags', 'TotalFlags', 'SentFlags', 'SentWinks', 'ReceivedWinks', 'ReadMessages', 'SentMessages', 'ReceivedMessages', 'ReplyMessages', 'Unsuspensions', 'AssistantContacts', 'ProfileViews', 'MadeProfileViews', 'Hotlist', 'OnOthersHotlist', ),
		BasePeer::TYPE_COLNAME => array (MemberCounterPeer::ID, MemberCounterPeer::CURRENT_FLAGS, MemberCounterPeer::TOTAL_FLAGS, MemberCounterPeer::SENT_FLAGS, MemberCounterPeer::SENT_WINKS, MemberCounterPeer::RECEIVED_WINKS, MemberCounterPeer::READ_MESSAGES, MemberCounterPeer::SENT_MESSAGES, MemberCounterPeer::RECEIVED_MESSAGES, MemberCounterPeer::REPLY_MESSAGES, MemberCounterPeer::UNSUSPENSIONS, MemberCounterPeer::ASSISTANT_CONTACTS, MemberCounterPeer::PROFILE_VIEWS, MemberCounterPeer::MADE_PROFILE_VIEWS, MemberCounterPeer::HOTLIST, MemberCounterPeer::ON_OTHERS_HOTLIST, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'current_flags', 'total_flags', 'sent_flags', 'sent_winks', 'received_winks', 'read_messages', 'sent_messages', 'received_messages', 'reply_messages', 'unsuspensions', 'assistant_contacts', 'profile_views', 'made_profile_views', 'hotlist', 'on_others_hotlist', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CurrentFlags' => 1, 'TotalFlags' => 2, 'SentFlags' => 3, 'SentWinks' => 4, 'ReceivedWinks' => 5, 'ReadMessages' => 6, 'SentMessages' => 7, 'ReceivedMessages' => 8, 'ReplyMessages' => 9, 'Unsuspensions' => 10, 'AssistantContacts' => 11, 'ProfileViews' => 12, 'MadeProfileViews' => 13, 'Hotlist' => 14, 'OnOthersHotlist' => 15, ),
		BasePeer::TYPE_COLNAME => array (MemberCounterPeer::ID => 0, MemberCounterPeer::CURRENT_FLAGS => 1, MemberCounterPeer::TOTAL_FLAGS => 2, MemberCounterPeer::SENT_FLAGS => 3, MemberCounterPeer::SENT_WINKS => 4, MemberCounterPeer::RECEIVED_WINKS => 5, MemberCounterPeer::READ_MESSAGES => 6, MemberCounterPeer::SENT_MESSAGES => 7, MemberCounterPeer::RECEIVED_MESSAGES => 8, MemberCounterPeer::REPLY_MESSAGES => 9, MemberCounterPeer::UNSUSPENSIONS => 10, MemberCounterPeer::ASSISTANT_CONTACTS => 11, MemberCounterPeer::PROFILE_VIEWS => 12, MemberCounterPeer::MADE_PROFILE_VIEWS => 13, MemberCounterPeer::HOTLIST => 14, MemberCounterPeer::ON_OTHERS_HOTLIST => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'current_flags' => 1, 'total_flags' => 2, 'sent_flags' => 3, 'sent_winks' => 4, 'received_winks' => 5, 'read_messages' => 6, 'sent_messages' => 7, 'received_messages' => 8, 'reply_messages' => 9, 'unsuspensions' => 10, 'assistant_contacts' => 11, 'profile_views' => 12, 'made_profile_views' => 13, 'hotlist' => 14, 'on_others_hotlist' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MemberCounterMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MemberCounterMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MemberCounterPeer::getTableMap();
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
		return str_replace(MemberCounterPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MemberCounterPeer::ID);

		$criteria->addSelectColumn(MemberCounterPeer::CURRENT_FLAGS);

		$criteria->addSelectColumn(MemberCounterPeer::TOTAL_FLAGS);

		$criteria->addSelectColumn(MemberCounterPeer::SENT_FLAGS);

		$criteria->addSelectColumn(MemberCounterPeer::SENT_WINKS);

		$criteria->addSelectColumn(MemberCounterPeer::RECEIVED_WINKS);

		$criteria->addSelectColumn(MemberCounterPeer::READ_MESSAGES);

		$criteria->addSelectColumn(MemberCounterPeer::SENT_MESSAGES);

		$criteria->addSelectColumn(MemberCounterPeer::RECEIVED_MESSAGES);

		$criteria->addSelectColumn(MemberCounterPeer::REPLY_MESSAGES);

		$criteria->addSelectColumn(MemberCounterPeer::UNSUSPENSIONS);

		$criteria->addSelectColumn(MemberCounterPeer::ASSISTANT_CONTACTS);

		$criteria->addSelectColumn(MemberCounterPeer::PROFILE_VIEWS);

		$criteria->addSelectColumn(MemberCounterPeer::MADE_PROFILE_VIEWS);

		$criteria->addSelectColumn(MemberCounterPeer::HOTLIST);

		$criteria->addSelectColumn(MemberCounterPeer::ON_OTHERS_HOTLIST);

	}

	const COUNT = 'COUNT(member_counter.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT member_counter.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberCounterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberCounterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MemberCounterPeer::doSelectRS($criteria, $con);
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
		$objects = MemberCounterPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MemberCounterPeer::populateObjects(MemberCounterPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberCounterPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseMemberCounterPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MemberCounterPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MemberCounterPeer::getOMClass();
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
		return MemberCounterPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberCounterPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberCounterPeer', $values, $con);
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

		$criteria->remove(MemberCounterPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseMemberCounterPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberCounterPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberCounterPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberCounterPeer', $values, $con);
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
			$comparison = $criteria->getComparison(MemberCounterPeer::ID);
			$selectCriteria->add(MemberCounterPeer::ID, $criteria->remove(MemberCounterPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMemberCounterPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberCounterPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(MemberCounterPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MemberCounterPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MemberCounter) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MemberCounterPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MemberCounter $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MemberCounterPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MemberCounterPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MemberCounterPeer::DATABASE_NAME, MemberCounterPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MemberCounterPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(MemberCounterPeer::DATABASE_NAME);

		$criteria->add(MemberCounterPeer::ID, $pk);


		$v = MemberCounterPeer::doSelect($criteria, $con);

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
			$criteria->add(MemberCounterPeer::ID, $pks, Criteria::IN);
			$objs = MemberCounterPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMemberCounterPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MemberCounterMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MemberCounterMapBuilder');
}
