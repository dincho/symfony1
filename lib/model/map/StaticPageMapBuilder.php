<?php



class StaticPageMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.StaticPageMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('static_page');
		$tMap->setPhpName('StaticPage');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('SLUG', 'Slug', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('HAS_MINI_MENU', 'HasMiniMenu', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 