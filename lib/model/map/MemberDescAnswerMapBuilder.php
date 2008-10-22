<?php



class MemberDescAnswerMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MemberDescAnswerMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('member_desc_answer');
		$tMap->setPhpName('MemberDescAnswer');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('MEMBER_ID', 'MemberId', 'int', CreoleTypes::INTEGER, 'member', 'ID', true, null);

		$tMap->addForeignKey('DESC_QUESTION_ID', 'DescQuestionId', 'int', CreoleTypes::INTEGER, 'desc_question', 'ID', true, null);

		$tMap->addColumn('DESC_ANSWER_ID', 'DescAnswerId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('OTHER', 'Other', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CUSTOM', 'Custom', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 