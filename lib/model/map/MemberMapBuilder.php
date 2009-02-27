<?php



class MemberMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member');
		$tMap->setPhpName('Member');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER_STATUS_ID', 'MemberStatusId', 'int', CreoleTypes::INTEGER, 'member_status', 'ID', false, null);

		$tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::CHAR, true, 40);

		$tMap->addColumn('NEW_PASSWORD', 'NewPassword', 'string', CreoleTypes::CHAR, false, 40);

		$tMap->addColumn('MUST_CHANGE_PWD', 'MustChangePwd', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('FIRST_NAME', 'FirstName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('LAST_NAME', 'LastName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('TMP_EMAIL', 'TmpEmail', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('HAS_EMAIL_CONFIRMATION', 'HasEmailConfirmation', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SEX', 'Sex', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('LOOKING_FOR', 'LookingFor', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addForeignKey('REVIEWED_BY_ID', 'ReviewedById', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

		$tMap->addColumn('REVIEWED_AT', 'ReviewedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('IS_STARRED', 'IsStarred', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('COUNTRY', 'Country', 'string', CreoleTypes::CHAR, true, 2);

		$tMap->addForeignKey('STATE_ID', 'StateId', 'int', CreoleTypes::INTEGER, 'state', 'ID', false, null);

		$tMap->addColumn('DISTRICT', 'District', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('CITY', 'City', 'string', CreoleTypes::VARCHAR, true, 60);

		$tMap->addColumn('ZIP', 'Zip', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('NATIONALITY', 'Nationality', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('LANGUAGE', 'Language', 'string', CreoleTypes::VARCHAR, true, 3);

		$tMap->addColumn('BIRTHDAY', 'Birthday', 'string', CreoleTypes::VARCHAR, false, null);

		$tMap->addColumn('DONT_DISPLAY_ZODIAC', 'DontDisplayZodiac', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('US_CITIZEN', 'UsCitizen', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('EMAIL_NOTIFICATIONS', 'EmailNotifications', 'int', CreoleTypes::TINYINT, false, null);

		$tMap->addColumn('DONT_USE_PHOTOS', 'DontUsePhotos', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CONTACT_ONLY_FULL_MEMBERS', 'ContactOnlyFullMembers', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('YOUTUBE_VID', 'YoutubeVid', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('ESSAY_HEADLINE', 'EssayHeadline', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ESSAY_INTRODUCTION', 'EssayIntroduction', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addForeignKey('MAIN_PHOTO_ID', 'MainPhotoId', 'int', CreoleTypes::INTEGER, 'member_photo', 'ID', false, null);

		$tMap->addForeignKey('SUBSCRIPTION_ID', 'SubscriptionId', 'int', CreoleTypes::INTEGER, 'subscription', 'ID', true, null);

		$tMap->addColumn('SUB_AUTO_RENEW', 'SubAutoRenew', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addForeignKey('MEMBER_COUNTER_ID', 'MemberCounterId', 'int', CreoleTypes::INTEGER, 'member_counter', 'ID', true, null);

		$tMap->addColumn('PUBLIC_SEARCH', 'PublicSearch', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('LAST_IP', 'LastIp', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('LAST_PAYPAL_SUBSCR_ID', 'LastPaypalSubscrId', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LAST_PAYPAL_ITEM', 'LastPaypalItem', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('PAYPAL_UNSUBSCRIBED_AT', 'PaypalUnsubscribedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_PAYPAL_PAYMENT_AT', 'LastPaypalPaymentAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_ACTIVITY', 'LastActivity', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_STATUS_CHANGE', 'LastStatusChange', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_FLAGGED', 'LastFlagged', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_LOGIN', 'LastLogin', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_WINKS_VIEW', 'LastWinksView', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_HOTLIST_VIEW', 'LastHotlistView', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_PROFILE_VIEW', 'LastProfileView', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_ACTIVITY_NOTIFICATION', 'LastActivityNotification', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('DASHBOARD_MSG', 'DashboardMsg', 'int', CreoleTypes::INTEGER, false, 1);

	} 
} 