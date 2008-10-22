<?php



class MatchWeightMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MatchWeightMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('match_weight');
		$tMap->setPhpName('MatchWeight');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('NUMBER', 'Number', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 