<?php



class UserMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UserMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('user');
		$tMap->setPhpName('User');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::CHAR, true, 40);

		$tMap->addColumn('FIRST_NAME', 'FirstName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('LAST_NAME', 'LastName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('DASHBOARD_MOD', 'DashboardMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('DASHBOARD_MOD_TYPE', 'DashboardModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('MEMBERS_MOD', 'MembersMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('MEMBERS_MOD_TYPE', 'MembersModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('CONTENT_MOD', 'ContentMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CONTENT_MOD_TYPE', 'ContentModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('SUBSCRIPTIONS_MOD', 'SubscriptionsMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SUBSCRIPTIONS_MOD_TYPE', 'SubscriptionsModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('MESSAGES_MOD', 'MessagesMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('MESSAGES_MOD_TYPE', 'MessagesModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('FLAGS_MOD', 'FlagsMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('FLAGS_MOD_TYPE', 'FlagsModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('IMBRA_MOD', 'ImbraMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IMBRA_MOD_TYPE', 'ImbraModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('REPORTS_MOD', 'ReportsMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('REPORTS_MOD_TYPE', 'ReportsModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('USERS_MOD', 'UsersMod', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('USERS_MOD_TYPE', 'UsersModType', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('MUST_CHANGE_PWD', 'MustChangePwd', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_SUPERUSER', 'IsSuperuser', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_ENABLED', 'IsEnabled', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('LAST_LOGIN', 'LastLogin', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 