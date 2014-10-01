<?php
/**
 * Subclass for performing query and update operations on the 'member_desc_answer' table.
 *
 *
 *
 * @package lib.model
 */
class MemberDescAnswerPeer extends BaseMemberDescAnswerPeer
{

    public static function getAnswersAssoc($member_id = null)
    {
        $member_answers = array();

        $c = new Criteria();
        $c->add(self::MEMBER_ID, $member_id);
        $member_answers_obj = self::doSelect($c);

        foreach ($member_answers_obj as $member_answer_obj) {
            $member_answers[$member_answer_obj->getDescQuestionId()] = $member_answer_obj;
        }

        return $member_answers;
    }
}
