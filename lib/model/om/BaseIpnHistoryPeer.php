<?php


abstract class BaseIpnHistoryPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ipn_history';

	
	const CLASS_DEFAULT = 'lib.model.IpnHistory';

	
	const NUM_COLUMNS = 11;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ipn_history.ID';

	
	const PARAMETERS = 'ipn_history.PARAMETERS';

	
	const REQUEST_IP = 'ipn_history.REQUEST_IP';

	
	const TXN_TYPE = 'ipn_history.TXN_TYPE';

	
	const TXN_ID = 'ipn_history.TXN_ID';

	
	const SUBSCR_ID = 'ipn_history.SUBSCR_ID';

	
	const PAYMENT_STATUS = 'ipn_history.PAYMENT_STATUS';

	
	const PAYPAL_RESPONSE = 'ipn_history.PAYPAL_RESPONSE';

	
	const IS_RENEWAL = 'ipn_history.IS_RENEWAL';

	
	const MEMBER_SUBSCR_ID = 'ipn_history.MEMBER_SUBSCR_ID';

	
	const CREATED_AT = 'ipn_history.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Parameters', 'RequestIp', 'TxnType', 'TxnId', 'SubscrId', 'PaymentStatus', 'PaypalResponse', 'IsRenewal', 'MemberSubscrId', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (IpnHistoryPeer::ID, IpnHistoryPeer::PARAMETERS, IpnHistoryPeer::REQUEST_IP, IpnHistoryPeer::TXN_TYPE, IpnHistoryPeer::TXN_ID, IpnHistoryPeer::SUBSCR_ID, IpnHistoryPeer::PAYMENT_STATUS, IpnHistoryPeer::PAYPAL_RESPONSE, IpnHistoryPeer::IS_RENEWAL, IpnHistoryPeer::MEMBER_SUBSCR_ID, IpnHistoryPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'parameters', 'request_ip', 'txn_type', 'txn_id', 'subscr_id', 'payment_status', 'paypal_response', 'is_renewal', 'member_subscr_id', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Parameters' => 1, 'RequestIp' => 2, 'TxnType' => 3, 'TxnId' => 4, 'SubscrId' => 5, 'PaymentStatus' => 6, 'PaypalResponse' => 7, 'IsRenewal' => 8, 'MemberSubscrId' => 9, 'CreatedAt' => 10, ),
		BasePeer::TYPE_COLNAME => array (IpnHistoryPeer::ID => 0, IpnHistoryPeer::PARAMETERS => 1, IpnHistoryPeer::REQUEST_IP => 2, IpnHistoryPeer::TXN_TYPE => 3, IpnHistoryPeer::TXN_ID => 4, IpnHistoryPeer::SUBSCR_ID => 5, IpnHistoryPeer::PAYMENT_STATUS => 6, IpnHistoryPeer::PAYPAL_RESPONSE => 7, IpnHistoryPeer::IS_RENEWAL => 8, IpnHistoryPeer::MEMBER_SUBSCR_ID => 9, IpnHistoryPeer::CREATED_AT => 10, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'parameters' => 1, 'request_ip' => 2, 'txn_type' => 3, 'txn_id' => 4, 'subscr_id' => 5, 'payment_status' => 6, 'paypal_response' => 7, 'is_renewal' => 8, 'member_subscr_id' => 9, 'created_at' => 10, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/IpnHistoryMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.IpnHistoryMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = IpnHistoryPeer::getTableMap();
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
		return str_replace(IpnHistoryPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(IpnHistoryPeer::ID);

		$criteria->addSelectColumn(IpnHistoryPeer::PARAMETERS);

		$criteria->addSelectColumn(IpnHistoryPeer::REQUEST_IP);

		$criteria->addSelectColumn(IpnHistoryPeer::TXN_TYPE);

		$criteria->addSelectColumn(IpnHistoryPeer::TXN_ID);

		$criteria->addSelectColumn(IpnHistoryPeer::SUBSCR_ID);

		$criteria->addSelectColumn(IpnHistoryPeer::PAYMENT_STATUS);

		$criteria->addSelectColumn(IpnHistoryPeer::PAYPAL_RESPONSE);

		$criteria->addSelectColumn(IpnHistoryPeer::IS_RENEWAL);

		$criteria->addSelectColumn(IpnHistoryPeer::MEMBER_SUBSCR_ID);

		$criteria->addSelectColumn(IpnHistoryPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(ipn_history.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ipn_history.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(IpnHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(IpnHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = IpnHistoryPeer::doSelectRS($criteria, $con);
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
		$objects = IpnHistoryPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return IpnHistoryPeer::populateObjects(IpnHistoryPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseIpnHistoryPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseIpnHistoryPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			IpnHistoryPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = IpnHistoryPeer::getOMClass();
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
		return IpnHistoryPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseIpnHistoryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseIpnHistoryPeer', $values, $con);
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

		$criteria->remove(IpnHistoryPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseIpnHistoryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseIpnHistoryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseIpnHistoryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseIpnHistoryPeer', $values, $con);
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
			$comparison = $criteria->getComparison(IpnHistoryPeer::ID);
			$selectCriteria->add(IpnHistoryPeer::ID, $criteria->remove(IpnHistoryPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseIpnHistoryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseIpnHistoryPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(IpnHistoryPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(IpnHistoryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof IpnHistory) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(IpnHistoryPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(IpnHistory $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(IpnHistoryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(IpnHistoryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(IpnHistoryPeer::DATABASE_NAME, IpnHistoryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = IpnHistoryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(IpnHistoryPeer::DATABASE_NAME);

		$criteria->add(IpnHistoryPeer::ID, $pk);


		$v = IpnHistoryPeer::doSelect($criteria, $con);

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
			$criteria->add(IpnHistoryPeer::ID, $pks, Criteria::IN);
			$objs = IpnHistoryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseIpnHistoryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/IpnHistoryMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.IpnHistoryMapBuilder');
}
