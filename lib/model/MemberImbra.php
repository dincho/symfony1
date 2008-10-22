<?php
/**
 * Subclass for representing a row from the 'member_imbra' table.
 *
 * 
 *
 * @package lib.model
 */
class MemberImbra extends BaseMemberImbra
{

    /*
	 * @return integer
	 */
    public function getDaysIn()
    {
        return floor((time() - $this->getCreatedAt(null)) / (24 * 60 * 60));
    }

    /*
	 * @return bool
	 * check if any of the answers of the imbra is yes/true
	 */
    public function isPossibleDenial()
    {
        $c = new Criteria();
        $c->addJoin(MemberImbraAnswerPeer::MEMBER_IMBRA_ID, MemberImbraPeer::ID);
        $c->add(MemberImbraPeer::MEMBER_ID, $this->getMemberId());
        $c->add(MemberImbraAnswerPeer::ANSWER, true);
        $answers = MemberImbraAnswerPeer::doCount($c);
        return ($answers > 0) ? true : false;
    }

    public function getImbraAnswersArray()
    {
        $return = array();
        foreach ($this->getMemberImbraAnswers() as $answer)
        {
            $return[$answer->getImbraQuestionId()] = $answer;
        }
        return $return;
    }
}

