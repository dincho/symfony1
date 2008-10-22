<?php



class DescAnswerMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DescAnswerMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('desc_answer');
		$tMap->setPhpName('DescAnswer');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('DESC_QUESTION_ID', 'DescQuestionId', 'int', CreoleTypes::INTEGER, 'desc_question', 'ID', true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('SEARCH_TITLE', 'SearchTitle', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 