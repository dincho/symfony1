<?php
/**
 * Subclass for representing a row from the 'desc_question' table.
 *
 * 
 *
 * @package lib.model
 */
class DescQuestion extends BaseDescQuestion
{

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getMemberDescAnswer()
    {
        if ($answers = $this->getMemberDescAnswers())
        {
            return $answers[0]->getDescAnswer();
        }
    }

    public function getMemberSearchCriteria()
    {
        if ($answers = $this->getMemberSearchCriterias())
        {
            return $answers[0]->getDescAnswer();
        }
    }

    public function getSearchCritDescAnswers()
    {
        $ret = array();
        if ($crit = $this->getSearchCritDescs())
        {
            $ret = explode(',', $crit[0]->getDescAnswers());
        }
        return $ret;
    }

    public function getSearchCritDescFirstAnswer()
    {
        return ($answers = $this->getSearchCritDescAnswers()) ? $answers[0] : null;
    }

    public function getSearchCritDescLastAnswer()
    {
        return ($answers = $this->getSearchCritDescAnswers()) ? $answers[count($answers) - 1] : null;
    }

    public function getSearchCritDesc()
    {
        if ($crit = $this->getSearchCritDescs())
        {
            return $crit[0];
        }
    }
}
