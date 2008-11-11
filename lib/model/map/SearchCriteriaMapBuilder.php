<?php



class SearchCriteriaMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SearchCriteriaMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('search_criteria');
		$tMap->setPhpName('SearchCriteria');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('AGES', 'Ages', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('AGES_WEIGHT', 'AgesWeight', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 