<?php

/**
 * dashboard actions.
 *
 * @package    pr
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class dashboardActions extends sfActions
{
	public function executeList()
	{
		$this->forward('dashboard', 'index');
	}
	
    public function executeIndex()
    {
        $c = new Criteria();
        $c->add(SessionStoragePeer::USER_ID, NULL, Criteria::ISNOTNULL);
        $c->add(SessionStoragePeer::USER_ID, 0, Criteria::NOT_EQUAL);
        $c->addJoin(SessionStoragePeer::USER_ID, MemberPeer::ID);
        $c->clearSelectColumns()->addSelectColumn('COUNT(DISTINCT session_storage.USER_ID)');
        $c->add(MemberPeer::SEX, 'M');
        
        $rs = SessionStoragePeer::doSelectRS($c);
        $this->males_online = ($rs->next()) ? $rs->getInt(1) : 0;
        
        $c1 = clone $c;
        $c1->add(MemberPeer::SEX, 'F');
        $rs = SessionStoragePeer::doSelectRS($c1);
        $this->females_online = ($rs->next()) ? $rs->getInt(1) : 0;

				$this->members_pending_review = Dashboard::getMembersPendingReview();
				$this->pending_imbras = Dashboard::getPendingImbras();
				$this->flags_pending_review = Dashboard::getFlagsPendingReview();
				$this->member_feedback_for_reply = Dashboard::getMemberFeedbackForReply();
				$this->external_feedback_for_reply = Dashboard::getExternalFeedbackForReply();
				$this->deletions_pending_review = Dashboard::getNewDeletions();
				$this->new_abandonations = Dashboard::getNewAbandonations();
				$this->bug_suggestions_feedback = Dashboard::getBugsSuggestionsFeedback();
				$this->messages_pending_review = Dashboard::getMessagesPendingReview();
				$this->pending_flagging_suspension = Dashboard::getPendingFlaggingSuspension();
    }
}
