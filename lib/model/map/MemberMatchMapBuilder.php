<?php



class MemberMatchMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberMatchMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member_match');
		$tMap->setPhpName('MemberMatch');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER1_ID', 'Member1Id', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('MEMBER2_ID', 'Member2Id', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addColumn('PCT', 'Pct', 'int', CreoleTypes::TINYINT, true, null);

	} 
} 