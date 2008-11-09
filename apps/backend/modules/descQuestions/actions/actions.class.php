<?php

/**
 * descQuestions actions.
 *
 * @package    PolishRomance
 * @subpackage descQuestions
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class descQuestionsActions extends sfActions
{

    public function preExecute()
    {
        $this->top_menu_selected = 'staticPages';
    }

    public function executeList()
    {
        $this->getUser()->getBC()->clear()->add(array('name' => 'Desc Questions', 'uri' => 'descQuestions/list'));
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
    }
}
