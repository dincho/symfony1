<?php



class MessageMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MessageMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('message');
		$tMap->setPhpName('Message');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('FROM_MEMBER_ID', 'FromMemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('TO_MEMBER_ID', 'ToMemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('SENT_BOX', 'SentBox', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_READ', 'IsRead', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_REVIEWED', 'IsReviewed', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_REPLIED', 'IsReplied', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_SYSTEM', 'IsSystem', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 