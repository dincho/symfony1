<?php
/**
 *
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 7, 2009 11:47:49 AM
 *
 */

class prBasePager
{
    protected $peerClass  = null,
        $criteria   = null,
        $prev       = null,
        $next       = null,
        $currentID  = null,
        $getter     = 'getId'
    ;

    public function __construct($peerClass, Criteria $crit, $currentID, $getter = 'getId')
    {
        $this->setPeerClass($peerClass);
        $this->setCriteria($crit);
        $this->setCurrentID($currentID);
        $this->setGetter($getter);
    }

    public function init()
    {
        $c2 = clone $this->criteria;

        $c = $this->criteria;
        $c->clearSelectColumns()->addSelectColumn(constant($this->peerClass.'::ID'));
        $c->addAsColumn('position', '(@num := @num + 1)');

        $con = Propel::getConnection();
        $dbMap = Propel::getDatabaseMap($c->getDbName());

        $params = array(); // This will be filled with the parameters
        $sub_sql = BasePeer::createSelectSql($c, $params);

        $sql = 'SELECT `position`, `id`
                FROM
                (
                    ' . $sub_sql . '
                ) AS subselect
                WHERE id = ?
                ORDER BY position ASC
                LIMIT 1';

        $stmt = $con->prepareStatement($sql);
        $last_bind_index = $this->populateStmtValues($stmt, $params, $dbMap);
        $stmt->setInt($last_bind_index, $this->currentID);

        $con->executeQuery('SET @num := 0'); //init the fucking variable
        $rs = $stmt->executeQuery( array(), ResultSet::FETCHMODE_NUM );

        $current_pos = ($rs->next()) ? $rs->get(1) : 0;

        /******************/

        $sql2 = 'SELECT `position`, `id`
                FROM
                (
                    ' . $sub_sql . '
                ) AS subselect
                WHERE `position` IN (? - 1, ? + 1)
                ORDER BY position ASC
                LIMIT 2';

        $stmt2 = $con->prepareStatement($sql2);
        $last_bind_index = $this->populateStmtValues($stmt2, $params, $dbMap);
        $stmt2->setInt($last_bind_index, $current_pos);
        $stmt2->setInt($last_bind_index+1, $current_pos);

        $con->executeQuery('SET @num := 0'); //init the fucking variable
        $rs2 = $stmt2->executeQuery( array(), ResultSet::FETCHMODE_NUM );

        while ($rs2->next()) {
            if( $rs2->get(1) < $current_pos )
                $this->prev = call_user_func(array($this->peerClass, 'retrieveByPK'), $rs2->get(2));

            if( $rs2->get(1) > $current_pos )
                $this->next = call_user_func(array($this->peerClass, 'retrieveByPK'), $rs2->get(2));
        }
    }

    public function setPeerClass($peerClass)
    {
        $this->peerClass = $peerClass;
    }

    public function getPeerClass()
    {
        return $this->peerClass;
    }

    public function setCriteria($criteria)
    {
        $this->criteria = clone $criteria;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setCurrentID($currentID)
    {
        $this->currentID = $currentID;
    }

    public function getCurrentID()
    {
        return $this->currentID;
    }

    public function setGetter($getter)
    {
        $this->getter = $getter;
    }

    public function getGetter()
    {
        return $this->getter;
    }

    public function getNext()
    {
        $getter = $this->getGetter();

        return ($this->next) ? $this->next->$getter() : null;
    }

    public function getPrevious()
    {
        $getter = $this->getGetter();

        return ($this->prev) ? $this->prev->$getter() : null;
    }

    public function hasResults()
    {
        return (!is_null($this->prev) || !is_null($this->next));
    }

    private static function populateStmtValues($stmt, $params, DatabaseMap $dbMap)
    {
        $i = 1;
        foreach ($params as $param) {
            $tableName = $param['table'];
            $columnName = $param['column'];
            $value = $param['value'];

            if ($value === null) {
                $stmt->setNull($i++);
            } else {
                $cMap = $dbMap->getTable($tableName)->getColumn($columnName);
                $setter = 'set' . CreoleTypes::getAffix($cMap->getCreoleType());
                $stmt->$setter($i++, $value);
            }
        } // foreach

        return $i;
    }
}
