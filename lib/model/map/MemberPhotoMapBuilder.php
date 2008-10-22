<?php



class MemberPhotoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberPhotoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member_photo');
		$tMap->setPhpName('MemberPhoto');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER_ID', 'MemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', false, null);

		$tMap->addColumn('FILE', 'File', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CROPPED', 'Cropped', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('IS_MAIN', 'IsMain', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 