<?php



class MsgCollectionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MsgCollectionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('msg_collection');
		$tMap->setPhpName('MsgCollection');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('TRANS_COLLECTION_ID', 'TransCollectionId', 'int', CreoleTypes::INTEGER, 'trans_collection', 'ID', false, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 