<?php



class ImbraQuestionI18nMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ImbraQuestionI18nMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('imbra_question_i18n');
		$tMap->setPhpName('ImbraQuestionI18n');

		$tMap->setUseIdGenerator(false);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('EXPLAIN_TITLE', 'ExplainTitle', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('POSITIVE_ANSWER', 'PositiveAnswer', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('NEGATIVE_ANSWER', 'NegativeAnswer', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'imbra_question', 'ID', true, null);

		$tMap->addPrimaryKey('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, true, 7);

	} 
} 