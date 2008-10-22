<?php



class MemberImbraAnswerMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberImbraAnswerMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member_imbra_answer');
		$tMap->setPhpName('MemberImbraAnswer');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER_IMBRA_ID', 'MemberImbraId', 'int', CreoleTypes::INTEGER, 'member_imbra', 'ID', true, null);

		$tMap->addForeignKey('IMBRA_QUESTION_ID', 'ImbraQuestionId', 'int', CreoleTypes::INTEGER, 'imbra_question', 'ID', true, null);

		$tMap->addColumn('ANSWER', 'Answer', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('EXPLANATION', 'Explanation', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 