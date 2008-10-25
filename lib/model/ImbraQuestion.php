<?php

/**
 * Subclass for representing a row from the 'imbra_question' table.
 *
 * 
 *
 * @package lib.model
 */
class ImbraQuestion extends BaseImbraQuestion
{

    public function hasBothAnswers()
    {
        return (! is_null($this->getNegativeAnswer()) && ! is_null($this->getPositiveAnswer()));
    }

    public function getParsedAnswer(BaseMember $member, $member_answers = array())
    {
        $text = '';
        $params = array();
        sfLoader::loadHelpers(array('I18N'));
        
        if (isset($member_answers[$this->getId()]))
        {
            $params['{explanation}'] = $member_answers[$this->getId()]->getExplanation();
            $text = ($member_answers[$this->getId()]->getAnswer() == 1) ? $this->getPositiveAnswer() : $this->getNegativeAnswer();
        }
        
        $params['{Name}'] = $member->getFullName();
        
        if ($member->getSex() == 'M')
        {
            $params['{he}'] = __('he');
            $params['{his}'] = __('his');
            $params['{wife}'] = __('wife');
        } else
        {
            $params['{he}'] = __('she');
            $params['{his}'] = __('her');
            $params['{wife}'] = __('husband');
        }
        
        return strtr($text, $params);
    }
}
