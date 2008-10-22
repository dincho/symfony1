<?php


abstract class BaseMemberStoryI18nPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'member_story_i18n';

	
	const CLASS_DEFAULT = 'lib.model.MemberStoryI18n';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const LINK_NAME = 'member_story_i18n.LINK_NAME';

	
	const TITLE = 'member_story_i18n.TITLE';

	
	const KEYWORDS = 'member_story_i18n.KEYWORDS';

	
	const DESCRIPTION = 'member_story_i18n.DESCRIPTION';

	
	const CONTENT = 'member_story_i18n.CONTENT';

	
	const ID = 'member_story_i18n.ID';

	
	const CULTURE = 'member_story_i18n.CULTURE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('LinkName', 'Title', 'Keywords', 'Description', 'Content', 'Id', 'Culture', ),
		BasePeer::TYPE_COLNAME => array (MemberStoryI18nPeer::LINK_NAME, MemberStoryI18nPeer::TITLE, MemberStoryI18nPeer::KEYWORDS, MemberStoryI18nPeer::DESCRIPTION, MemberStoryI18nPeer::CONTENT, MemberStoryI18nPeer::ID, MemberStoryI18nPeer::CULTURE, ),
		BasePeer::TYPE_FIELDNAME => array ('link_name', 'title', 'keywords', 'description', 'content', 'id', 'culture', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('LinkName' => 0, 'Title' => 1, 'Keywords' => 2, 'Description' => 3, 'Content' => 4, 'Id' => 5, 'Culture' => 6, ),
		BasePeer::TYPE_COLNAME => array (MemberStoryI18nPeer::LINK_NAME => 0, MemberStoryI18nPeer::TITLE => 1, MemberStoryI18nPeer::KEYWORDS => 2, MemberStoryI18nPeer::DESCRIPTION => 3, MemberStoryI18nPeer::CONTENT => 4, MemberStoryI18nPeer::ID => 5, MemberStoryI18nPeer::CULTURE => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('link_name' => 0, 'title' => 1, 'keywords' => 2, 'description' => 3, 'content' => 4, 'id' => 5, 'culture' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MemberStoryI18nMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MemberStoryI18nMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MemberStoryI18nPeer::getTableMap();
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
		return str_replace(MemberStoryI18nPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MemberStoryI18nPeer::LINK_NAME);

		$criteria->addSelectColumn(MemberStoryI18nPeer::TITLE);

		$criteria->addSelectColumn(MemberStoryI18nPeer::KEYWORDS);

		$criteria->addSelectColumn(MemberStoryI18nPeer::DESCRIPTION);

		$criteria->addSelectColumn(MemberStoryI18nPeer::CONTENT);

		$criteria->addSelectColumn(MemberStoryI18nPeer::ID);

		$criteria->addSelectColumn(MemberStoryI18nPeer::CULTURE);

	}

	const COUNT = 'COUNT(member_story_i18n.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT member_story_i18n.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberStoryI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberStoryI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MemberStoryI18nPeer::doSelectRS($criteria, $con);
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
		$objects = MemberStoryI18nPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MemberStoryI18nPeer::populateObjects(MemberStoryI18nPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStoryI18nPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseMemberStoryI18nPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MemberStoryI18nPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MemberStoryI18nPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinMemberStory(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberStoryI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberStoryI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberStoryI18nPeer::ID, MemberStoryPeer::ID);

		$rs = MemberStoryI18nPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinMemberStory(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberStoryI18nPeer::addSelectColumns($c);
		$startcol = (MemberStoryI18nPeer::NUM_COLUMNS - MemberStoryI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberStoryPeer::addSelectColumns($c);

		$c->addJoin(MemberStoryI18nPeer::ID, MemberStoryPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberStoryI18nPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMemberStory(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMemberStoryI18n($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMemberStoryI18ns();
				$obj2->addMemberStoryI18n($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberStoryI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberStoryI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberStoryI18nPeer::ID, MemberStoryPeer::ID);

		$rs = MemberStoryI18nPeer::doSelectRS($criteria, $con);
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

		MemberStoryI18nPeer::addSelectColumns($c);
		$startcol2 = (MemberStoryI18nPeer::NUM_COLUMNS - MemberStoryI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStoryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStoryPeer::NUM_COLUMNS;

		$c->addJoin(MemberStoryI18nPeer::ID, MemberStoryPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberStoryI18nPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = MemberStoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStory(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMemberStoryI18n($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initMemberStoryI18ns();
				$obj2->addMemberStoryI18n($obj1);
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
		return MemberStoryI18nPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStoryI18nPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberStoryI18nPeer', $values, $con);
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

		
    foreach (sfMixer::getCallables('BaseMemberStoryI18nPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberStoryI18nPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberStoryI18nPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberStoryI18nPeer', $values, $con);
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
			$comparison = $criteria->getComparison(MemberStoryI18nPeer::ID);
			$selectCriteria->add(MemberStoryI18nPeer::ID, $criteria->remove(MemberStoryI18nPeer::ID), $comparison);

			$comparison = $criteria->getComparison(MemberStoryI18nPeer::CULTURE);
			$selectCriteria->add(MemberStoryI18nPeer::CULTURE, $criteria->remove(MemberStoryI18nPeer::CULTURE), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMemberStoryI18nPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberStoryI18nPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(MemberStoryI18nPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MemberStoryI18nPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MemberStoryI18n) {

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

			$criteria->add(MemberStoryI18nPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(MemberStoryI18nPeer::CULTURE, $vals[1], Criteria::IN);
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

	
	public static function doValidate(MemberStoryI18n $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MemberStoryI18nPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MemberStoryI18nPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MemberStoryI18nPeer::DATABASE_NAME, MemberStoryI18nPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MemberStoryI18nPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
		$criteria->add(MemberStoryI18nPeer::ID, $id);
		$criteria->add(MemberStoryI18nPeer::CULTURE, $culture);
		$v = MemberStoryI18nPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseMemberStoryI18nPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MemberStoryI18nMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MemberStoryI18nMapBuilder');
}
