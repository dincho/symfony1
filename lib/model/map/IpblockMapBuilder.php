<?php



class IpblockMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.IpblockMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ipblock');
		$tMap->setPhpName('Ipblock');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ITEM', 'Item', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ITEM_TYPE', 'ItemType', 'int', CreoleTypes::INTEGER, false, 1);

		$tMap->addColumn('NETMASK', 'Netmask', 'int', CreoleTypes::INTEGER, false, 2);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 