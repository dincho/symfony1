<?php



class MemberImbraI18nMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberImbraI18nMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member_imbra_i18n');
		$tMap->setPhpName('MemberImbraI18n');

		$tMap->setUseIdGenerator(false);

		$tMap->addColumn('TEXT', 'Text', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'member_imbra', 'ID', true, null);

		$tMap->addPrimaryKey('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, true, 7);

	} 
} 