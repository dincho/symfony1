<?php



class HomepageMemberStoryMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.HomepageMemberStoryMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('homepage_member_story');
		$tMap->setPhpName('HomepageMemberStory');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('MEMBER_STORIES', 'MemberStories', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('HOMEPAGE_CULTURE', 'HomepageCulture', 'string', CreoleTypes::VARCHAR, false, 7);

	} 
} 