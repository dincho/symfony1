<?php



class NotificationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.NotificationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('notification');
		$tMap->setPhpName('Notification');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SEND_FROM', 'SendFrom', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SEND_TO', 'SendTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REPLY_TO', 'ReplyTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BCC', 'Bcc', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('TRIGGER_NAME', 'TriggerName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BODY', 'Body', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('FOOTER', 'Footer', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('TO_ADMINS', 'ToAdmins', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('DAYS', 'Days', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('WHN', 'Whn', 'string', CreoleTypes::CHAR, false, 1);

	} 
} 