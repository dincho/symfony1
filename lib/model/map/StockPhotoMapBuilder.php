<?php



class StockPhotoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.StockPhotoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('stock_photo');
		$tMap->setPhpName('StockPhoto');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('FILE', 'File', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CROPPED', 'Cropped', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('GENDER', 'Gender', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('HOMEPAGES', 'Homepages', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 