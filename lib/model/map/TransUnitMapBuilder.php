<?php



class TransUnitMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TransUnitMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('trans_unit');
		$tMap->setPhpName('TransUnit');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('CAT_ID', 'CatId', 'int', CreoleTypes::INTEGER, 'catalogue', 'CAT_ID', true, 11);

		$tMap->addColumn('SOURCE', 'Source', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('TARGET', 'Target', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('COMMENTS', 'Comments', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('AUTHOR', 'Author', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('TRANSLATED', 'Translated', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('DATE_CREATED', 'DateCreated', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('DATE_MODIFIED', 'DateModified', 'int', CreoleTypes::INTEGER, true, 11);

	} 
} 