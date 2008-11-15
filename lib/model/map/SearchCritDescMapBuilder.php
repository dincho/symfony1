<?php



class SearchCritDescMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SearchCritDescMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('search_crit_desc');
		$tMap->setPhpName('SearchCritDesc');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER_ID', 'MemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('DESC_QUESTION_ID', 'DescQuestionId', 'int', CreoleTypes::INTEGER, 'desc_question', 'ID', true, null);

		$tMap->addColumn('DESC_ANSWERS', 'DescAnswers', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('MATCH_WEIGHT', 'MatchWeight', 'int', CreoleTypes::TINYINT, true, null);

	} 
} 