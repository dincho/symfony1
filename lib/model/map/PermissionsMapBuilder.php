<?php



class PermissionsMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PermissionsMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('permissions');
		$tMap->setPhpName('Permissions');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignKey('ID', 'Id', 'int', CreoleTypes::INTEGER, 'user', 'ID', true, null);

		$tMap->addForeignKey('GROUP_ID', 'GroupId', 'int', CreoleTypes::INTEGER, 'groups', 'ID', true, null);

	} 
} 