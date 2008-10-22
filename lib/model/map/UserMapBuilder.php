<?php



class UserMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UserMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('user');
		$tMap->setPhpName('User');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::CHAR, true, 40);

		$tMap->addColumn('FIRST_NAME', 'FirstName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('LAST_NAME', 'LastName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('MUST_CHANGE_PWD', 'MustChangePwd', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_SUPERUSER', 'IsSuperuser', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_ENABLED', 'IsEnabled', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('LAST_LOGIN', 'LastLogin', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 