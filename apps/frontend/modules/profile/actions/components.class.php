<?php
class profileComponents extends sfComponents
{
    public function executeDescMap()
    {
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssocById();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
    }

}