<?php


abstract class BaseImbraQuestionI18nPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'imbra_question_i18n';

	
	const CLASS_DEFAULT = 'lib.model.ImbraQuestionI18n';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const TITLE = 'imbra_question_i18n.TITLE';

	
	const EXPLAIN_TITLE = 'imbra_question_i18n.EXPLAIN_TITLE';

	
	const POSITIVE_ANSWER = 'imbra_question_i18n.POSITIVE_ANSWER';

	
	const NEGATIVE_ANSWER = 'imbra_question_i18n.NEGATIVE_ANSWER';

	
	const ID = 'imbra_question_i18n.ID';

	
	const CULTURE = 'imbra_question_i18n.CULTURE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Title', 'ExplainTitle', 'PositiveAnswer', 'NegativeAnswer', 'Id', 'Culture', ),
		BasePeer::TYPE_COLNAME => array (ImbraQuestionI18nPeer::TITLE, ImbraQuestionI18nPeer::EXPLAIN_TITLE, ImbraQuestionI18nPeer::POSITIVE_ANSWER, ImbraQuestionI18nPeer::NEGATIVE_ANSWER, ImbraQuestionI18nPeer::ID, ImbraQuestionI18nPeer::CULTURE, ),
		BasePeer::TYPE_FIELDNAME => array ('title', 'explain_title', 'positive_answer', 'negative_answer', 'id', 'culture', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Title' => 0, 'ExplainTitle' => 1, 'PositiveAnswer' => 2, 'NegativeAnswer' => 3, 'Id' => 4, 'Culture' => 5, ),
		BasePeer::TYPE_COLNAME => array (ImbraQuestionI18nPeer::TITLE => 0, ImbraQuestionI18nPeer::EXPLAIN_TITLE => 1, ImbraQuestionI18nPeer::POSITIVE_ANSWER => 2, ImbraQuestionI18nPeer::NEGATIVE_ANSWER => 3, ImbraQuestionI18nPeer::ID => 4, ImbraQuestionI18nPeer::CULTURE => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('title' => 0, 'explain_title' => 1, 'positive_answer' => 2, 'negative_answer' => 3, 'id' => 4, 'culture' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ImbraQuestionI18nMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ImbraQuestionI18nMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ImbraQuestionI18nPeer::getTableMap();
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
		return str_replace(ImbraQuestionI18nPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ImbraQuestionI18nPeer::TITLE);

		$criteria->addSelectColumn(ImbraQuestionI18nPeer::EXPLAIN_TITLE);

		$criteria->addSelectColumn(ImbraQuestionI18nPeer::POSITIVE_ANSWER);

		$criteria->addSelectColumn(ImbraQuestionI18nPeer::NEGATIVE_ANSWER);

		$criteria->addSelectColumn(ImbraQuestionI18nPeer::ID);

		$criteria->addSelectColumn(ImbraQuestionI18nPeer::CULTURE);

	}

	const COUNT = 'COUNT(imbra_question_i18n.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT imbra_question_i18n.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ImbraQuestionI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ImbraQuestionI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ImbraQuestionI18nPeer::doSelectRS($criteria, $con);
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
		$objects = ImbraQuestionI18nPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ImbraQuestionI18nPeer::populateObjects(ImbraQuestionI18nPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionI18nPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseImbraQuestionI18nPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ImbraQuestionI18nPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ImbraQuestionI18nPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinImbraQuestion(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ImbraQuestionI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ImbraQuestionI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ImbraQuestionI18nPeer::ID, ImbraQuestionPeer::ID);

		$rs = ImbraQuestionI18nPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinImbraQuestion(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ImbraQuestionI18nPeer::addSelectColumns($c);
		$startcol = (ImbraQuestionI18nPeer::NUM_COLUMNS - ImbraQuestionI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ImbraQuestionPeer::addSelectColumns($c);

		$c->addJoin(ImbraQuestionI18nPeer::ID, ImbraQuestionPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ImbraQuestionI18nPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ImbraQuestionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getImbraQuestion(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addImbraQuestionI18n($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initImbraQuestionI18ns();
				$obj2->addImbraQuestionI18n($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ImbraQuestionI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ImbraQuestionI18nPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ImbraQuestionI18nPeer::ID, ImbraQuestionPeer::ID);

		$rs = ImbraQuestionI18nPeer::doSelectRS($criteria, $con);
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

		ImbraQuestionI18nPeer::addSelectColumns($c);
		$startcol2 = (ImbraQuestionI18nPeer::NUM_COLUMNS - ImbraQuestionI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ImbraQuestionPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ImbraQuestionPeer::NUM_COLUMNS;

		$c->addJoin(ImbraQuestionI18nPeer::ID, ImbraQuestionPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ImbraQuestionI18nPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ImbraQuestionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getImbraQuestion(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addImbraQuestionI18n($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initImbraQuestionI18ns();
				$obj2->addImbraQuestionI18n($obj1);
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
		return ImbraQuestionI18nPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionI18nPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseImbraQuestionI18nPeer', $values, $con);
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

		
    foreach (sfMixer::getCallables('BaseImbraQuestionI18nPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseImbraQuestionI18nPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionI18nPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseImbraQuestionI18nPeer', $values, $con);
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
			$comparison = $criteria->getComparison(ImbraQuestionI18nPeer::ID);
			$selectCriteria->add(ImbraQuestionI18nPeer::ID, $criteria->remove(ImbraQuestionI18nPeer::ID), $comparison);

			$comparison = $criteria->getComparison(ImbraQuestionI18nPeer::CULTURE);
			$selectCriteria->add(ImbraQuestionI18nPeer::CULTURE, $criteria->remove(ImbraQuestionI18nPeer::CULTURE), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseImbraQuestionI18nPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseImbraQuestionI18nPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(ImbraQuestionI18nPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ImbraQuestionI18nPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ImbraQuestionI18n) {

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

			$criteria->add(ImbraQuestionI18nPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(ImbraQuestionI18nPeer::CULTURE, $vals[1], Criteria::IN);
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

	
	public static function doValidate(ImbraQuestionI18n $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ImbraQuestionI18nPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ImbraQuestionI18nPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ImbraQuestionI18nPeer::DATABASE_NAME, ImbraQuestionI18nPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ImbraQuestionI18nPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
		$criteria->add(ImbraQuestionI18nPeer::ID, $id);
		$criteria->add(ImbraQuestionI18nPeer::CULTURE, $culture);
		$v = ImbraQuestionI18nPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseImbraQuestionI18nPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ImbraQuestionI18nMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ImbraQuestionI18nMapBuilder');
}
