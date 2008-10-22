<?php



class sfSettingMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.sfSettingMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_setting');
		$tMap->setPhpName('sfSetting');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ENV', 'Env', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addColumn('VALUE', 'Value', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_USER_ID', 'CreatedUserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('UPDATED_USER_ID', 'UpdatedUserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 