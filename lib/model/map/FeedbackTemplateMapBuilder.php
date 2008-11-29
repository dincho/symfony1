<?php



class FeedbackTemplateMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.FeedbackTemplateMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('feedback_template');
		$tMap->setPhpName('FeedbackTemplate');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MAIL_FROM', 'MailFrom', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REPLY_TO', 'ReplyTo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BCC', 'Bcc', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BODY', 'Body', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('FOOTER', 'Footer', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 