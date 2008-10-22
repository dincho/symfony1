<?php



class GroupAndActionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.GroupAndActionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('group_and_action');
		$tMap->setPhpName('GroupAndAction');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ACTION', 'Action', 'string', CreoleTypes::VARCHAR, true, 200);

		$tMap->addForeignPrimaryKey('GROUP_ID', 'GroupId', 'int' , CreoleTypes::INTEGER, 'groups', 'ID', true, null);

	} 
} 