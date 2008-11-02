<?php


abstract class BaseDescQuestionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'desc_question';

	
	const CLASS_DEFAULT = 'lib.model.DescQuestion';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'desc_question.ID';

	
	const TITLE = 'desc_question.TITLE';

	
	const SEARCH_TITLE = 'desc_question.SEARCH_TITLE';

	
	const DESC_TITLE = 'desc_question.DESC_TITLE';

	
	const FACTOR_TITLE = 'desc_question.FACTOR_TITLE';

	
	const TYPE = 'desc_question.TYPE';

	
	const IS_REQUIRED = 'desc_question.IS_REQUIRED';

	
	const SELECT_GREATHER = 'desc_question.SELECT_GREATHER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Title', 'SearchTitle', 'DescTitle', 'FactorTitle', 'Type', 'IsRequired', 'SelectGreather', ),
		BasePeer::TYPE_COLNAME => array (DescQuestionPeer::ID, DescQuestionPeer::TITLE, DescQuestionPeer::SEARCH_TITLE, DescQuestionPeer::DESC_TITLE, DescQuestionPeer::FACTOR_TITLE, DescQuestionPeer::TYPE, DescQuestionPeer::IS_REQUIRED, DescQuestionPeer::SELECT_GREATHER, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'title', 'search_title', 'desc_title', 'factor_title', 'type', 'is_required', 'select_greather', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Title' => 1, 'SearchTitle' => 2, 'DescTitle' => 3, 'FactorTitle' => 4, 'Type' => 5, 'IsRequired' => 6, 'SelectGreather' => 7, ),
		BasePeer::TYPE_COLNAME => array (DescQuestionPeer::ID => 0, DescQuestionPeer::TITLE => 1, DescQuestionPeer::SEARCH_TITLE => 2, DescQuestionPeer::DESC_TITLE => 3, DescQuestionPeer::FACTOR_TITLE => 4, DescQuestionPeer::TYPE => 5, DescQuestionPeer::IS_REQUIRED => 6, DescQuestionPeer::SELECT_GREATHER => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'title' => 1, 'search_title' => 2, 'desc_title' => 3, 'factor_title' => 4, 'type' => 5, 'is_required' => 6, 'select_greather' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/DescQuestionMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.DescQuestionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = DescQuestionPeer::getTableMap();
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
		return str_replace(DescQuestionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(DescQuestionPeer::ID);

		$criteria->addSelectColumn(DescQuestionPeer::TITLE);

		$criteria->addSelectColumn(DescQuestionPeer::SEARCH_TITLE);

		$criteria->addSelectColumn(DescQuestionPeer::DESC_TITLE);

		$criteria->addSelectColumn(DescQuestionPeer::FACTOR_TITLE);

		$criteria->addSelectColumn(DescQuestionPeer::TYPE);

		$criteria->addSelectColumn(DescQuestionPeer::IS_REQUIRED);

		$criteria->addSelectColumn(DescQuestionPeer::SELECT_GREATHER);

	}

	const COUNT = 'COUNT(desc_question.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT desc_question.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DescQuestionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DescQuestionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DescQuestionPeer::doSelectRS($criteria, $con);
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
		$objects = DescQuestionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return DescQuestionPeer::populateObjects(DescQuestionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDescQuestionPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseDescQuestionPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			DescQuestionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = DescQuestionPeer::getOMClass();
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
		return DescQuestionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDescQuestionPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDescQuestionPeer', $values, $con);
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

		$criteria->remove(DescQuestionPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseDescQuestionPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseDescQuestionPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDescQuestionPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDescQuestionPeer', $values, $con);
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
			$comparison = $criteria->getComparison(DescQuestionPeer::ID);
			$selectCriteria->add(DescQuestionPeer::ID, $criteria->remove(DescQuestionPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseDescQuestionPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseDescQuestionPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(DescQuestionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(DescQuestionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof DescQuestion) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DescQuestionPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(DescQuestion $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DescQuestionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DescQuestionPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DescQuestionPeer::DATABASE_NAME, DescQuestionPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DescQuestionPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(DescQuestionPeer::DATABASE_NAME);

		$criteria->add(DescQuestionPeer::ID, $pk);


		$v = DescQuestionPeer::doSelect($criteria, $con);

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
			$criteria->add(DescQuestionPeer::ID, $pks, Criteria::IN);
			$objs = DescQuestionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseDescQuestionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/DescQuestionMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.DescQuestionMapBuilder');
}
