<?php



class IpnHistoryMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.IpnHistoryMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ipn_history');
		$tMap->setPhpName('IpnHistory');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PARAMETERS', 'Parameters', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('REQUEST_IP', 'RequestIp', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TXN_TYPE', 'TxnType', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('TXN_ID', 'TxnId', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUBSCR_ID', 'SubscrId', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('PAYMENT_STATUS', 'PaymentStatus', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('PAYPAL_RESPONSE', 'PaypalResponse', 'string', CreoleTypes::VARCHAR, false, 8);

		$tMap->addColumn('IS_RENEWAL', 'IsRenewal', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('MEMBER_SUBSCR_ID', 'MemberSubscrId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 