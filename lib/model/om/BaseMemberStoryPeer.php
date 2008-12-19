<?php


abstract class BaseMemberStoryPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'member_story';

	
	const CLASS_DEFAULT = 'lib.model.MemberStory';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'member_story.ID';

	
	const CULTURE = 'member_story.CULTURE';

	
	const SLUG = 'member_story.SLUG';

	
	const SORT_ORDER = 'member_story.SORT_ORDER';

	
	const LINK_NAME = 'member_story.LINK_NAME';

	
	const TITLE = 'member_story.TITLE';

	
	const KEYWORDS = 'member_story.KEYWORDS';

	
	const DESCRIPTION = 'member_story.DESCRIPTION';

	
	const CONTENT = 'member_story.CONTENT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Culture', 'Slug', 'SortOrder', 'LinkName', 'Title', 'Keywords', 'Description', 'Content', ),
		BasePeer::TYPE_COLNAME => array (MemberStoryPeer::ID, MemberStoryPeer::CULTURE, MemberStoryPeer::SLUG, MemberStoryPeer::SORT_ORDER, MemberStoryPeer::LINK_NAME, MemberStoryPeer::TITLE, MemberStoryPeer::KEYWORDS, MemberStoryPeer::DESCRIPTION, MemberStoryPeer::CONTENT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'culture', 'slug', 'sort_order', 'link_name', 'title', 'keywords', 'description', 'content', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Culture' => 1, 'Slug' => 2, 'SortOrder' => 3, 'LinkName' => 4, 'Title' => 5, 'Keywords' => 6, 'Description' => 7, 'Content' => 8, ),
		BasePeer::TYPE_COLNAME => array (MemberStoryPeer::ID => 0, MemberStoryPeer::CULTURE => 1, MemberStoryPeer::SLUG => 2, MemberStoryPeer::SORT_ORDER => 3, MemberStoryPeer::LINK_NAME => 4, MemberStoryPeer::TITLE => 5, MemberStoryPeer::KEYWORDS => 6, MemberStoryPeer::DESCRIPTION => 7, MemberStoryPeer::CONTENT => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'culture' => 1, 'slug' => 2, 'sort_order' => 3, 'link_name' => 4, 'title' => 5, 'keywords' => 6, 'description' => 7, 'content' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MemberStoryMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MemberStoryMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MemberStoryPeer::getTableMap();
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
		return str_replace(MemberStoryPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MemberStoryPeer::ID);

		$criteria->addSelectColumn(MemberStoryPeer::CULTURE);

		$criteria->addSelectColumn(MemberStoryPeer::SLUG);

		$criteria->addSelectColumn(MemberStoryPeer::SORT_ORDER);

		$criteria->addSelectColumn(MemberStoryPeer::LINK_NAME);

		$criteria->addSelectColumn(MemberStoryPeer::TITLE);

		$criteria->addSelectColumn(MemberStoryPeer::KEYWORDS);

		$criteria->addSelectColumn(MemberStoryPeer::DESCRIPTION);

		$criteria->addSelectColumn(MemberStoryPeer::CONTENT);

	}

	const COUNT = 'COUNT(member_story.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT member_story.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberStoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberStoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MemberStoryPeer::doSelectRS($criteria, $con);
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
		$objects = MemberStoryPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MemberStoryPeer::populateObjects(MemberStoryPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStoryPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseMemberStoryPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MemberStoryPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MemberStoryPeer::getOMClass();
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
		return MemberStoryPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStoryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberStoryPeer', $values, $con);
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

		$criteria->remove(MemberStoryPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseMemberStoryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberStoryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStoryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberStoryPeer', $values, $con);
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
			$comparison = $criteria->getComparison(MemberStoryPeer::ID);
			$selectCriteria->add(MemberStoryPeer::ID, $criteria->remove(MemberStoryPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMemberStoryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberStoryPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(MemberStoryPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MemberStoryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MemberStory) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MemberStoryPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MemberStory $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MemberStoryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MemberStoryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MemberStoryPeer::DATABASE_NAME, MemberStoryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MemberStoryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(MemberStoryPeer::DATABASE_NAME);

		$criteria->add(MemberStoryPeer::ID, $pk);


		$v = MemberStoryPeer::doSelect($criteria, $con);

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
			$criteria->add(MemberStoryPeer::ID, $pks, Criteria::IN);
			$objs = MemberStoryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMemberStoryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MemberStoryMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MemberStoryMapBuilder');
}
