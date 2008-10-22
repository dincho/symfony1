<?php


abstract class BaseMemberImbraPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'member_imbra';

	
	const CLASS_DEFAULT = 'lib.model.MemberImbra';

	
	const NUM_COLUMNS = 12;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'member_imbra.ID';

	
	const MEMBER_ID = 'member_imbra.MEMBER_ID';

	
	const IMBRA_STATUS_ID = 'member_imbra.IMBRA_STATUS_ID';

	
	const TEXT = 'member_imbra.TEXT';

	
	const NAME = 'member_imbra.NAME';

	
	const DOB = 'member_imbra.DOB';

	
	const ADDRESS = 'member_imbra.ADDRESS';

	
	const CITY = 'member_imbra.CITY';

	
	const STATE_ID = 'member_imbra.STATE_ID';

	
	const ZIP = 'member_imbra.ZIP';

	
	const PHONE = 'member_imbra.PHONE';

	
	const CREATED_AT = 'member_imbra.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'MemberId', 'ImbraStatusId', 'Text', 'Name', 'Dob', 'Address', 'City', 'StateId', 'Zip', 'Phone', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (MemberImbraPeer::ID, MemberImbraPeer::MEMBER_ID, MemberImbraPeer::IMBRA_STATUS_ID, MemberImbraPeer::TEXT, MemberImbraPeer::NAME, MemberImbraPeer::DOB, MemberImbraPeer::ADDRESS, MemberImbraPeer::CITY, MemberImbraPeer::STATE_ID, MemberImbraPeer::ZIP, MemberImbraPeer::PHONE, MemberImbraPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'member_id', 'imbra_status_id', 'text', 'name', 'dob', 'address', 'city', 'state_id', 'zip', 'phone', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'MemberId' => 1, 'ImbraStatusId' => 2, 'Text' => 3, 'Name' => 4, 'Dob' => 5, 'Address' => 6, 'City' => 7, 'StateId' => 8, 'Zip' => 9, 'Phone' => 10, 'CreatedAt' => 11, ),
		BasePeer::TYPE_COLNAME => array (MemberImbraPeer::ID => 0, MemberImbraPeer::MEMBER_ID => 1, MemberImbraPeer::IMBRA_STATUS_ID => 2, MemberImbraPeer::TEXT => 3, MemberImbraPeer::NAME => 4, MemberImbraPeer::DOB => 5, MemberImbraPeer::ADDRESS => 6, MemberImbraPeer::CITY => 7, MemberImbraPeer::STATE_ID => 8, MemberImbraPeer::ZIP => 9, MemberImbraPeer::PHONE => 10, MemberImbraPeer::CREATED_AT => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'member_id' => 1, 'imbra_status_id' => 2, 'text' => 3, 'name' => 4, 'dob' => 5, 'address' => 6, 'city' => 7, 'state_id' => 8, 'zip' => 9, 'phone' => 10, 'created_at' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MemberImbraMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MemberImbraMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MemberImbraPeer::getTableMap();
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
		return str_replace(MemberImbraPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MemberImbraPeer::ID);

		$criteria->addSelectColumn(MemberImbraPeer::MEMBER_ID);

		$criteria->addSelectColumn(MemberImbraPeer::IMBRA_STATUS_ID);

		$criteria->addSelectColumn(MemberImbraPeer::TEXT);

		$criteria->addSelectColumn(MemberImbraPeer::NAME);

		$criteria->addSelectColumn(MemberImbraPeer::DOB);

		$criteria->addSelectColumn(MemberImbraPeer::ADDRESS);

		$criteria->addSelectColumn(MemberImbraPeer::CITY);

		$criteria->addSelectColumn(MemberImbraPeer::STATE_ID);

		$criteria->addSelectColumn(MemberImbraPeer::ZIP);

		$criteria->addSelectColumn(MemberImbraPeer::PHONE);

		$criteria->addSelectColumn(MemberImbraPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(member_imbra.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT member_imbra.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
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
		$objects = MemberImbraPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MemberImbraPeer::populateObjects(MemberImbraPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbraPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseMemberImbraPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MemberImbraPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MemberImbraPeer::getOMClass();
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
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinImbraStatus(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinState(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
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

		MemberImbraPeer::addSelectColumns($c);
		$startcol = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberPeer::addSelectColumns($c);

		$c->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();

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
										$temp_obj2->addMemberImbra($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinImbraStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberImbraPeer::addSelectColumns($c);
		$startcol = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ImbraStatusPeer::addSelectColumns($c);

		$c->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ImbraStatusPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getImbraStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMemberImbra($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinState(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberImbraPeer::addSelectColumns($c);
		$startcol = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		StatePeer::addSelectColumns($c);

		$c->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = StatePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getState(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMemberImbra($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$criteria->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);

		$criteria->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
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

		MemberImbraPeer::addSelectColumns($c);
		$startcol2 = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

		ImbraStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ImbraStatusPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + StatePeer::NUM_COLUMNS;

		$c->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$c->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);

		$c->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();


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
					$temp_obj2->addMemberImbra($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1);
			}


					
			$omClass = ImbraStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getImbraStatus(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMemberImbra($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initMemberImbras();
				$obj3->addMemberImbra($obj1);
			}


					
			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getState(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMemberImbra($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initMemberImbras();
				$obj4->addMemberImbra($obj1);
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
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);

		$criteria->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptImbraStatus(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$criteria->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptState(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberImbraPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$criteria->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);

		$rs = MemberImbraPeer::doSelectRS($criteria, $con);
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

		MemberImbraPeer::addSelectColumns($c);
		$startcol2 = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ImbraStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ImbraStatusPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + StatePeer::NUM_COLUMNS;

		$c->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);

		$c->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ImbraStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getImbraStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMemberImbra($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getState(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMemberImbra($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMemberImbras();
				$obj3->addMemberImbra($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptImbraStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberImbraPeer::addSelectColumns($c);
		$startcol2 = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + StatePeer::NUM_COLUMNS;

		$c->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$c->addJoin(MemberImbraPeer::STATE_ID, StatePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();

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
					$temp_obj2->addMemberImbra($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getState(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMemberImbra($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMemberImbras();
				$obj3->addMemberImbra($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptState(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberImbraPeer::addSelectColumns($c);
		$startcol2 = (MemberImbraPeer::NUM_COLUMNS - MemberImbraPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

		ImbraStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ImbraStatusPeer::NUM_COLUMNS;

		$c->addJoin(MemberImbraPeer::MEMBER_ID, MemberPeer::ID);

		$c->addJoin(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberImbraPeer::getOMClass();

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
					$temp_obj2->addMemberImbra($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMemberImbras();
				$obj2->addMemberImbra($obj1);
			}

			$omClass = ImbraStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getImbraStatus(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMemberImbra($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMemberImbras();
				$obj3->addMemberImbra($obj1);
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
		return MemberImbraPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbraPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberImbraPeer', $values, $con);
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

		$criteria->remove(MemberImbraPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseMemberImbraPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberImbraPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberImbraPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberImbraPeer', $values, $con);
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
			$comparison = $criteria->getComparison(MemberImbraPeer::ID);
			$selectCriteria->add(MemberImbraPeer::ID, $criteria->remove(MemberImbraPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMemberImbraPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberImbraPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(MemberImbraPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MemberImbraPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof MemberImbra) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MemberImbraPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(MemberImbra $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MemberImbraPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MemberImbraPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MemberImbraPeer::DATABASE_NAME, MemberImbraPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MemberImbraPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(MemberImbraPeer::DATABASE_NAME);

		$criteria->add(MemberImbraPeer::ID, $pk);


		$v = MemberImbraPeer::doSelect($criteria, $con);

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
			$criteria->add(MemberImbraPeer::ID, $pks, Criteria::IN);
			$objs = MemberImbraPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMemberImbraPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MemberImbraMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MemberImbraMapBuilder');
}
