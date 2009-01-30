<?php



class StatePhotoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.StatePhotoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('state_photo');
		$tMap->setPhpName('StatePhoto');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('STATE_ID', 'StateId', 'int', CreoleTypes::INTEGER, 'state', 'ID', true, null);

		$tMap->addColumn('FILE', 'File', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 