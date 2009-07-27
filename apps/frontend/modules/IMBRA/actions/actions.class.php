<?php
/**
 * IMBRA actions.
 *
 * @package    pr
 * @subpackage IMBRA
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class IMBRAActions extends prActions
{

    public function executeIndex()
    {
        $member = $this->getUser()->getProfile();
        //$this->imbra_questions = ImbraQuestionPeer::doSelect(new Criteria());
        $questions = ImbraQuestionPeer::getAllAssocWithID();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $new_imbra = new MemberImbra();
            $new_imbra->setCulture('en');
            $new_imbra->setMemberId($member->getId());
            $new_imbra->setImbraStatusId(ImbraStatusPeer::PENDING);
            $new_imbra->setName($this->getRequestParameter('name'));
            $new_imbra->setDob($this->getRequestParameter('dob'));
            $new_imbra->setAddress($this->getRequestParameter('address'));
            $new_imbra->setCity($this->getRequestParameter('city'));
            $new_imbra->setAdm1Id($this->getRequestParameter('adm1_id'));
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

	    $member = $this->getUser()->getProfile();
	    $member->setUsCitizen(true);
	    $member->save();

            $this->getUser()->completeRegistration();
            if( !$member->mustPayIMBRA()) $this->setFlash('msg_ok', 'Your IMBRA Information have been updated');
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
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'IMBRA: You must fill out the missing information below indicated in red.');
                    }
                } elseif (($answers[$question->getId()] == 1 || $question->getOnlyExplain()) && (! isset($explains[$question->getId()]) || ! $explains[$question->getId()]))
                {
                    $has_error = true;
                    $this->getRequest()->setError('explains[' . $question->getId() . ']', 'IMBRA: You must fill out the missing information below indicated in red.');
                }
            }
            
            if ($has_error)
            {
                $this->setFlash('only_last_error', true);
                return false;
            }
        }
        return true;
    }

    public function handleErrorIndex()
    {
        $member = $this->getUser()->getProfile();
        $this->imbra = $member->getLastImbra();
        $this->imbra_questions = ImbraQuestionPeer::doSelectWithI18n(new Criteria());
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
        if ( !is_null($us_citizen) )
        {
            $member = $this->getUser()->getProfile();
            if ($us_citizen == 0)
            {
                $member->setUsCitizen(false);
                $member->save();
                $this->getUser()->completeRegistration();
                $this->redirect('dashboard/index');
            }
            if ($us_citizen == 1)
            {
                $member->setUsCitizen(true);
                $member->save();
                $this->redirect('IMBRA/index');
            }
        }
    }
    
    public function executePayment()
    {
        $member = $this->getUser()->getProfile();
        //$this->forward404Unless($member->getSubscriptionId() == SubscriptionPeer::FREE);
        $this->getUser()->getBC()->clear()->add(array('name' => 'IMBRA Information', 'uri' => 'IMBRA/index'))->add(array('name' => 'IMBRA Payment'));
        $this->amount = 39;
        
        $EWP = new sfEWP();
        $parameters = array("cmd" => "_xclick",
                            "business" => sfConfig::get('app_paypal_business'),
                            "item_name" => 'IMBRA Application',
                            'item_number' => 'imbra',
                            'lc' => 'US',
                            'no_note' => 1,
                            'no_shipping' => 1,
                            'currency_code' => 'GBP',
                            'rm' => 1, //return method 1 = GET, 2 = POST
                            'notify_url' => $this->getController()->genUrl(sfConfig::get('app_paypal_notify_url'), true), 
                            'return' => $this->getController()->genUrl('IMBRA/paymentConfirmation', true),
                            'cancel_return' => $this->getController()->genUrl('IMBRA/paymentCanceled', true),
                            'amount' => $this->amount,
                            'custom' => $member->getUsername(),
                            
        );
        
        $this->member = $member;
        $this->encrypted = $EWP->encryptFields($parameters);    	
    }
    
    public function executePaymentConfirmation()
    {
    	$this->getUser()->getBC()->clear()->add(array('name' => 'IMBRA Confirmation'));
    }
    
    public function executePaymentCanceled()
    {
        $bc = $this->getUser()->getBC();
        $bc->clear();
        
        if( $this->getUser()->isAuthenticated() )
        {
        	$bc->add(array('name' => 'Dashboard', 'uri' => '@dashboard'));
        }
        
        $bc->add(array('name' => 'IMBRA Information', 'uri' => 'IMBRA/index'));
        $bc->add(array('name' => 'Payment Canceled'));
    }
}
