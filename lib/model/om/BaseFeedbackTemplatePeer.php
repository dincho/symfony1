<?php


abstract class BaseFeedbackTemplatePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'feedback_template';

	
	const CLASS_DEFAULT = 'lib.model.FeedbackTemplate';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'feedback_template.ID';

	
	const NAME = 'feedback_template.NAME';

	
	const MAIL_FROM = 'feedback_template.MAIL_FROM';

	
	const REPLY_TO = 'feedback_template.REPLY_TO';

	
	const BCC = 'feedback_template.BCC';

	
	const SUBJECT = 'feedback_template.SUBJECT';

	
	const BODY = 'feedback_template.BODY';

	
	const FOOTER = 'feedback_template.FOOTER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'MailFrom', 'ReplyTo', 'Bcc', 'Subject', 'Body', 'Footer', ),
		BasePeer::TYPE_COLNAME => array (FeedbackTemplatePeer::ID, FeedbackTemplatePeer::NAME, FeedbackTemplatePeer::MAIL_FROM, FeedbackTemplatePeer::REPLY_TO, FeedbackTemplatePeer::BCC, FeedbackTemplatePeer::SUBJECT, FeedbackTemplatePeer::BODY, FeedbackTemplatePeer::FOOTER, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'mail_from', 'reply_to', 'bcc', 'subject', 'body', 'footer', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'MailFrom' => 2, 'ReplyTo' => 3, 'Bcc' => 4, 'Subject' => 5, 'Body' => 6, 'Footer' => 7, ),
		BasePeer::TYPE_COLNAME => array (FeedbackTemplatePeer::ID => 0, FeedbackTemplatePeer::NAME => 1, FeedbackTemplatePeer::MAIL_FROM => 2, FeedbackTemplatePeer::REPLY_TO => 3, FeedbackTemplatePeer::BCC => 4, FeedbackTemplatePeer::SUBJECT => 5, FeedbackTemplatePeer::BODY => 6, FeedbackTemplatePeer::FOOTER => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'mail_from' => 2, 'reply_to' => 3, 'bcc' => 4, 'subject' => 5, 'body' => 6, 'footer' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/FeedbackTemplateMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.FeedbackTemplateMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = FeedbackTemplatePeer::getTableMap();
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
		return str_replace(FeedbackTemplatePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(FeedbackTemplatePeer::ID);

		$criteria->addSelectColumn(FeedbackTemplatePeer::NAME);

		$criteria->addSelectColumn(FeedbackTemplatePeer::MAIL_FROM);

		$criteria->addSelectColumn(FeedbackTemplatePeer::REPLY_TO);

		$criteria->addSelectColumn(FeedbackTemplatePeer::BCC);

		$criteria->addSelectColumn(FeedbackTemplatePeer::SUBJECT);

		$criteria->addSelectColumn(FeedbackTemplatePeer::BODY);

		$criteria->addSelectColumn(FeedbackTemplatePeer::FOOTER);

	}

	const COUNT = 'COUNT(feedback_template.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT feedback_template.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(FeedbackTemplatePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(FeedbackTemplatePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = FeedbackTemplatePeer::doSelectRS($criteria, $con);
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
		$objects = FeedbackTemplatePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return FeedbackTemplatePeer::populateObjects(FeedbackTemplatePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackTemplatePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseFeedbackTemplatePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			FeedbackTemplatePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = FeedbackTemplatePeer::getOMClass();
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
		return FeedbackTemplatePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackTemplatePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseFeedbackTemplatePeer', $values, $con);
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

		$criteria->remove(FeedbackTemplatePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseFeedbackTemplatePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseFeedbackTemplatePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseFeedbackTemplatePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseFeedbackTemplatePeer', $values, $con);
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
			$comparison = $criteria->getComparison(FeedbackTemplatePeer::ID);
			$selectCriteria->add(FeedbackTemplatePeer::ID, $criteria->remove(FeedbackTemplatePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseFeedbackTemplatePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseFeedbackTemplatePeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(FeedbackTemplatePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(FeedbackTemplatePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof FeedbackTemplate) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(FeedbackTemplatePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(FeedbackTemplate $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(FeedbackTemplatePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(FeedbackTemplatePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(FeedbackTemplatePeer::DATABASE_NAME, FeedbackTemplatePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = FeedbackTemplatePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(FeedbackTemplatePeer::DATABASE_NAME);

		$criteria->add(FeedbackTemplatePeer::ID, $pk);


		$v = FeedbackTemplatePeer::doSelect($criteria, $con);

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
			$criteria->add(FeedbackTemplatePeer::ID, $pks, Criteria::IN);
			$objs = FeedbackTemplatePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseFeedbackTemplatePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/FeedbackTemplateMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.FeedbackTemplateMapBuilder');
}
