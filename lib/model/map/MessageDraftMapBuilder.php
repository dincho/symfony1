<?php



class MessageDraftMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MessageDraftMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('message_draft');
		$tMap->setPhpName('MessageDraft');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('FROM_MEMBER_ID', 'FromMemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('TO_MEMBER_ID', 'ToMemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('REPLY_TO', 'ReplyTo', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 