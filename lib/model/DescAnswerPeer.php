<?php

/**
 * Subclass for performing query and update operations on the 'desc_answer' table.
 *
 *
 *
 * @package lib.model
 */
class DescAnswerPeer extends BaseDescAnswerPeer
{
    public static function getAnswersAssoc()
    {
        $answers = array();
        $answers_obj = DescAnswerPeer::doSelect(new Criteria());
        foreach ($answers_obj as $answer_obj) {
            $answers[$answer_obj->getDescQuestionId()][] = $answer_obj;
        }

        return $answers;
    }

    public static function getAnswersAssocById()
    {
        $answers = array();
        $answers_obj = DescAnswerPeer::doSelect(new Criteria());
        foreach ($answers_obj as $answer_obj) {
            $answers[$answer_obj->getId()] = $answer_obj;
        }

        return $answers;
    }
}
