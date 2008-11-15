<?php


abstract class BaseSearchCritDescPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'search_crit_desc';

	
	const CLASS_DEFAULT = 'lib.model.SearchCritDesc';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'search_crit_desc.ID';

	
	const MEMBER_ID = 'search_crit_desc.MEMBER_ID';

	
	const DESC_QUESTION_ID = 'search_crit_desc.DESC_QUESTION_ID';

	
	const DESC_ANSWERS = 'search_crit_desc.DESC_ANSWERS';

	
	const MATCH_WEIGHT = 'search_crit_desc.MATCH_WEIGHT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'MemberId', 'DescQuestionId', 'DescAnswers', 'MatchWeight', ),
		BasePeer::TYPE_COLNAME => array (SearchCritDescPeer::ID, SearchCritDescPeer::MEMBER_ID, SearchCritDescPeer::DESC_QUESTION_ID, SearchCritDescPeer::DESC_ANSWERS, SearchCritDescPeer::MATCH_WEIGHT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'member_id', 'desc_question_id', 'desc_answers', 'match_weight', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'MemberId' => 1, 'DescQuestionId' => 2, 'DescAnswers' => 3, 'MatchWeight' => 4, ),
		BasePeer::TYPE_COLNAME => array (SearchCritDescPeer::ID => 0, SearchCritDescPeer::MEMBER_ID => 1, SearchCritDescPeer::DESC_QUESTION_ID => 2, SearchCritDescPeer::DESC_ANSWERS => 3, SearchCritDescPeer::MATCH_WEIGHT => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'member_id' => 1, 'desc_question_id' => 2, 'desc_answers' => 3, 'match_weight' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SearchCritDescMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SearchCritDescMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SearchCritDescPeer::getTableMap();
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
		return str_replace(SearchCritDescPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SearchCritDescPeer::ID);

		$criteria->addSelectColumn(SearchCritDescPeer::MEMBER_ID);

		$criteria->addSelectColumn(SearchCritDescPeer::DESC_QUESTION_ID);

		$criteria->addSelectColumn(SearchCritDescPeer::DESC_ANSWERS);

		$criteria->addSelectColumn(SearchCritDescPeer::MATCH_WEIGHT);

	}

	const COUNT = 'COUNT(search_crit_desc.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT search_crit_desc.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SearchCritDescPeer::doSelectRS($criteria, $con);
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
		$objects = SearchCritDescPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SearchCritDescPeer::populateObjects(SearchCritDescPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCritDescPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseSearchCritDescPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SearchCritDescPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SearchCritDescPeer::getOMClass();
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
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SearchCritDescPeer::MEMBER_ID, MemberPeer::ID);

		$rs = SearchCritDescPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinDescQuestion(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SearchCritDescPeer::DESC_QUESTION_ID, DescQuestionPeer::ID);

		$rs = SearchCritDescPeer::doSelectRS($criteria, $con);
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

		SearchCritDescPeer::addSelectColumns($c);
		$startcol = (SearchCritDescPeer::NUM_COLUMNS - SearchCritDescPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberPeer::addSelectColumns($c);

		$c->addJoin(SearchCritDescPeer::MEMBER_ID, MemberPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SearchCritDescPeer::getOMClass();

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
										$temp_obj2->addSearchCritDesc($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initSearchCritDescs();
				$obj2->addSearchCritDesc($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinDescQuestion(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SearchCritDescPeer::addSelectColumns($c);
		$startcol = (SearchCritDescPeer::NUM_COLUMNS - SearchCritDescPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DescQuestionPeer::addSelectColumns($c);

		$c->addJoin(SearchCritDescPeer::DESC_QUESTION_ID, DescQuestionPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SearchCritDescPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DescQuestionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDescQuestion(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addSearchCritDesc($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initSearchCritDescs();
				$obj2->addSearchCritDesc($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SearchCritDescPeer::MEMBER_ID, MemberPeer::ID);

		$criteria->addJoin(SearchCritDescPeer::DESC_QUESTION_ID, DescQuestionPeer::ID);

		$rs = SearchCritDescPeer::doSelectRS($criteria, $con);
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

		SearchCritDescPeer::addSelectColumns($c);
		$startcol2 = (SearchCritDescPeer::NUM_COLUMNS - SearchCritDescPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

		DescQuestionPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DescQuestionPeer::NUM_COLUMNS;

		$c->addJoin(SearchCritDescPeer::MEMBER_ID, MemberPeer::ID);

		$c->addJoin(SearchCritDescPeer::DESC_QUESTION_ID, DescQuestionPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SearchCritDescPeer::getOMClass();


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
					$temp_obj2->addSearchCritDesc($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initSearchCritDescs();
				$obj2->addSearchCritDesc($obj1);
			}


					
			$omClass = DescQuestionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDescQuestion(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addSearchCritDesc($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initSearchCritDescs();
				$obj3->addSearchCritDesc($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptMember(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SearchCritDescPeer::DESC_QUESTION_ID, DescQuestionPeer::ID);

		$rs = SearchCritDescPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptDescQuestion(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchCritDescPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SearchCritDescPeer::MEMBER_ID, MemberPeer::ID);

		$rs = SearchCritDescPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptMember(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SearchCritDescPeer::addSelectColumns($c);
		$startcol2 = (SearchCritDescPeer::NUM_COLUMNS - SearchCritDescPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DescQuestionPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DescQuestionPeer::NUM_COLUMNS;

		$c->addJoin(SearchCritDescPeer::DESC_QUESTION_ID, DescQuestionPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SearchCritDescPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DescQuestionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDescQuestion(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSearchCritDesc($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initSearchCritDescs();
				$obj2->addSearchCritDesc($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptDescQuestion(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SearchCritDescPeer::addSelectColumns($c);
		$startcol2 = (SearchCritDescPeer::NUM_COLUMNS - SearchCritDescPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

		$c->addJoin(SearchCritDescPeer::MEMBER_ID, MemberPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SearchCritDescPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMember(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSearchCritDesc($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initSearchCritDescs();
				$obj2->addSearchCritDesc($obj1);
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
		return SearchCritDescPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCritDescPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSearchCritDescPeer', $values, $con);
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

		$criteria->remove(SearchCritDescPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseSearchCritDescPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseSearchCritDescPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSearchCritDescPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSearchCritDescPeer', $values, $con);
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
			$comparison = $criteria->getComparison(SearchCritDescPeer::ID);
			$selectCriteria->add(SearchCritDescPeer::ID, $criteria->remove(SearchCritDescPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseSearchCritDescPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseSearchCritDescPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(SearchCritDescPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SearchCritDescPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof SearchCritDesc) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SearchCritDescPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(SearchCritDesc $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SearchCritDescPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SearchCritDescPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(SearchCritDescPeer::DATABASE_NAME, SearchCritDescPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SearchCritDescPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(SearchCritDescPeer::DATABASE_NAME);

		$criteria->add(SearchCritDescPeer::ID, $pk);


		$v = SearchCritDescPeer::doSelect($criteria, $con);

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
			$criteria->add(SearchCritDescPeer::ID, $pks, Criteria::IN);
			$objs = SearchCritDescPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSearchCritDescPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SearchCritDescMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SearchCritDescMapBuilder');
}
