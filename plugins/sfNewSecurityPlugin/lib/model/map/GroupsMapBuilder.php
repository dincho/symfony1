<?php



class GroupsMapBuilder {

	
	const CLASS_NAME = 'plugins.sfNewSecurityPlugin.lib.model.map.GroupsMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('groups');
		$tMap->setPhpName('Groups');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('GROUP_NAME', 'GroupName', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('GROUP_DESCRIPTION', 'GroupDescription', 'string', CreoleTypes::VARCHAR, false, 1000);

	} 
} 