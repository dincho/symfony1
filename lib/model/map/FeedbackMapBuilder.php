<?php



class FeedbackMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.FeedbackMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('feedback');
		$tMap->setPhpName('Feedback');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('MAILBOX', 'Mailbox', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addForeignKey('MEMBER_ID', 'MemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', false, null);

		$tMap->addColumn('MAIL_FROM', 'MailFrom', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('NAME_FROM', 'NameFrom', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MAIL_TO', 'MailTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('NAME_TO', 'NameTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BCC', 'Bcc', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BODY', 'Body', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('IS_READ', 'IsRead', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 