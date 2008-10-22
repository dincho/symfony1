<?php


abstract class BaseImbraReplyTemplatePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'imbra_reply_template';

	
	const CLASS_DEFAULT = 'lib.model.ImbraReplyTemplate';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'imbra_reply_template.ID';

	
	const TITLE = 'imbra_reply_template.TITLE';

	
	const SUBJECT = 'imbra_reply_template.SUBJECT';

	
	const BODY = 'imbra_reply_template.BODY';

	
	const MAIL_FROM = 'imbra_reply_template.MAIL_FROM';

	
	const REPLY_TO = 'imbra_reply_template.REPLY_TO';

	
	const BCC = 'imbra_reply_template.BCC';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Title', 'Subject', 'Body', 'MailFrom', 'ReplyTo', 'Bcc', ),
		BasePeer::TYPE_COLNAME => array (ImbraReplyTemplatePeer::ID, ImbraReplyTemplatePeer::TITLE, ImbraReplyTemplatePeer::SUBJECT, ImbraReplyTemplatePeer::BODY, ImbraReplyTemplatePeer::MAIL_FROM, ImbraReplyTemplatePeer::REPLY_TO, ImbraReplyTemplatePeer::BCC, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'title', 'subject', 'body', 'mail_from', 'reply_to', 'bcc', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Title' => 1, 'Subject' => 2, 'Body' => 3, 'MailFrom' => 4, 'ReplyTo' => 5, 'Bcc' => 6, ),
		BasePeer::TYPE_COLNAME => array (ImbraReplyTemplatePeer::ID => 0, ImbraReplyTemplatePeer::TITLE => 1, ImbraReplyTemplatePeer::SUBJECT => 2, ImbraReplyTemplatePeer::BODY => 3, ImbraReplyTemplatePeer::MAIL_FROM => 4, ImbraReplyTemplatePeer::REPLY_TO => 5, ImbraReplyTemplatePeer::BCC => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'title' => 1, 'subject' => 2, 'body' => 3, 'mail_from' => 4, 'reply_to' => 5, 'bcc' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ImbraReplyTemplateMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ImbraReplyTemplateMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ImbraReplyTemplatePeer::getTableMap();
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
		return str_replace(ImbraReplyTemplatePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::ID);

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::TITLE);

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::SUBJECT);

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::BODY);

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::MAIL_FROM);

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::REPLY_TO);

		$criteria->addSelectColumn(ImbraReplyTemplatePeer::BCC);

	}

	const COUNT = 'COUNT(imbra_reply_template.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT imbra_reply_template.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ImbraReplyTemplatePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ImbraReplyTemplatePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ImbraReplyTemplatePeer::doSelectRS($criteria, $con);
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
		$objects = ImbraReplyTemplatePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ImbraReplyTemplatePeer::populateObjects(ImbraReplyTemplatePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraReplyTemplatePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseImbraReplyTemplatePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ImbraReplyTemplatePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ImbraReplyTemplatePeer::getOMClass();
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
		return ImbraReplyTemplatePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraReplyTemplatePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseImbraReplyTemplatePeer', $values, $con);
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

		$criteria->remove(ImbraReplyTemplatePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseImbraReplyTemplatePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseImbraReplyTemplatePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraReplyTemplatePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseImbraReplyTemplatePeer', $values, $con);
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
			$comparison = $criteria->getComparison(ImbraReplyTemplatePeer::ID);
			$selectCriteria->add(ImbraReplyTemplatePeer::ID, $criteria->remove(ImbraReplyTemplatePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseImbraReplyTemplatePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseImbraReplyTemplatePeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(ImbraReplyTemplatePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ImbraReplyTemplatePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ImbraReplyTemplate) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ImbraReplyTemplatePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ImbraReplyTemplate $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ImbraReplyTemplatePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ImbraReplyTemplatePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ImbraReplyTemplatePeer::DATABASE_NAME, ImbraReplyTemplatePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ImbraReplyTemplatePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ImbraReplyTemplatePeer::DATABASE_NAME);

		$criteria->add(ImbraReplyTemplatePeer::ID, $pk);


		$v = ImbraReplyTemplatePeer::doSelect($criteria, $con);

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
			$criteria->add(ImbraReplyTemplatePeer::ID, $pks, Criteria::IN);
			$objs = ImbraReplyTemplatePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseImbraReplyTemplatePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ImbraReplyTemplateMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ImbraReplyTemplateMapBuilder');
}
