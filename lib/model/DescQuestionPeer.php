<?php

/**
 * Subclass for performing query and update operations on the 'desc_question' table.
 *
 *
 *
 * @package lib.model
 */
class DescQuestionPeer extends BaseDescQuestionPeer
{
    public static function getQuestionsAssoc()
    {
        $questions = array();
        $questions_obj = self::doSelect(new Criteria());
        foreach ($questions_obj as $question_obj) {
            $questions[$question_obj->getId()] = $question_obj;
        }

        return $questions;
    }
}
