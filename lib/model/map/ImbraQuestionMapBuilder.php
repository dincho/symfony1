<?php



class ImbraQuestionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ImbraQuestionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('imbra_question');
		$tMap->setPhpName('ImbraQuestion');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('EXPLAIN_TITLE', 'ExplainTitle', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('POSITIVE_ANSWER', 'PositiveAnswer', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('NEGATIVE_ANSWER', 'NegativeAnswer', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('ONLY_EXPLAIN', 'OnlyExplain', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 