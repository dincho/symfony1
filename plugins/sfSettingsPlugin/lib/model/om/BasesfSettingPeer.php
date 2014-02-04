<?php


abstract class BasesfSettingPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_setting';

	
	const CLASS_DEFAULT = 'plugins.sfSettingsPlugin.lib.model.sfSetting';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const CAT_ID = 'sf_setting.CAT_ID';

	
	const ENV = 'sf_setting.ENV';

	
	const NAME = 'sf_setting.NAME';

	
	const VALUE = 'sf_setting.VALUE';

	
	const VAR_TYPE = 'sf_setting.VAR_TYPE';

	
	const DESCRIPTION = 'sf_setting.DESCRIPTION';

	
	const CREATED_USER_ID = 'sf_setting.CREATED_USER_ID';

	
	const UPDATED_USER_ID = 'sf_setting.UPDATED_USER_ID';

	
	const CREATED_AT = 'sf_setting.CREATED_AT';

	
	const UPDATED_AT = 'sf_setting.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CatId', 'Env', 'Name', 'Value', 'VarType', 'Description', 'CreatedUserId', 'UpdatedUserId', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (sfSettingPeer::CAT_ID, sfSettingPeer::ENV, sfSettingPeer::NAME, sfSettingPeer::VALUE, sfSettingPeer::VAR_TYPE, sfSettingPeer::DESCRIPTION, sfSettingPeer::CREATED_USER_ID, sfSettingPeer::UPDATED_USER_ID, sfSettingPeer::CREATED_AT, sfSettingPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('cat_id', 'env', 'name', 'value', 'var_type', 'description', 'created_user_id', 'updated_user_id', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CatId' => 0, 'Env' => 1, 'Name' => 2, 'Value' => 3, 'VarType' => 4, 'Description' => 5, 'CreatedUserId' => 6, 'UpdatedUserId' => 7, 'CreatedAt' => 8, 'UpdatedAt' => 9, ),
		BasePeer::TYPE_COLNAME => array (sfSettingPeer::CAT_ID => 0, sfSettingPeer::ENV => 1, sfSettingPeer::NAME => 2, sfSettingPeer::VALUE => 3, sfSettingPeer::VAR_TYPE => 4, sfSettingPeer::DESCRIPTION => 5, sfSettingPeer::CREATED_USER_ID => 6, sfSettingPeer::UPDATED_USER_ID => 7, sfSettingPeer::CREATED_AT => 8, sfSettingPeer::UPDATED_AT => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('cat_id' => 0, 'env' => 1, 'name' => 2, 'value' => 3, 'var_type' => 4, 'description' => 5, 'created_user_id' => 6, 'updated_user_id' => 7, 'created_at' => 8, 'updated_at' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfSettingsPlugin/lib/model/map/sfSettingMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfSettingsPlugin.lib.model.map.sfSettingMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfSettingPeer::getTableMap();
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
		return str_replace(sfSettingPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfSettingPeer::CAT_ID);

		$criteria->addSelectColumn(sfSettingPeer::ENV);

		$criteria->addSelectColumn(sfSettingPeer::NAME);

		$criteria->addSelectColumn(sfSettingPeer::VALUE);

		$criteria->addSelectColumn(sfSettingPeer::VAR_TYPE);

		$criteria->addSelectColumn(sfSettingPeer::DESCRIPTION);

		$criteria->addSelectColumn(sfSettingPeer::CREATED_USER_ID);

		$criteria->addSelectColumn(sfSettingPeer::UPDATED_USER_ID);

		$criteria->addSelectColumn(sfSettingPeer::CREATED_AT);

		$criteria->addSelectColumn(sfSettingPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(sf_setting.CAT_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_setting.CAT_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSettingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSettingPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfSettingPeer::doSelectRS($criteria, $con);
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
		$objects = sfSettingPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfSettingPeer::populateObjects(sfSettingPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSettingPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfSettingPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfSettingPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfSettingPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinCatalogue(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSettingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSettingPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfSettingPeer::CAT_ID, CataloguePeer::CAT_ID);

		$rs = sfSettingPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinCatalogue(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfSettingPeer::addSelectColumns($c);
		$startcol = (sfSettingPeer::NUM_COLUMNS - sfSettingPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		CataloguePeer::addSelectColumns($c);

		$c->addJoin(sfSettingPeer::CAT_ID, CataloguePeer::CAT_ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfSettingPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CataloguePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getCatalogue(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfSetting($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfSettings();
				$obj2->addsfSetting($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSettingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSettingPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfSettingPeer::CAT_ID, CataloguePeer::CAT_ID);

		$rs = sfSettingPeer::doSelectRS($criteria, $con);
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

		sfSettingPeer::addSelectColumns($c);
		$startcol2 = (sfSettingPeer::NUM_COLUMNS - sfSettingPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CataloguePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CataloguePeer::NUM_COLUMNS;

		$c->addJoin(sfSettingPeer::CAT_ID, CataloguePeer::CAT_ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfSettingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = CataloguePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCatalogue(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfSetting($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfSettings();
				$obj2->addsfSetting($obj1);
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
		return sfSettingPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSettingPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfSettingPeer', $values, $con);
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

		
    foreach (sfMixer::getCallables('BasesfSettingPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfSettingPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSettingPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfSettingPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfSettingPeer::CAT_ID);
			$selectCriteria->add(sfSettingPeer::CAT_ID, $criteria->remove(sfSettingPeer::CAT_ID), $comparison);

			$comparison = $criteria->getComparison(sfSettingPeer::ENV);
			$selectCriteria->add(sfSettingPeer::ENV, $criteria->remove(sfSettingPeer::ENV), $comparison);

			$comparison = $criteria->getComparison(sfSettingPeer::NAME);
			$selectCriteria->add(sfSettingPeer::NAME, $criteria->remove(sfSettingPeer::NAME), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfSettingPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfSettingPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfSettingPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfSettingPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfSetting) {

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
				$vals[2][] = $value[2];
			}

			$criteria->add(sfSettingPeer::CAT_ID, $vals[0], Criteria::IN);
			$criteria->add(sfSettingPeer::ENV, $vals[1], Criteria::IN);
			$criteria->add(sfSettingPeer::NAME, $vals[2], Criteria::IN);
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

	
	public static function doValidate(sfSetting $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfSettingPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfSettingPeer::TABLE_NAME);

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

		return BasePeer::doValidate(sfSettingPeer::DATABASE_NAME, sfSettingPeer::TABLE_NAME, $columns);
	}

	
	public static function retrieveByPK( $cat_id, $env, $name, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(sfSettingPeer::CAT_ID, $cat_id);
		$criteria->add(sfSettingPeer::ENV, $env);
		$criteria->add(sfSettingPeer::NAME, $name);
		$v = sfSettingPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BasesfSettingPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfSettingsPlugin/lib/model/map/sfSettingMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfSettingsPlugin.lib.model.map.sfSettingMapBuilder');
}
