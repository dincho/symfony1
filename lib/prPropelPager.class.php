<?php

class prPropelPager extends sfPropelPager
{
    public function init()
    {
        $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
        $maxRecordLimit = $this->getMaxRecordLimit();

        $count = $this->getCount();

        $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

        $c = $this->getCriteria();
        $c->setOffset(0);
        $c->setLimit(0);

        if (($this->getPage() == 0 || $this->getMaxPerPage() == 0)) {
            $this->setLastPage(0);
        } else {
            $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

            $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
            $c->setOffset($offset);

            if ($hasMaxRecordLimit) {
                $maxRecordLimit = $maxRecordLimit - $offset;
                if ($maxRecordLimit > $this->getMaxPerPage()) {
                    $c->setLimit($this->getMaxPerPage());
                } else {
                    $c->setLimit($maxRecordLimit);
                }
            } else {
                $c->setLimit($this->getMaxPerPage());
            }
        }
    }

    protected function getCount()
    {
        $cForCount = clone $this->getCriteria();

        $params = array();
        $sql = BasePeer::createSelectSql($cForCount, $params); // get the sub-query sql
        //put the creole values back into the sql
        while (($pos = strpos($sql, "?")) !== false) {
            $value = array_shift($params);
            $value = $value["value"];

            //handle empty strings as values
            if (is_string($value) && empty($value)) {
                $value = '""';
            }

            $sql = substr($sql, 0, $pos) . $value . substr($sql, $pos + 1);
        }

        $sql = preg_replace("/SELECT/", "SELECT " . $this->tableName . ".ID", $sql, 1);
        $cSQL = sprintf("SELECT COUNT(*) AS cnt FROM (%s) AS cntTable", $sql);
        $con = Propel::getConnection();
        $stmt = $con->PrepareStatement($cSQL);
        $rs = $stmt->executeQuery();
        $rs->next();

        return $rs->getInt('cnt');
    }
}
