<?php

/**
 * Subclass for performing query and update operations on the 'imbra_question' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ImbraQuestionPeer extends BaseImbraQuestionPeer
{
    public static function getAllAssocWithID()
    {
        $return = array();
        $questions = self::doSelectWithI18n(new Criteria());
        
        foreach ($questions as $question)
        {
            $return[$question->getId()] = $question;
        }
        
        return $return;
    }
}
