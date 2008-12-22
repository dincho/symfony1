<?php



class ImbraReplyTemplateMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ImbraReplyTemplateMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('imbra_reply_template');
		$tMap->setPhpName('ImbraReplyTemplate');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BODY', 'Body', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('MAIL_FROM', 'MailFrom', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REPLY_TO', 'ReplyTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BCC', 'Bcc', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 