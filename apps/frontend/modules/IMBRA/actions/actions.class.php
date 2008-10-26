<?php
/**
 * IMBRA actions.
 *
 * @package    pr
 * @subpackage IMBRA
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class IMBRAActions extends sfActions
{

    public function executeIndex()
    {
        $member = $this->getUser()->getProfile();
        //$this->imbra_questions = ImbraQuestionPeer::doSelect(new Criteria());
        $questions = ImbraQuestionPeer::getAllAssocWithID();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $new_imbra = new MemberImbra();
            $new_imbra->setMemberId($member->getId());
            $new_imbra->setImbraStatusId(ImbraStatusPeer::PENDING);
            $new_imbra->setName($this->getRequestParameter('name'));
            $new_imbra->setDob($this->getRequestParameter('dob'));
            $new_imbra->setAddress($this->getRequestParameter('address'));
            $new_imbra->setCity($this->getRequestParameter('city'));
            $new_imbra->setStateId($this->getRequestParameter('state_id'));
            $new_imbra->setZip($this->getRequestParameter('zip'));
            $new_imbra->setPhone($this->getRequestParameter('phone'));
            $explains = $this->getRequestParameter('explains');
            
            $answers = $this->getRequestParameter('answers', array());
            foreach ( $questions as $question )
            {
                $answer = (isset($answers[$question->getId()])) ? $answers[$question->getId()] : 0;
                $member_answer = new MemberImbraAnswer();
                $member_answer->setMemberImbra($new_imbra);
                $member_answer->setImbraQuestionId($question->getId());
                $member_answer->setAnswer($answer);
                $expl = ( (int) $answer == 1 || $question->getOnlyExplain() ) ? $explains[$question->getId()] : null;
                $member_answer->setExplanation($expl);
                $member_answer->save();                    

            }
            $new_imbra->save();
            
            $this->redirect('dashboard/index');
        }
        $this->imbra = $member->getLastImbra();
        $this->imbra_questions = $questions;
        if ($this->imbra)
        {
            $this->imbra_answers = $this->imbra->getImbraAnswersArray();
        } else
        {
            $this->imbra = new MemberImbra();
            $this->imbra_answers = array();
        }
    }

    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $questions = ImbraQuestionPeer::getAllAssocWithID();
            $has_error = false;
            $answers = $this->getRequestParameter('answers', array());
            $explains = $this->getRequestParameter('explains', array());
            foreach ($questions as $question)
            {
                if (! isset($answers[$question->getId()]) || is_null($answers[$question->getId()]))
                {
                    if (!$question->getOnlyExplain() || (! isset($explains[$question->getId()]) || ! $explains[$question->getId()]))
                    {
                        $has_error = true;
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'required');
                    }
                } elseif (($answers[$question->getId()] == 1 || $question->getOnlyExplain()) && (! isset($explains[$question->getId()]) || ! $explains[$question->getId()]))
                {
                    $has_error = true;
                    $this->getRequest()->setError('explains[' . $question->getId() . ']', 'required');
                }
            }
            if ($has_error)
            {
                $this->setFlash('dont_show_errors', true);
                $this->setFlash('msg_error', 'You must fill out the missing information below indicated in red.');
                return false;
            }
        }
        return true;
    }

    public function handleErrorIndex()
    {
        $member = $this->getUser()->getProfile();
        $this->imbra = $member->getLastImbra();
        $this->imbra_questions = ImbraQuestionPeer::doSelect(new Criteria());
        if ($this->imbra)
        {
            $this->imbra_answers = $this->imbra->getImbraAnswersArray();
        } else
        {
            $this->imbra = new MemberImbra();
            $this->imbra_answers = array();
        }
        return sfView::SUCCESS;
    }

    public function executeConfirmImbraStatus()
    {
        $us_citizen = $this->getRequestParameter('US_citizen', null);
        if (! is_null($us_citizen))
        {
            $member = $this->getUser()->getProfile();
            if ($us_citizen == 0)
            {
                $member->setUsCitizen(false);
                $member->save();
                $this->redirect('dashboard/index');
            }
            if ($us_citizen == 1)
            {
                $member->setUsCitizen(true);
                $member->save();
                $this->redirect('editProfile/imbra');
            }
        }
    }
}
