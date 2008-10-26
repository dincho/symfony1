<?php


abstract class BaseImbraQuestionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'imbra_question';

	
	const CLASS_DEFAULT = 'lib.model.ImbraQuestion';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'imbra_question.ID';

	
	const TITLE = 'imbra_question.TITLE';

	
	const EXPLAIN_TITLE = 'imbra_question.EXPLAIN_TITLE';

	
	const POSITIVE_ANSWER = 'imbra_question.POSITIVE_ANSWER';

	
	const NEGATIVE_ANSWER = 'imbra_question.NEGATIVE_ANSWER';

	
	const ONLY_EXPLAIN = 'imbra_question.ONLY_EXPLAIN';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Title', 'ExplainTitle', 'PositiveAnswer', 'NegativeAnswer', 'OnlyExplain', ),
		BasePeer::TYPE_COLNAME => array (ImbraQuestionPeer::ID, ImbraQuestionPeer::TITLE, ImbraQuestionPeer::EXPLAIN_TITLE, ImbraQuestionPeer::POSITIVE_ANSWER, ImbraQuestionPeer::NEGATIVE_ANSWER, ImbraQuestionPeer::ONLY_EXPLAIN, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'title', 'explain_title', 'positive_answer', 'negative_answer', 'only_explain', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Title' => 1, 'ExplainTitle' => 2, 'PositiveAnswer' => 3, 'NegativeAnswer' => 4, 'OnlyExplain' => 5, ),
		BasePeer::TYPE_COLNAME => array (ImbraQuestionPeer::ID => 0, ImbraQuestionPeer::TITLE => 1, ImbraQuestionPeer::EXPLAIN_TITLE => 2, ImbraQuestionPeer::POSITIVE_ANSWER => 3, ImbraQuestionPeer::NEGATIVE_ANSWER => 4, ImbraQuestionPeer::ONLY_EXPLAIN => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'title' => 1, 'explain_title' => 2, 'positive_answer' => 3, 'negative_answer' => 4, 'only_explain' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ImbraQuestionMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ImbraQuestionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ImbraQuestionPeer::getTableMap();
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
		return str_replace(ImbraQuestionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ImbraQuestionPeer::ID);

		$criteria->addSelectColumn(ImbraQuestionPeer::TITLE);

		$criteria->addSelectColumn(ImbraQuestionPeer::EXPLAIN_TITLE);

		$criteria->addSelectColumn(ImbraQuestionPeer::POSITIVE_ANSWER);

		$criteria->addSelectColumn(ImbraQuestionPeer::NEGATIVE_ANSWER);

		$criteria->addSelectColumn(ImbraQuestionPeer::ONLY_EXPLAIN);

	}

	const COUNT = 'COUNT(imbra_question.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT imbra_question.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ImbraQuestionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ImbraQuestionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ImbraQuestionPeer::doSelectRS($criteria, $con);
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
		$objects = ImbraQuestionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ImbraQuestionPeer::populateObjects(ImbraQuestionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseImbraQuestionPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ImbraQuestionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ImbraQuestionPeer::getOMClass();
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
		return ImbraQuestionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseImbraQuestionPeer', $values, $con);
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

		$criteria->remove(ImbraQuestionPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseImbraQuestionPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseImbraQuestionPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseImbraQuestionPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseImbraQuestionPeer', $values, $con);
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
			$comparison = $criteria->getComparison(ImbraQuestionPeer::ID);
			$selectCriteria->add(ImbraQuestionPeer::ID, $criteria->remove(ImbraQuestionPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseImbraQuestionPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseImbraQuestionPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(ImbraQuestionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ImbraQuestionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ImbraQuestion) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ImbraQuestionPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ImbraQuestion $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ImbraQuestionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ImbraQuestionPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ImbraQuestionPeer::DATABASE_NAME, ImbraQuestionPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ImbraQuestionPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ImbraQuestionPeer::DATABASE_NAME);

		$criteria->add(ImbraQuestionPeer::ID, $pk);


		$v = ImbraQuestionPeer::doSelect($criteria, $con);

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
			$criteria->add(ImbraQuestionPeer::ID, $pks, Criteria::IN);
			$objs = ImbraQuestionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseImbraQuestionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ImbraQuestionMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ImbraQuestionMapBuilder');
}
