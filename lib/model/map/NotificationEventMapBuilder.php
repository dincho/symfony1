<?php



class NotificationEventMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.NotificationEventMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('notification_event');
		$tMap->setPhpName('NotificationEvent');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('NOTIFICATION_ID', 'NotificationId', 'int', CreoleTypes::INTEGER, 'notification', 'ID', false, null);

		$tMap->addColumn('EVENT', 'Event', 'int', CreoleTypes::TINYINT, false, null);

	} 
} 