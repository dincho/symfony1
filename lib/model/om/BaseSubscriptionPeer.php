<?php


abstract class BaseSubscriptionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'subscription';

	
	const CLASS_DEFAULT = 'lib.model.Subscription';

	
	const NUM_COLUMNS = 28;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'subscription.ID';

	
	const TITLE = 'subscription.TITLE';

	
	const CAN_CREATE_PROFILE = 'subscription.CAN_CREATE_PROFILE';

	
	const CREATE_PROFILES = 'subscription.CREATE_PROFILES';

	
	const CAN_POST_PHOTO = 'subscription.CAN_POST_PHOTO';

	
	const POST_PHOTOS = 'subscription.POST_PHOTOS';

	
	const CAN_WINK = 'subscription.CAN_WINK';

	
	const WINKS = 'subscription.WINKS';

	
	const CAN_READ_MESSAGES = 'subscription.CAN_READ_MESSAGES';

	
	const READ_MESSAGES = 'subscription.READ_MESSAGES';

	
	const CAN_REPLY_MESSAGES = 'subscription.CAN_REPLY_MESSAGES';

	
	const REPLY_MESSAGES = 'subscription.REPLY_MESSAGES';

	
	const CAN_SEND_MESSAGES = 'subscription.CAN_SEND_MESSAGES';

	
	const SEND_MESSAGES = 'subscription.SEND_MESSAGES';

	
	const CAN_SEE_VIEWED = 'subscription.CAN_SEE_VIEWED';

	
	const SEE_VIEWED = 'subscription.SEE_VIEWED';

	
	const CAN_CONTACT_ASSISTANT = 'subscription.CAN_CONTACT_ASSISTANT';

	
	const CONTACT_ASSISTANT = 'subscription.CONTACT_ASSISTANT';

	
	const PRE_APPROVE = 'subscription.PRE_APPROVE';

	
	const AMOUNT = 'subscription.AMOUNT';

	
	const PERIOD = 'subscription.PERIOD';

	
	const PERIOD_TYPE = 'subscription.PERIOD_TYPE';

	
	const TRIAL1_AMOUNT = 'subscription.TRIAL1_AMOUNT';

	
	const TRIAL1_PERIOD = 'subscription.TRIAL1_PERIOD';

	
	const TRIAL1_PERIOD_TYPE = 'subscription.TRIAL1_PERIOD_TYPE';

	
	const TRIAL2_AMOUNT = 'subscription.TRIAL2_AMOUNT';

	
	const TRIAL2_PERIOD = 'subscription.TRIAL2_PERIOD';

	
	const TRIAL2_PERIOD_TYPE = 'subscription.TRIAL2_PERIOD_TYPE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Title', 'CanCreateProfile', 'CreateProfiles', 'CanPostPhoto', 'PostPhotos', 'CanWink', 'Winks', 'CanReadMessages', 'ReadMessages', 'CanReplyMessages', 'ReplyMessages', 'CanSendMessages', 'SendMessages', 'CanSeeViewed', 'SeeViewed', 'CanContactAssistant', 'ContactAssistant', 'PreApprove', 'Amount', 'Period', 'PeriodType', 'Trial1Amount', 'Trial1Period', 'Trial1PeriodType', 'Trial2Amount', 'Trial2Period', 'Trial2PeriodType', ),
		BasePeer::TYPE_COLNAME => array (SubscriptionPeer::ID, SubscriptionPeer::TITLE, SubscriptionPeer::CAN_CREATE_PROFILE, SubscriptionPeer::CREATE_PROFILES, SubscriptionPeer::CAN_POST_PHOTO, SubscriptionPeer::POST_PHOTOS, SubscriptionPeer::CAN_WINK, SubscriptionPeer::WINKS, SubscriptionPeer::CAN_READ_MESSAGES, SubscriptionPeer::READ_MESSAGES, SubscriptionPeer::CAN_REPLY_MESSAGES, SubscriptionPeer::REPLY_MESSAGES, SubscriptionPeer::CAN_SEND_MESSAGES, SubscriptionPeer::SEND_MESSAGES, SubscriptionPeer::CAN_SEE_VIEWED, SubscriptionPeer::SEE_VIEWED, SubscriptionPeer::CAN_CONTACT_ASSISTANT, SubscriptionPeer::CONTACT_ASSISTANT, SubscriptionPeer::PRE_APPROVE, SubscriptionPeer::AMOUNT, SubscriptionPeer::PERIOD, SubscriptionPeer::PERIOD_TYPE, SubscriptionPeer::TRIAL1_AMOUNT, SubscriptionPeer::TRIAL1_PERIOD, SubscriptionPeer::TRIAL1_PERIOD_TYPE, SubscriptionPeer::TRIAL2_AMOUNT, SubscriptionPeer::TRIAL2_PERIOD, SubscriptionPeer::TRIAL2_PERIOD_TYPE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'title', 'can_create_profile', 'create_profiles', 'can_post_photo', 'post_photos', 'can_wink', 'winks', 'can_read_messages', 'read_messages', 'can_reply_messages', 'reply_messages', 'can_send_messages', 'send_messages', 'can_see_viewed', 'see_viewed', 'can_contact_assistant', 'contact_assistant', 'pre_approve', 'amount', 'period', 'period_type', 'trial1_amount', 'trial1_period', 'trial1_period_type', 'trial2_amount', 'trial2_period', 'trial2_period_type', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Title' => 1, 'CanCreateProfile' => 2, 'CreateProfiles' => 3, 'CanPostPhoto' => 4, 'PostPhotos' => 5, 'CanWink' => 6, 'Winks' => 7, 'CanReadMessages' => 8, 'ReadMessages' => 9, 'CanReplyMessages' => 10, 'ReplyMessages' => 11, 'CanSendMessages' => 12, 'SendMessages' => 13, 'CanSeeViewed' => 14, 'SeeViewed' => 15, 'CanContactAssistant' => 16, 'ContactAssistant' => 17, 'PreApprove' => 18, 'Amount' => 19, 'Period' => 20, 'PeriodType' => 21, 'Trial1Amount' => 22, 'Trial1Period' => 23, 'Trial1PeriodType' => 24, 'Trial2Amount' => 25, 'Trial2Period' => 26, 'Trial2PeriodType' => 27, ),
		BasePeer::TYPE_COLNAME => array (SubscriptionPeer::ID => 0, SubscriptionPeer::TITLE => 1, SubscriptionPeer::CAN_CREATE_PROFILE => 2, SubscriptionPeer::CREATE_PROFILES => 3, SubscriptionPeer::CAN_POST_PHOTO => 4, SubscriptionPeer::POST_PHOTOS => 5, SubscriptionPeer::CAN_WINK => 6, SubscriptionPeer::WINKS => 7, SubscriptionPeer::CAN_READ_MESSAGES => 8, SubscriptionPeer::READ_MESSAGES => 9, SubscriptionPeer::CAN_REPLY_MESSAGES => 10, SubscriptionPeer::REPLY_MESSAGES => 11, SubscriptionPeer::CAN_SEND_MESSAGES => 12, SubscriptionPeer::SEND_MESSAGES => 13, SubscriptionPeer::CAN_SEE_VIEWED => 14, SubscriptionPeer::SEE_VIEWED => 15, SubscriptionPeer::CAN_CONTACT_ASSISTANT => 16, SubscriptionPeer::CONTACT_ASSISTANT => 17, SubscriptionPeer::PRE_APPROVE => 18, SubscriptionPeer::AMOUNT => 19, SubscriptionPeer::PERIOD => 20, SubscriptionPeer::PERIOD_TYPE => 21, SubscriptionPeer::TRIAL1_AMOUNT => 22, SubscriptionPeer::TRIAL1_PERIOD => 23, SubscriptionPeer::TRIAL1_PERIOD_TYPE => 24, SubscriptionPeer::TRIAL2_AMOUNT => 25, SubscriptionPeer::TRIAL2_PERIOD => 26, SubscriptionPeer::TRIAL2_PERIOD_TYPE => 27, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'title' => 1, 'can_create_profile' => 2, 'create_profiles' => 3, 'can_post_photo' => 4, 'post_photos' => 5, 'can_wink' => 6, 'winks' => 7, 'can_read_messages' => 8, 'read_messages' => 9, 'can_reply_messages' => 10, 'reply_messages' => 11, 'can_send_messages' => 12, 'send_messages' => 13, 'can_see_viewed' => 14, 'see_viewed' => 15, 'can_contact_assistant' => 16, 'contact_assistant' => 17, 'pre_approve' => 18, 'amount' => 19, 'period' => 20, 'period_type' => 21, 'trial1_amount' => 22, 'trial1_period' => 23, 'trial1_period_type' => 24, 'trial2_amount' => 25, 'trial2_period' => 26, 'trial2_period_type' => 27, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SubscriptionMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SubscriptionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SubscriptionPeer::getTableMap();
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
		return str_replace(SubscriptionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SubscriptionPeer::ID);

		$criteria->addSelectColumn(SubscriptionPeer::TITLE);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_CREATE_PROFILE);

		$criteria->addSelectColumn(SubscriptionPeer::CREATE_PROFILES);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_POST_PHOTO);

		$criteria->addSelectColumn(SubscriptionPeer::POST_PHOTOS);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_WINK);

		$criteria->addSelectColumn(SubscriptionPeer::WINKS);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_READ_MESSAGES);

		$criteria->addSelectColumn(SubscriptionPeer::READ_MESSAGES);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_REPLY_MESSAGES);

		$criteria->addSelectColumn(SubscriptionPeer::REPLY_MESSAGES);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_SEND_MESSAGES);

		$criteria->addSelectColumn(SubscriptionPeer::SEND_MESSAGES);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_SEE_VIEWED);

		$criteria->addSelectColumn(SubscriptionPeer::SEE_VIEWED);

		$criteria->addSelectColumn(SubscriptionPeer::CAN_CONTACT_ASSISTANT);

		$criteria->addSelectColumn(SubscriptionPeer::CONTACT_ASSISTANT);

		$criteria->addSelectColumn(SubscriptionPeer::PRE_APPROVE);

		$criteria->addSelectColumn(SubscriptionPeer::AMOUNT);

		$criteria->addSelectColumn(SubscriptionPeer::PERIOD);

		$criteria->addSelectColumn(SubscriptionPeer::PERIOD_TYPE);

		$criteria->addSelectColumn(SubscriptionPeer::TRIAL1_AMOUNT);

		$criteria->addSelectColumn(SubscriptionPeer::TRIAL1_PERIOD);

		$criteria->addSelectColumn(SubscriptionPeer::TRIAL1_PERIOD_TYPE);

		$criteria->addSelectColumn(SubscriptionPeer::TRIAL2_AMOUNT);

		$criteria->addSelectColumn(SubscriptionPeer::TRIAL2_PERIOD);

		$criteria->addSelectColumn(SubscriptionPeer::TRIAL2_PERIOD_TYPE);

	}

	const COUNT = 'COUNT(subscription.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT subscription.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SubscriptionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SubscriptionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SubscriptionPeer::doSelectRS($criteria, $con);
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
		$objects = SubscriptionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SubscriptionPeer::populateObjects(SubscriptionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubscriptionPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseSubscriptionPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SubscriptionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SubscriptionPeer::getOMClass();
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
		return SubscriptionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubscriptionPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSubscriptionPeer', $values, $con);
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

		$criteria->remove(SubscriptionPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseSubscriptionPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseSubscriptionPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubscriptionPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSubscriptionPeer', $values, $con);
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
			$comparison = $criteria->getComparison(SubscriptionPeer::ID);
			$selectCriteria->add(SubscriptionPeer::ID, $criteria->remove(SubscriptionPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseSubscriptionPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseSubscriptionPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(SubscriptionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SubscriptionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Subscription) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SubscriptionPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Subscription $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SubscriptionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SubscriptionPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(SubscriptionPeer::DATABASE_NAME, SubscriptionPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SubscriptionPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);

		$criteria->add(SubscriptionPeer::ID, $pk);


		$v = SubscriptionPeer::doSelect($criteria, $con);

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
			$criteria->add(SubscriptionPeer::ID, $pks, Criteria::IN);
			$objs = SubscriptionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSubscriptionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SubscriptionMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SubscriptionMapBuilder');
}
