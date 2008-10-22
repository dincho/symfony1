<?php



class SubscriptionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SubscriptionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('subscription');
		$tMap->setPhpName('Subscription');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CAN_POST_PHOTO', 'CanPostPhoto', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('POST_PHOTOS', 'PostPhotos', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CAN_WINK', 'CanWink', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('WINKS', 'Winks', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CAN_READ_MESSAGES', 'CanReadMessages', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('READ_MESSAGES', 'ReadMessages', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CAN_REPLY_MESSAGES', 'CanReplyMessages', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('REPLY_MESSAGES', 'ReplyMessages', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CAN_SEND_MESSAGES', 'CanSendMessages', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SEND_MESSAGES', 'SendMessages', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CAN_SEE_VIEWED', 'CanSeeViewed', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SEE_VIEWED', 'SeeViewed', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CAN_CONTACT_ASSISTANT', 'CanContactAssistant', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CONTACT_ASSISTANT', 'ContactAssistant', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PERIOD1_FROM', 'Period1From', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PERIOD1_TO', 'Period1To', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PERIOD1_PRICE', 'Period1Price', 'double', CreoleTypes::DECIMAL, true, 7);

		$tMap->addColumn('PERIOD2_FROM', 'Period2From', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PERIOD2_TO', 'Period2To', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PERIOD2_PRICE', 'Period2Price', 'double', CreoleTypes::DECIMAL, true, 7);

		$tMap->addColumn('PERIOD3_FROM', 'Period3From', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PERIOD3_TO', 'Period3To', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PERIOD3_PRICE', 'Period3Price', 'double', CreoleTypes::DECIMAL, true, 7);

		$tMap->addColumn('PRE_APPROVE', 'PreApprove', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 