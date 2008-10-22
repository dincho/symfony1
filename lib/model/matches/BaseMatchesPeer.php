<?php
/**
 * Subclass for performing query and update operations on the 'matches' view.
 *
 * 
 *
 * @package lib.model.matches
 * @author Dincho Todorov
 */
class BaseMatchesPeer
{
    const DATABASE_NAME = 'propel';
    const TABLE_NAME = 'matches';
    const MEMBER1_ID = 'matches.MEMBER1_ID';
    const MEMBER2_ID = 'matches.MEMBER2_ID';
    const SCORE = 'matches.SCORE';
    const REVERSE_SCORE = 'matches.REVERSE_SCORE';
    const CLASS_DEFAULT = 'lib.model.matches.Matches';
    const NUM_COLUMNS = 5;
    const NUM_LAZY_LOAD_COLUMNS = 3;
    private static $fieldNames = array(BasePeer::TYPE_PHPNAME => array('Member1Id', 'Member2Id', 'Score', 'ReverseScore'), BasePeer::TYPE_COLNAME => array(MatchesPeer::MEMBER1_ID, MatchesPeer::MEMBER2_ID, MatchesPeer::SCORE, MatchesPeer::REVERSE_SCORE), BasePeer::TYPE_FIELDNAME => array('member1_id', 'member2_id', 'score', 'reverse_score'), BasePeer::TYPE_NUM => array(0, 1, 2, 3));
    private static $fieldKeys = array(BasePeer::TYPE_PHPNAME => array('Member1Id' => 0, 'Member2Id' => 1, 'Score' => 2, 'ReverseScore' => 3), BasePeer::TYPE_COLNAME => array(MatchesPeer::MEMBER1_ID => 0, MatchesPeer::MEMBER2_ID => 1, MatchesPeer::SCORE => 2, MatchesPeer::REVERSE_SCORE => 3), BasePeer::TYPE_FIELDNAME => array('member1_id' => 0, 'member2_id' => 1, 'score' => 2, 'reverse_score' => 3), BasePeer::TYPE_NUM => array(0, 1, 2, 3));

    const COUNT = 'COUNT(matches.MEMBER2_ID)';
    const COUNT_DISTINCT = 'COUNT(DISTINCT matches.MEMBER2_ID)';
    
    public static function getMapBuilder()
    {
        include_once 'lib/model/matches/MatchesMapBuilder.php';
        return BasePeer::getMapBuilder('lib.model.matches.MatchesMapBuilder');
    }

    public static function getOMClass()
    {
        return MatchesPeer::CLASS_DEFAULT;
    }

    public static function getPhpNameMap()
    {
        if (self::$phpNameMap === null)
        {
            $map = MatchesPeer::getTableMap();
            $columns = $map->getColumns();
            $nameMap = array();
            foreach ($columns as $column)
            {
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
        if ($key === null)
        {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
        }
        return $toNames[$key];
    }

    static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (! array_key_exists($type, self::$fieldNames))
        {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
        }
        return self::$fieldNames[$type];
    }

    public static function doSelect(Criteria $criteria, $con = null)
    {
        return MatchesPeer::populateObjects(MatchesPeer::doSelectRS($criteria, $con));
    }

    public static function addSelectColumns(Criteria $criteria)
    {
        $criteria->addSelectColumn(MatchesPeer::MEMBER1_ID);
        $criteria->addSelectColumn(MatchesPeer::MEMBER2_ID);
        $criteria->addAsColumn('total_score', 'SUM(' . MatchesPeer::SCORE . ')');
        $criteria->addAsColumn('reverse_score', 
                                'COALESCE((SELECT SUM(m2.score)
                                    FROM matches AS m2 
                                    WHERE m2.member1_id = matches.member2_id AND m2.member2_id = matches.member1_id 
                                    GROUP BY m2.member2_id), 0)');
        $criteria->addAsColumn('combined_score',
                                '(COALESCE((SELECT SUM(m2.score)
                                    FROM matches AS m2 
                                    WHERE m2.member1_id = matches.member2_id AND m2.member2_id = matches.member1_id 
                                    GROUP BY m2.member2_id), 0)+SUM(matches.score))/2');
        $criteria->addGroupByColumn(MatchesPeer::MEMBER2_ID);
    }

    public static function doSelectRS(Criteria $criteria, $con = null)
    {
        if ($con === null)
        {
            $con = Propel::getConnection(self::DATABASE_NAME);
        }
        if (! $criteria->getSelectColumns())
        {
            $criteria = clone $criteria;
            MatchesPeer::addSelectColumns($criteria);
        }
        $criteria->setDbName(self::DATABASE_NAME);
        return BasePeer::doSelect($criteria, $con);
    }

    public static function doCount(Criteria $criteria, $distinct = true, $con = null)
    {
        $criteria = clone $criteria;
        $criteria->clearSelectColumns()->clearOrderByColumns();
        
        if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers()))
        {
            $criteria->addSelectColumn(MatchesPeer::COUNT_DISTINCT);
        } else
        {
            $criteria->addSelectColumn(MatchesPeer::COUNT);
        }
        
        foreach ($criteria->getGroupByColumns() as $column)
        {
            $criteria->addSelectColumn($column);
        }
        
        //$criteria->addJoin(MatchesPeer::MEMBER2_ID, MemberPeer::ID);
        $rs = MatchesPeer::doSelectRS($criteria, $con);
        if ($rs->next())
        {
            return $rs->getInt(1);
        } else
        {
            return 0;
        }
    }

    public static function doSelectJoinMemberRelatedByMember2Id(Criteria $c, $con = null)
    {
        $c = clone $c;
        if ($c->getDbName() == Propel::getDefaultDB())
        {
            $c->setDbName(self::DATABASE_NAME);
        }
        MatchesPeer::addSelectColumns($c);
        $startcol = (MatchesPeer::NUM_COLUMNS - MatchesPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        
        MemberPeer::addSelectColumns($c);
        $c->addJoin(MatchesPeer::MEMBER2_ID, MemberPeer::ID);
        
        $rs = MatchesPeer::doSelectRS($c, $con);
        $results = array();
        
        $cls1 = Propel::import(MatchesPeer::getOMClass());
        $cls2 = Propel::import(MemberPeer::getOMClass());            
        while ($rs->next())
        {

            $obj1 = new $cls1();
            $obj1->hydrate($rs);
            //print_r($rs->getInt(3)); echo '<br />';
            
            $obj2 = new $cls2();
            $obj2->hydrate($rs, $startcol);
            $obj1->setMemberRelatedByMember2Id($obj2);
            
            $results[] = $obj1;
        }
        
        //print_r($results);exit();
        return $results;
    }

    public static function populateObjects(ResultSet $rs)
    {
        $results = array();
        $cls = MatchesPeer::getOMClass();
        $cls = Propel::import($cls);
        while ($rs->next())
        {
            $obj = new $cls();
            $obj->hydrate($rs);
            $results[] = $obj;
        }
        return $results;
    }
}
if (Propel::isInit())
{
    try
    {
        BaseMatchesPeer::getMapBuilder();
    } catch (Exception $e)
    {
        Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
    }
} else
{
    require_once 'lib/model/matches/MatchesMapBuilder.php';
    Propel::registerMapBuilder('lib.model.matches.MatchesMapBuilder');
}