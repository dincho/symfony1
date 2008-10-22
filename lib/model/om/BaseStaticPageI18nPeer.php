<?php


abstract class BaseStaticPageI18nPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'static_page_i18n';

	
	const CLASS_DEFAULT = 'lib.model.StaticPageI18n';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const LINK_NAME = 'static_page_i18n.LINK_NAME';

	
	const TITLE = 'static_page_i18n.TITLE';

	
	const KEYWORDS = 'static_page_i18n.KEYWORDS';

	
	const DESCRIPTION = 'static_page_i18n.DESCRIPTION';

	
	const CONTENT = 'static_page_i18n.CONTENT';

	
	const ID = 'static_page_i18n.ID';

	
	const CULTURE = 'static_page_i18n.CULTURE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('LinkName', 'Title', 'Keywords', 'Description', 'Content', 'Id', 'Culture', ),
		BasePeer::TYPE_COLNAME => array (StaticPageI18nPeer::LINK_NAME, StaticPageI18nPeer::TITLE, StaticPageI18nPeer::KEYWORDS, StaticPageI18nPeer::DESCRIPTION, StaticPageI18nPeer::CONTENT, StaticPageI18nPeer::ID, StaticPageI18nPeer::CULTURE, ),
		BasePeer::TYPE_FIELDNAME => array ('link_name', 'title', 'keywords', 'description', 'content', 'id', 'culture', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('LinkName' => 0, 'Title' => 1, 'Keywords' => 2, 'Description' => 3, 'Content' => 4, 'Id' => 5, 'Culture' => 6, ),
		BasePeer::TYPE_COLNAME => array (StaticPageI18nPeer::LINK_NAME => 0, StaticPageI18nPeer::TITLE => 1, StaticPageI18nPeer::KEYWORDS => 2, StaticPageI18nPeer::DESCRIPTION => 3, StaticPageI18nPeer::CONTENT => 4, StaticPageI18nPeer::ID => 5, StaticPageI18nPeer::CULTURE => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('link_name' => 0, 'title' => 1, 'keywords' => 2, 'description' => 3, 'content' => 4, 'id' => 5, 'culture' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/StaticPageI18nMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.StaticPageI18nMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = StaticPageI18nPeer::getTableMap();
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
		return str_replace(StaticPageI18nPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(StaticPageI18nPeer::LINK_NAME);

		$criteria->addSelectColumn(StaticPageI18nPeer::TITLE);

		$criteria->addSelectColumn(StaticPageI18nPeer::KEYWORDS);

		$criteria->addSelectColumn(StaticPageI18nPeer::DESCRIPTION);

		$criteria->addSelectColumn(StaticPageI18nPeer::CONTENT);

		$criteria->addSelectColumn(StaticPageI18nPeer::ID);

		$criteria->addSelectColumn(StaticPageI18nPeer::CULTURE);

	}

	const COUNT = 'COUNT(static_page_i18n.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT static_page_i18n.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(StaticPageI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(StaticPageI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = StaticPageI18nPeer::doSelectRS($criteria, $con);
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
		$objects = StaticPageI18nPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return StaticPageI18nPeer::populateObjects(StaticPageI18nPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPageI18nPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseStaticPageI18nPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			StaticPageI18nPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = StaticPageI18nPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinStaticPage(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(StaticPageI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(StaticPageI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(StaticPageI18nPeer::ID, StaticPagePeer::ID);

		$rs = StaticPageI18nPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinStaticPage(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		StaticPageI18nPeer::addSelectColumns($c);
		$startcol = (StaticPageI18nPeer::NUM_COLUMNS - StaticPageI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		StaticPagePeer::addSelectColumns($c);

		$c->addJoin(StaticPageI18nPeer::ID, StaticPagePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = StaticPageI18nPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = StaticPagePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getStaticPage(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addStaticPageI18n($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initStaticPageI18ns();
				$obj2->addStaticPageI18n($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(StaticPageI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(StaticPageI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(StaticPageI18nPeer::ID, StaticPagePeer::ID);

		$rs = StaticPageI18nPeer::doSelectRS($criteria, $con);
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

		StaticPageI18nPeer::addSelectColumns($c);
		$startcol2 = (StaticPageI18nPeer::NUM_COLUMNS - StaticPageI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		StaticPagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + StaticPagePeer::NUM_COLUMNS;

		$c->addJoin(StaticPageI18nPeer::ID, StaticPagePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = StaticPageI18nPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = StaticPagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getStaticPage(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addStaticPageI18n($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initStaticPageI18ns();
				$obj2->addStaticPageI18n($obj1);
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
		return StaticPageI18nPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPageI18nPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseStaticPageI18nPeer', $values, $con);
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


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseStaticPageI18nPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseStaticPageI18nPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseStaticPageI18nPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseStaticPageI18nPeer', $values, $con);
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
			$comparison = $criteria->getComparison(StaticPageI18nPeer::ID);
			$selectCriteria->add(StaticPageI18nPeer::ID, $criteria->remove(StaticPageI18nPeer::ID), $comparison);

			$comparison = $criteria->getComparison(StaticPageI18nPeer::CULTURE);
			$selectCriteria->add(StaticPageI18nPeer::CULTURE, $criteria->remove(StaticPageI18nPeer::CULTURE), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseStaticPageI18nPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseStaticPageI18nPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(StaticPageI18nPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(StaticPageI18nPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof StaticPageI18n) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
												if(count($values) == count($values, COUNT_RECURSIVE))
			{
								$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
			}

			$criteria->add(StaticPageI18nPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(StaticPageI18nPeer::CULTURE, $vals[1], Criteria::IN);
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

	
	public static function doValidate(StaticPageI18n $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(StaticPageI18nPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(StaticPageI18nPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(StaticPageI18nPeer::DATABASE_NAME, StaticPageI18nPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = StaticPageI18nPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $culture, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(StaticPageI18nPeer::ID, $id);
		$criteria->add(StaticPageI18nPeer::CULTURE, $culture);
		$v = StaticPageI18nPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseStaticPageI18nPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/StaticPageI18nMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.StaticPageI18nMapBuilder');
}
