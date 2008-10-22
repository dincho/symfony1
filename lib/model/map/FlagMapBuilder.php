<?php



class FlagMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.FlagMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('flag');
		$tMap->setPhpName('Flag');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER_ID', 'MemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('FLAGGER_ID', 'FlaggerId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('FLAG_CATEGORY_ID', 'FlagCategoryId', 'int', CreoleTypes::INTEGER, 'flag_category', 'ID', true, null);

		$tMap->addColumn('COMMENT', 'Comment', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('IS_HISTORY', 'IsHistory', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 