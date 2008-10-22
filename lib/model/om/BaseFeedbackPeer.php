<?php


abstract class BaseFeedbackPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'feedback';

	
	const CLASS_DEFAULT = 'lib.model.Feedback';

	
	const NUM_COLUMNS = 12;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'feedback.ID';

	
	const MAILBOX = 'feedback.MAILBOX';

	
	const MEMBER_ID = 'feedback.MEMBER_ID';

	
	const MAIL_FROM = 'feedback.MAIL_FROM';

	
	const NAME_FROM = 'feedback.NAME_FROM';

	
	const MAIL_TO = 'feedback.MAIL_TO';

	
	const NAME_TO = 'feedback.NAME_TO';

	
	const BCC = 'feedback.BCC';

	
	const SUBJECT = 'feedback.SUBJECT';

	
	const BODY = 'feedback.BODY';

	
	const IS_READ = 'feedback.IS_READ';

	
	const CREATED_AT = 'feedback.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Mailbox', 'MemberId', 'MailFrom', 'NameFrom', 'MailTo', 'NameTo', 'Bcc', 'Subject', 'Body', 'IsRead', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (FeedbackPeer::ID, FeedbackPeer::MAILBOX, FeedbackPeer::MEMBER_ID, FeedbackPeer::MAIL_FROM, FeedbackPeer::NAME_FROM, FeedbackPeer::MAIL_TO, FeedbackPeer::NAME_TO, FeedbackPeer::BCC, FeedbackPeer::SUBJECT, FeedbackPeer::BODY, FeedbackPeer::IS_READ, FeedbackPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'mailbox', 'member_id', 'mail_from', 'name_from', 'mail_to', 'name_to', 'bcc', 'subject', 'body', 'is_read', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Mailbox' => 1, 'MemberId' => 2, 'MailFrom' => 3, 'NameFrom' => 4, 'MailTo' => 5, 'NameTo' => 6, 'Bcc' => 7, 'Subject' => 8, 'Body' => 9, 'IsRead' => 10, 'CreatedAt' => 11, ),
		BasePeer::TYPE_COLNAME => array (FeedbackPeer::ID => 0, FeedbackPeer::MAILBOX => 1, FeedbackPeer::MEMBER_ID => 2, FeedbackPeer::MAIL_FROM => 3, FeedbackPeer::NAME_FROM => 4, FeedbackPeer::MAIL_TO => 5, FeedbackPeer::NAME_TO => 6, FeedbackPeer::BCC => 7, FeedbackPeer::SUBJECT => 8, FeedbackPeer::BODY => 9, FeedbackPeer::IS_READ => 10, FeedbackPeer::CREATED_AT => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'mailbox' => 1, 'member_id' => 2, 'mail_from' => 3, 'name_from' => 4, 'mail_to' => 5, 'name_to' => 6, 'bcc' => 7, 'subject' => 8, 'body' => 9, 'is_read' => 10, 'created_at' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/FeedbackMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.FeedbackMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = FeedbackPeer::getTableMap();
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
		return str_replace(FeedbackPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(FeedbackPeer::ID);

		$criteria->addSelectColumn(FeedbackPeer::MAILBOX);

		$criteria->addSelectColumn(FeedbackPeer::MEMBER_ID);

		$criteria->addSelectColumn(FeedbackPeer::MAIL_FROM);

		$criteria->addSelectColumn(FeedbackPeer::NAME_FROM);

		$criteria->addSelectColumn(FeedbackPeer::MAIL_TO);

		$criteria->addSelectColumn(FeedbackPeer::NAME_TO);

		$criteria->addSelectColumn(FeedbackPeer::BCC);

		$criteria->addSelectColumn(FeedbackPeer::SUBJECT);

		$criteria->addSelectColumn(FeedbackPeer::BODY);

		$criteria->addSelectColumn(FeedbackPeer::IS_READ);

		$criteria->addSelectColumn(FeedbackPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(feedback.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT feedback.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(FeedbackPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(FeedbackPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = FeedbackPeer::doSelectRS($criteria, $con);
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
		$objects = FeedbackPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return FeedbackPeer::populateObjects(FeedbackPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseFeedbackPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			FeedbackPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = FeedbackPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinMember(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(FeedbackPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(FeedbackPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID);

		$rs = FeedbackPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinMember(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		FeedbackPeer::addSelectColumns($c);
		$startcol = (FeedbackPeer::NUM_COLUMNS - FeedbackPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberPeer::addSelectColumns($c);

		$c->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = FeedbackPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMember(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addFeedback($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initFeedbacks();
				$obj2->addFeedback($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(FeedbackPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(FeedbackPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID);

		$rs = FeedbackPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		FeedbackPeer::addSelectColumns($c);
		$startcol2 = (FeedbackPeer::NUM_COLUMNS - FeedbackPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

		$c->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = FeedbackPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = MemberPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMember(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addFeedback($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initFeedbacks();
				$obj2->addFeedback($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return FeedbackPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseFeedbackPeer', $values, $con);
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

		$criteria->remove(FeedbackPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseFeedbackPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseFeedbackPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseFeedbackPeer', $values, $con);
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
			$comparison = $criteria->getComparison(FeedbackPeer::ID);
			$selectCriteria->add(FeedbackPeer::ID, $criteria->remove(FeedbackPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseFeedbackPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseFeedbackPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(FeedbackPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(FeedbackPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Feedback) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(FeedbackPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Feedback $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(FeedbackPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(FeedbackPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(FeedbackPeer::DATABASE_NAME, FeedbackPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = FeedbackPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(FeedbackPeer::DATABASE_NAME);

		$criteria->add(FeedbackPeer::ID, $pk);


		$v = FeedbackPeer::doSelect($criteria, $con);

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
			$criteria->add(FeedbackPeer::ID, $pks, Criteria::IN);
			$objs = FeedbackPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseFeedbackPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/FeedbackMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.FeedbackMapBuilder');
}
