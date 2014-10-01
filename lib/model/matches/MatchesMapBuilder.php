<?php

class MatchesMapBuilder
{
    const CLASS_NAME = 'lib.model.map.MatchesMapBuilder';

    private $dbMap;

    public function isBuilt()
    {
        return ($this->dbMap !== null);
    }

    public function getDatabaseMap()
    {
        return $this->dbMap;
    }

    public function doBuild()
    {
        $this->dbMap = Propel::getDatabaseMap('propel');

        $tMap = $this->dbMap->addTable('matches');
        $tMap->setPhpName('Matches');

        $tMap->setUseIdGenerator(true);

        $tMap->addForeignKey('MEMBER1_ID', 'Member1Id', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

        $tMap->addForeignKey('MEMBER2_ID', 'Member2Id', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

        $tMap->addColumn('SCORE', 'Score', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('REVERSE_SCORE', 'ReverseScore', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

    }
}
