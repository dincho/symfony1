<?php



class SessionStorageMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SessionStorageMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('session_storage');
		$tMap->setPhpName('SessionStorage');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('SESS_ID', 'SessId', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('SESS_DATA', 'SessData', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('SESS_TIME', 'SessTime', 'string', CreoleTypes::BIGINT, true, 20);

		$tMap->addColumn('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 