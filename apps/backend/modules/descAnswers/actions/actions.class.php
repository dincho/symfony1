<?php

/**
 * descAnswers actions.
 *
 * @package    PolishRomance
 * @subpackage descAnswers
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class descAnswersActions extends sfActions
{
    public function preExecute()
    {
        if ($this->getRequestParameter('question_id')) {
            $this->question = DescQuestionPeer::retrieveByPK($this->getRequestParameter('question_id'));
            $this->forward404Unless($this->question);
        } elseif ( $this->getRequestParameter('id')) {
            $this->answer = DescAnswerPeer::retrieveByPK($this->getRequestParameter('id'));
            $this->forward404Unless($this->answer);
            $this->question = $this->answer->getDescQuestion();
        }

        $this->left_menu_selected = 'Desc. Questions';
        $this->top_menu_selected = 'content';

        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Desc Questions', 'uri' => 'descQuestions/list'));
        $bc->add(array('name' => $this->question->getTitle(), 'uri' => 'descAnswers/list?question_id=' . $this->question->getId()));
    }

    public function executeList()
    {
        $this->forward404Unless($this->question);

        $c = new Criteria();
        $c->add(DescAnswerPeer::DESC_QUESTION_ID, $this->question->getId());
        $this->answers = DescAnswerPeer::doSelect($c);
    }

    public function executeEdit()
    {
        $this->getUser()->getBC()->add(array('name' => $this->answer->getTitle(), 'uri' => 'descAnswers/edit?id=' . $this->answer->getId()));

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->answer->setTitle($this->getRequestParameter('title'));
            $this->answer->setSearchTitle($this->getRequestParameter('search_title'));
            $this->answer->save();

            $this->setFlash('msg_ok', 'Your changes have been saved.');
            $this->redirect('descAnswers/list?question_id=' . $this->question->getId());
        }
    }

    public function executeCreate()
    {
        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $answer = new DescAnswer();
            $answer->setDescQuestionId($this->question->getId());
            $answer->setTitle($this->getRequestParameter('title'));
            $answer->setSearchTitle($this->getRequestParameter('search_title'));
            $answer->save();

            $this->setFlash('msg_ok', 'New answer have been added.');
            $this->redirect('descAnswers/list?question_id=' . $this->question->getId());
        }
    }

    public function executeDelete()
    {
        $this->answer->delete();
        $this->setFlash('msg_ok', 'Answer have been deleted.');
        $this->redirect('descAnswers/list?question_id=' . $this->question->getId());
    }
}
