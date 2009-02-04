<?php


abstract class BaseStockPhotoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'stock_photo';

	
	const CLASS_DEFAULT = 'lib.model.StockPhoto';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'stock_photo.ID';

	
	const FILE = 'stock_photo.FILE';

	
	const CROPPED = 'stock_photo.CROPPED';

	
	const GENDER = 'stock_photo.GENDER';

	
	const HOMEPAGES = 'stock_photo.HOMEPAGES';

	
	const HOMEPAGES_SET = 'stock_photo.HOMEPAGES_SET';

	
	const HOMEPAGES_POS = 'stock_photo.HOMEPAGES_POS';

	
	const ASSISTANTS = 'stock_photo.ASSISTANTS';

	
	const UPDATED_AT = 'stock_photo.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'File', 'Cropped', 'Gender', 'Homepages', 'HomepagesSet', 'HomepagesPos', 'Assistants', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (StockPhotoPeer::ID, StockPhotoPeer::FILE, StockPhotoPeer::CROPPED, StockPhotoPeer::GENDER, StockPhotoPeer::HOMEPAGES, StockPhotoPeer::HOMEPAGES_SET, StockPhotoPeer::HOMEPAGES_POS, StockPhotoPeer::ASSISTANTS, StockPhotoPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'file', 'cropped', 'gender', 'homepages', 'homepages_set', 'homepages_pos', 'assistants', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'File' => 1, 'Cropped' => 2, 'Gender' => 3, 'Homepages' => 4, 'HomepagesSet' => 5, 'HomepagesPos' => 6, 'Assistants' => 7, 'UpdatedAt' => 8, ),
		BasePeer::TYPE_COLNAME => array (StockPhotoPeer::ID => 0, StockPhotoPeer::FILE => 1, StockPhotoPeer::CROPPED => 2, StockPhotoPeer::GENDER => 3, StockPhotoPeer::HOMEPAGES => 4, StockPhotoPeer::HOMEPAGES_SET => 5, StockPhotoPeer::HOMEPAGES_POS => 6, StockPhotoPeer::ASSISTANTS => 7, StockPhotoPeer::UPDATED_AT => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'file' => 1, 'cropped' => 2, 'gender' => 3, 'homepages' => 4, 'homepages_set' => 5, 'homepages_pos' => 6, 'assistants' => 7, 'updated_at' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/StockPhotoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.StockPhotoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = StockPhotoPeer::getTableMap();
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
		return str_replace(StockPhotoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(StockPhotoPeer::ID);

		$criteria->addSelectColumn(StockPhotoPeer::FILE);

		$criteria->addSelectColumn(StockPhotoPeer::CROPPED);

		$criteria->addSelectColumn(StockPhotoPeer::GENDER);

		$criteria->addSelectColumn(StockPhotoPeer::HOMEPAGES);

		$criteria->addSelectColumn(StockPhotoPeer::HOMEPAGES_SET);

		$criteria->addSelectColumn(StockPhotoPeer::HOMEPAGES_POS);

		$criteria->addSelectColumn(StockPhotoPeer::ASSISTANTS);

		$criteria->addSelectColumn(StockPhotoPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(stock_photo.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT stock_photo.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(StockPhotoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(StockPhotoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = StockPhotoPeer::doSelectRS($criteria, $con);
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
		$objects = StockPhotoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return StockPhotoPeer::populateObjects(StockPhotoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseStockPhotoPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseStockPhotoPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			StockPhotoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = StockPhotoPeer::getOMClass();
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
		return StockPhotoPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseStockPhotoPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseStockPhotoPeer', $values, $con);
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

		$criteria->remove(StockPhotoPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseStockPhotoPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseStockPhotoPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseStockPhotoPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseStockPhotoPeer', $values, $con);
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
			$comparison = $criteria->getComparison(StockPhotoPeer::ID);
			$selectCriteria->add(StockPhotoPeer::ID, $criteria->remove(StockPhotoPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseStockPhotoPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseStockPhotoPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(StockPhotoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(StockPhotoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof StockPhoto) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(StockPhotoPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(StockPhoto $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(StockPhotoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(StockPhotoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(StockPhotoPeer::DATABASE_NAME, StockPhotoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = StockPhotoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(StockPhotoPeer::DATABASE_NAME);

		$criteria->add(StockPhotoPeer::ID, $pk);


		$v = StockPhotoPeer::doSelect($criteria, $con);

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
			$criteria->add(StockPhotoPeer::ID, $pks, Criteria::IN);
			$objs = StockPhotoPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseStockPhotoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/StockPhotoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.StockPhotoMapBuilder');
}
