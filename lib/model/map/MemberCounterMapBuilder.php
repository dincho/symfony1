<?php



class MemberCounterMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberCounterMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member_counter');
		$tMap->setPhpName('MemberCounter');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CURRENT_FLAGS', 'CurrentFlags', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TOTAL_FLAGS', 'TotalFlags', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('SENT_FLAGS', 'SentFlags', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('SENT_WINKS', 'SentWinks', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RECEIVED_WINKS', 'ReceivedWinks', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('SENT_MESSAGES', 'SentMessages', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RECEIVED_MESSAGES', 'ReceivedMessages', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('REPLY_MESSAGES', 'ReplyMessages', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UNSUSPENSIONS', 'Unsuspensions', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ASSISTANT_CONTACTS', 'AssistantContacts', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PROFILE_VIEWS', 'ProfileViews', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('MADE_PROFILE_VIEWS', 'MadeProfileViews', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('HOTLIST', 'Hotlist', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ON_OTHERS_HOTLIST', 'OnOthersHotlist', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 