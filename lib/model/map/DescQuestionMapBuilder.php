<?php



class DescQuestionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DescQuestionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('desc_question');
		$tMap->setPhpName('DescQuestion');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SEARCH_TITLE', 'SearchTitle', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DESC_TITLE', 'DescTitle', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('FACTOR_TITLE', 'FactorTitle', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('IS_REQUIRED', 'IsRequired', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SELECT_GREATHER', 'SelectGreather', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('OTHER', 'Other', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 