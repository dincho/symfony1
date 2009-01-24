<?php


abstract class BaseMemberPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'member';

	
	const CLASS_DEFAULT = 'lib.model.Member';

	
	const NUM_COLUMNS = 50;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'member.ID';

	
	const MEMBER_STATUS_ID = 'member.MEMBER_STATUS_ID';

	
	const USERNAME = 'member.USERNAME';

	
	const PASSWORD = 'member.PASSWORD';

	
	const NEW_PASSWORD = 'member.NEW_PASSWORD';

	
	const MUST_CHANGE_PWD = 'member.MUST_CHANGE_PWD';

	
	const FIRST_NAME = 'member.FIRST_NAME';

	
	const LAST_NAME = 'member.LAST_NAME';

	
	const EMAIL = 'member.EMAIL';

	
	const TMP_EMAIL = 'member.TMP_EMAIL';

	
	const HAS_EMAIL_CONFIRMATION = 'member.HAS_EMAIL_CONFIRMATION';

	
	const SEX = 'member.SEX';

	
	const LOOKING_FOR = 'member.LOOKING_FOR';

	
	const REVIEWED_BY_ID = 'member.REVIEWED_BY_ID';

	
	const REVIEWED_AT = 'member.REVIEWED_AT';

	
	const IS_STARRED = 'member.IS_STARRED';

	
	const COUNTRY = 'member.COUNTRY';

	
	const STATE_ID = 'member.STATE_ID';

	
	const DISTRICT = 'member.DISTRICT';

	
	const CITY = 'member.CITY';

	
	const ZIP = 'member.ZIP';

	
	const NATIONALITY = 'member.NATIONALITY';

	
	const LANGUAGE = 'member.LANGUAGE';

	
	const BIRTHDAY = 'member.BIRTHDAY';

	
	const DONT_DISPLAY_ZODIAC = 'member.DONT_DISPLAY_ZODIAC';

	
	const US_CITIZEN = 'member.US_CITIZEN';

	
	const EMAIL_NOTIFICATIONS = 'member.EMAIL_NOTIFICATIONS';

	
	const DONT_USE_PHOTOS = 'member.DONT_USE_PHOTOS';

	
	const CONTACT_ONLY_FULL_MEMBERS = 'member.CONTACT_ONLY_FULL_MEMBERS';

	
	const YOUTUBE_VID = 'member.YOUTUBE_VID';

	
	const ESSAY_HEADLINE = 'member.ESSAY_HEADLINE';

	
	const ESSAY_INTRODUCTION = 'member.ESSAY_INTRODUCTION';

	
	const MAIN_PHOTO_ID = 'member.MAIN_PHOTO_ID';

	
	const SUBSCRIPTION_ID = 'member.SUBSCRIPTION_ID';

	
	const SUB_AUTO_RENEW = 'member.SUB_AUTO_RENEW';

	
	const MEMBER_COUNTER_ID = 'member.MEMBER_COUNTER_ID';

	
	const PUBLIC_SEARCH = 'member.PUBLIC_SEARCH';

	
	const LAST_PAYPAL_SUBSCR_ID = 'member.LAST_PAYPAL_SUBSCR_ID';

	
	const LAST_PAYPAL_ITEM = 'member.LAST_PAYPAL_ITEM';

	
	const PAYPAL_UNSUBSCRIBED_AT = 'member.PAYPAL_UNSUBSCRIBED_AT';

	
	const LAST_PAYPAL_PAYMENT_AT = 'member.LAST_PAYPAL_PAYMENT_AT';

	
	const LAST_ACTIVITY = 'member.LAST_ACTIVITY';

	
	const LAST_STATUS_CHANGE = 'member.LAST_STATUS_CHANGE';

	
	const LAST_FLAGGED = 'member.LAST_FLAGGED';

	
	const LAST_LOGIN = 'member.LAST_LOGIN';

	
	const LAST_WINKS_VIEW = 'member.LAST_WINKS_VIEW';

	
	const LAST_HOTLIST_VIEW = 'member.LAST_HOTLIST_VIEW';

	
	const LAST_PROFILE_VIEW = 'member.LAST_PROFILE_VIEW';

	
	const LAST_ACTIVITY_NOTIFICATION = 'member.LAST_ACTIVITY_NOTIFICATION';

	
	const CREATED_AT = 'member.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'MemberStatusId', 'Username', 'Password', 'NewPassword', 'MustChangePwd', 'FirstName', 'LastName', 'Email', 'TmpEmail', 'HasEmailConfirmation', 'Sex', 'LookingFor', 'ReviewedById', 'ReviewedAt', 'IsStarred', 'Country', 'StateId', 'District', 'City', 'Zip', 'Nationality', 'Language', 'Birthday', 'DontDisplayZodiac', 'UsCitizen', 'EmailNotifications', 'DontUsePhotos', 'ContactOnlyFullMembers', 'YoutubeVid', 'EssayHeadline', 'EssayIntroduction', 'MainPhotoId', 'SubscriptionId', 'SubAutoRenew', 'MemberCounterId', 'PublicSearch', 'LastPaypalSubscrId', 'LastPaypalItem', 'PaypalUnsubscribedAt', 'LastPaypalPaymentAt', 'LastActivity', 'LastStatusChange', 'LastFlagged', 'LastLogin', 'LastWinksView', 'LastHotlistView', 'LastProfileView', 'LastActivityNotification', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (MemberPeer::ID, MemberPeer::MEMBER_STATUS_ID, MemberPeer::USERNAME, MemberPeer::PASSWORD, MemberPeer::NEW_PASSWORD, MemberPeer::MUST_CHANGE_PWD, MemberPeer::FIRST_NAME, MemberPeer::LAST_NAME, MemberPeer::EMAIL, MemberPeer::TMP_EMAIL, MemberPeer::HAS_EMAIL_CONFIRMATION, MemberPeer::SEX, MemberPeer::LOOKING_FOR, MemberPeer::REVIEWED_BY_ID, MemberPeer::REVIEWED_AT, MemberPeer::IS_STARRED, MemberPeer::COUNTRY, MemberPeer::STATE_ID, MemberPeer::DISTRICT, MemberPeer::CITY, MemberPeer::ZIP, MemberPeer::NATIONALITY, MemberPeer::LANGUAGE, MemberPeer::BIRTHDAY, MemberPeer::DONT_DISPLAY_ZODIAC, MemberPeer::US_CITIZEN, MemberPeer::EMAIL_NOTIFICATIONS, MemberPeer::DONT_USE_PHOTOS, MemberPeer::CONTACT_ONLY_FULL_MEMBERS, MemberPeer::YOUTUBE_VID, MemberPeer::ESSAY_HEADLINE, MemberPeer::ESSAY_INTRODUCTION, MemberPeer::MAIN_PHOTO_ID, MemberPeer::SUBSCRIPTION_ID, MemberPeer::SUB_AUTO_RENEW, MemberPeer::MEMBER_COUNTER_ID, MemberPeer::PUBLIC_SEARCH, MemberPeer::LAST_PAYPAL_SUBSCR_ID, MemberPeer::LAST_PAYPAL_ITEM, MemberPeer::PAYPAL_UNSUBSCRIBED_AT, MemberPeer::LAST_PAYPAL_PAYMENT_AT, MemberPeer::LAST_ACTIVITY, MemberPeer::LAST_STATUS_CHANGE, MemberPeer::LAST_FLAGGED, MemberPeer::LAST_LOGIN, MemberPeer::LAST_WINKS_VIEW, MemberPeer::LAST_HOTLIST_VIEW, MemberPeer::LAST_PROFILE_VIEW, MemberPeer::LAST_ACTIVITY_NOTIFICATION, MemberPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'member_status_id', 'username', 'password', 'new_password', 'must_change_pwd', 'first_name', 'last_name', 'email', 'tmp_email', 'has_email_confirmation', 'sex', 'looking_for', 'reviewed_by_id', 'reviewed_at', 'is_starred', 'country', 'state_id', 'district', 'city', 'zip', 'nationality', 'language', 'birthday', 'dont_display_zodiac', 'us_citizen', 'email_notifications', 'dont_use_photos', 'contact_only_full_members', 'youtube_vid', 'essay_headline', 'essay_introduction', 'main_photo_id', 'subscription_id', 'sub_auto_renew', 'member_counter_id', 'public_search', 'last_paypal_subscr_id', 'last_paypal_item', 'paypal_unsubscribed_at', 'last_paypal_payment_at', 'last_activity', 'last_status_change', 'last_flagged', 'last_login', 'last_winks_view', 'last_hotlist_view', 'last_profile_view', 'last_activity_notification', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'MemberStatusId' => 1, 'Username' => 2, 'Password' => 3, 'NewPassword' => 4, 'MustChangePwd' => 5, 'FirstName' => 6, 'LastName' => 7, 'Email' => 8, 'TmpEmail' => 9, 'HasEmailConfirmation' => 10, 'Sex' => 11, 'LookingFor' => 12, 'ReviewedById' => 13, 'ReviewedAt' => 14, 'IsStarred' => 15, 'Country' => 16, 'StateId' => 17, 'District' => 18, 'City' => 19, 'Zip' => 20, 'Nationality' => 21, 'Language' => 22, 'Birthday' => 23, 'DontDisplayZodiac' => 24, 'UsCitizen' => 25, 'EmailNotifications' => 26, 'DontUsePhotos' => 27, 'ContactOnlyFullMembers' => 28, 'YoutubeVid' => 29, 'EssayHeadline' => 30, 'EssayIntroduction' => 31, 'MainPhotoId' => 32, 'SubscriptionId' => 33, 'SubAutoRenew' => 34, 'MemberCounterId' => 35, 'PublicSearch' => 36, 'LastPaypalSubscrId' => 37, 'LastPaypalItem' => 38, 'PaypalUnsubscribedAt' => 39, 'LastPaypalPaymentAt' => 40, 'LastActivity' => 41, 'LastStatusChange' => 42, 'LastFlagged' => 43, 'LastLogin' => 44, 'LastWinksView' => 45, 'LastHotlistView' => 46, 'LastProfileView' => 47, 'LastActivityNotification' => 48, 'CreatedAt' => 49, ),
		BasePeer::TYPE_COLNAME => array (MemberPeer::ID => 0, MemberPeer::MEMBER_STATUS_ID => 1, MemberPeer::USERNAME => 2, MemberPeer::PASSWORD => 3, MemberPeer::NEW_PASSWORD => 4, MemberPeer::MUST_CHANGE_PWD => 5, MemberPeer::FIRST_NAME => 6, MemberPeer::LAST_NAME => 7, MemberPeer::EMAIL => 8, MemberPeer::TMP_EMAIL => 9, MemberPeer::HAS_EMAIL_CONFIRMATION => 10, MemberPeer::SEX => 11, MemberPeer::LOOKING_FOR => 12, MemberPeer::REVIEWED_BY_ID => 13, MemberPeer::REVIEWED_AT => 14, MemberPeer::IS_STARRED => 15, MemberPeer::COUNTRY => 16, MemberPeer::STATE_ID => 17, MemberPeer::DISTRICT => 18, MemberPeer::CITY => 19, MemberPeer::ZIP => 20, MemberPeer::NATIONALITY => 21, MemberPeer::LANGUAGE => 22, MemberPeer::BIRTHDAY => 23, MemberPeer::DONT_DISPLAY_ZODIAC => 24, MemberPeer::US_CITIZEN => 25, MemberPeer::EMAIL_NOTIFICATIONS => 26, MemberPeer::DONT_USE_PHOTOS => 27, MemberPeer::CONTACT_ONLY_FULL_MEMBERS => 28, MemberPeer::YOUTUBE_VID => 29, MemberPeer::ESSAY_HEADLINE => 30, MemberPeer::ESSAY_INTRODUCTION => 31, MemberPeer::MAIN_PHOTO_ID => 32, MemberPeer::SUBSCRIPTION_ID => 33, MemberPeer::SUB_AUTO_RENEW => 34, MemberPeer::MEMBER_COUNTER_ID => 35, MemberPeer::PUBLIC_SEARCH => 36, MemberPeer::LAST_PAYPAL_SUBSCR_ID => 37, MemberPeer::LAST_PAYPAL_ITEM => 38, MemberPeer::PAYPAL_UNSUBSCRIBED_AT => 39, MemberPeer::LAST_PAYPAL_PAYMENT_AT => 40, MemberPeer::LAST_ACTIVITY => 41, MemberPeer::LAST_STATUS_CHANGE => 42, MemberPeer::LAST_FLAGGED => 43, MemberPeer::LAST_LOGIN => 44, MemberPeer::LAST_WINKS_VIEW => 45, MemberPeer::LAST_HOTLIST_VIEW => 46, MemberPeer::LAST_PROFILE_VIEW => 47, MemberPeer::LAST_ACTIVITY_NOTIFICATION => 48, MemberPeer::CREATED_AT => 49, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'member_status_id' => 1, 'username' => 2, 'password' => 3, 'new_password' => 4, 'must_change_pwd' => 5, 'first_name' => 6, 'last_name' => 7, 'email' => 8, 'tmp_email' => 9, 'has_email_confirmation' => 10, 'sex' => 11, 'looking_for' => 12, 'reviewed_by_id' => 13, 'reviewed_at' => 14, 'is_starred' => 15, 'country' => 16, 'state_id' => 17, 'district' => 18, 'city' => 19, 'zip' => 20, 'nationality' => 21, 'language' => 22, 'birthday' => 23, 'dont_display_zodiac' => 24, 'us_citizen' => 25, 'email_notifications' => 26, 'dont_use_photos' => 27, 'contact_only_full_members' => 28, 'youtube_vid' => 29, 'essay_headline' => 30, 'essay_introduction' => 31, 'main_photo_id' => 32, 'subscription_id' => 33, 'sub_auto_renew' => 34, 'member_counter_id' => 35, 'public_search' => 36, 'last_paypal_subscr_id' => 37, 'last_paypal_item' => 38, 'paypal_unsubscribed_at' => 39, 'last_paypal_payment_at' => 40, 'last_activity' => 41, 'last_status_change' => 42, 'last_flagged' => 43, 'last_login' => 44, 'last_winks_view' => 45, 'last_hotlist_view' => 46, 'last_profile_view' => 47, 'last_activity_notification' => 48, 'created_at' => 49, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MemberMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MemberMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MemberPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(MemberPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MemberPeer::ID);

		$criteria->addSelectColumn(MemberPeer::MEMBER_STATUS_ID);

		$criteria->addSelectColumn(MemberPeer::USERNAME);

		$criteria->addSelectColumn(MemberPeer::PASSWORD);

		$criteria->addSelectColumn(MemberPeer::NEW_PASSWORD);

		$criteria->addSelectColumn(MemberPeer::MUST_CHANGE_PWD);

		$criteria->addSelectColumn(MemberPeer::FIRST_NAME);

		$criteria->addSelectColumn(MemberPeer::LAST_NAME);

		$criteria->addSelectColumn(MemberPeer::EMAIL);

		$criteria->addSelectColumn(MemberPeer::TMP_EMAIL);

		$criteria->addSelectColumn(MemberPeer::HAS_EMAIL_CONFIRMATION);

		$criteria->addSelectColumn(MemberPeer::SEX);

		$criteria->addSelectColumn(MemberPeer::LOOKING_FOR);

		$criteria->addSelectColumn(MemberPeer::REVIEWED_BY_ID);

		$criteria->addSelectColumn(MemberPeer::REVIEWED_AT);

		$criteria->addSelectColumn(MemberPeer::IS_STARRED);

		$criteria->addSelectColumn(MemberPeer::COUNTRY);

		$criteria->addSelectColumn(MemberPeer::STATE_ID);

		$criteria->addSelectColumn(MemberPeer::DISTRICT);

		$criteria->addSelectColumn(MemberPeer::CITY);

		$criteria->addSelectColumn(MemberPeer::ZIP);

		$criteria->addSelectColumn(MemberPeer::NATIONALITY);

		$criteria->addSelectColumn(MemberPeer::LANGUAGE);

		$criteria->addSelectColumn(MemberPeer::BIRTHDAY);

		$criteria->addSelectColumn(MemberPeer::DONT_DISPLAY_ZODIAC);

		$criteria->addSelectColumn(MemberPeer::US_CITIZEN);

		$criteria->addSelectColumn(MemberPeer::EMAIL_NOTIFICATIONS);

		$criteria->addSelectColumn(MemberPeer::DONT_USE_PHOTOS);

		$criteria->addSelectColumn(MemberPeer::CONTACT_ONLY_FULL_MEMBERS);

		$criteria->addSelectColumn(MemberPeer::YOUTUBE_VID);

		$criteria->addSelectColumn(MemberPeer::ESSAY_HEADLINE);

		$criteria->addSelectColumn(MemberPeer::ESSAY_INTRODUCTION);

		$criteria->addSelectColumn(MemberPeer::MAIN_PHOTO_ID);

		$criteria->addSelectColumn(MemberPeer::SUBSCRIPTION_ID);

		$criteria->addSelectColumn(MemberPeer::SUB_AUTO_RENEW);

		$criteria->addSelectColumn(MemberPeer::MEMBER_COUNTER_ID);

		$criteria->addSelectColumn(MemberPeer::PUBLIC_SEARCH);

		$criteria->addSelectColumn(MemberPeer::LAST_PAYPAL_SUBSCR_ID);

		$criteria->addSelectColumn(MemberPeer::LAST_PAYPAL_ITEM);

		$criteria->addSelectColumn(MemberPeer::PAYPAL_UNSUBSCRIBED_AT);

		$criteria->addSelectColumn(MemberPeer::LAST_PAYPAL_PAYMENT_AT);

		$criteria->addSelectColumn(MemberPeer::LAST_ACTIVITY);

		$criteria->addSelectColumn(MemberPeer::LAST_STATUS_CHANGE);

		$criteria->addSelectColumn(MemberPeer::LAST_FLAGGED);

		$criteria->addSelectColumn(MemberPeer::LAST_LOGIN);

		$criteria->addSelectColumn(MemberPeer::LAST_WINKS_VIEW);

		$criteria->addSelectColumn(MemberPeer::LAST_HOTLIST_VIEW);

		$criteria->addSelectColumn(MemberPeer::LAST_PROFILE_VIEW);

		$criteria->addSelectColumn(MemberPeer::LAST_ACTIVITY_NOTIFICATION);

		$criteria->addSelectColumn(MemberPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(member.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT member.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = MemberPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MemberPeer::populateObjects(MemberPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseMemberPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MemberPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MemberPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinMemberStatus(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinState(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinMemberPhoto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinSubscription(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinMemberCounter(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinMemberStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberStatusPeer::addSelectColumns($c);

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStatusPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMember($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinUser(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMember($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinState(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		StatePeer::addSelectColumns($c);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = StatePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getState(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMember($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinMemberPhoto(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberPhotoPeer::addSelectColumns($c);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberPhotoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMember($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinSubscription(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		SubscriptionPeer::addSelectColumns($c);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = SubscriptionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getSubscription(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMember($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinMemberCounter(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberCounterPeer::addSelectColumns($c);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberCounterPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMemberCounter(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMember($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + StatePeer::NUM_COLUMNS;

		MemberPhotoPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + MemberPhotoPeer::NUM_COLUMNS;

		SubscriptionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + SubscriptionPeer::NUM_COLUMNS;

		MemberCounterPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + MemberCounterPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = MemberStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}


					
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}


					
			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getState(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}


					
			$omClass = MemberPhotoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}


					
			$omClass = SubscriptionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6 = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getSubscription(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}


					
			$omClass = MemberCounterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7 = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getMemberCounter(); 				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addMember($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj7->initMembers();
				$obj7->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptMemberStatus(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptState(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptMemberPhoto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptSubscription(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptMemberCounter(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MemberPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$rs = MemberPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptMemberStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		UserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + UserPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + StatePeer::NUM_COLUMNS;

		MemberPhotoPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + MemberPhotoPeer::NUM_COLUMNS;

		SubscriptionPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + SubscriptionPeer::NUM_COLUMNS;

		MemberCounterPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + MemberCounterPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getState(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}

			$omClass = MemberPhotoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}

			$omClass = SubscriptionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getSubscription(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}

			$omClass = MemberCounterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getMemberCounter(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptUser(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + StatePeer::NUM_COLUMNS;

		MemberPhotoPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + MemberPhotoPeer::NUM_COLUMNS;

		SubscriptionPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + SubscriptionPeer::NUM_COLUMNS;

		MemberCounterPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + MemberCounterPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getState(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}

			$omClass = MemberPhotoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}

			$omClass = SubscriptionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getSubscription(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}

			$omClass = MemberCounterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getMemberCounter(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptState(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		MemberPhotoPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + MemberPhotoPeer::NUM_COLUMNS;

		SubscriptionPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + SubscriptionPeer::NUM_COLUMNS;

		MemberCounterPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + MemberCounterPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}

			$omClass = MemberPhotoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}

			$omClass = SubscriptionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getSubscription(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}

			$omClass = MemberCounterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getMemberCounter(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptMemberPhoto(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + StatePeer::NUM_COLUMNS;

		SubscriptionPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + SubscriptionPeer::NUM_COLUMNS;

		MemberCounterPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + MemberCounterPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getState(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}

			$omClass = SubscriptionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getSubscription(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}

			$omClass = MemberCounterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getMemberCounter(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptSubscription(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + StatePeer::NUM_COLUMNS;

		MemberPhotoPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + MemberPhotoPeer::NUM_COLUMNS;

		MemberCounterPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + MemberCounterPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getState(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}

			$omClass = MemberPhotoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}

			$omClass = MemberCounterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getMemberCounter(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptMemberCounter(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MemberPeer::addSelectColumns($c);
		$startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MemberStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		StatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + StatePeer::NUM_COLUMNS;

		MemberPhotoPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + MemberPhotoPeer::NUM_COLUMNS;

		SubscriptionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + SubscriptionPeer::NUM_COLUMNS;

		$c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);

		$c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);

		$c->addJoin(MemberPeer::STATE_ID, StatePeer::ID);

		$c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID);

		$c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMemberStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initMembers();
				$obj2->addMember($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initMembers();
				$obj3->addMember($obj1);
			}

			$omClass = StatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getState(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initMembers();
				$obj4->addMember($obj1);
			}

			$omClass = MemberPhotoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getMemberPhoto(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initMembers();
				$obj5->addMember($obj1);
			}

			$omClass = SubscriptionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getSubscription(); 				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addMember($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initMembers();
				$obj6->addMember($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return MemberPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(MemberPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseMemberPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMemberPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMemberPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(MemberPeer::ID);
			$selectCriteria->add(MemberPeer::ID, $criteria->remove(MemberPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMemberPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMemberPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(MemberPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(MemberPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Member) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MemberPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(Member $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MemberPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MemberPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(MemberPeer::DATABASE_NAME, MemberPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MemberPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(MemberPeer::DATABASE_NAME);

		$criteria->add(MemberPeer::ID, $pk);


		$v = MemberPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(MemberPeer::ID, $pks, Criteria::IN);
			$objs = MemberPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMemberPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MemberMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MemberMapBuilder');
}
