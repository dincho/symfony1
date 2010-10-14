<?php



class sfSettingMapBuilder {

	
	const CLASS_NAME = 'plugins.sfSettingsPlugin.lib.model.map.sfSettingMapBuilder';

	
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

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('CAT_ID', 'CatId', 'int' , CreoleTypes::INTEGER, 'catalogue', 'CAT_ID', true, 11);

		$tMap->addPrimaryKey('ENV', 'Env', 'string', CreoleTypes::VARCHAR, true, 10);

		$tMap->addPrimaryKey('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 40);

		$tMap->addColumn('VALUE', 'Value', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('VAR_TYPE', 'VarType', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_USER_ID', 'CreatedUserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('UPDATED_USER_ID', 'UpdatedUserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 