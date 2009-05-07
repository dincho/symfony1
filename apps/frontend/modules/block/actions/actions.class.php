<?php
/**
 * block actions.
 *
 * @package    pr
 * @subpackage block
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class blockActions extends prActions
{

    public function executeIndex()
    {
        $c = new Criteria();
        $c->addDescendingOrderByColumn(BlockPeer::CREATED_AT);
        $c->add(BlockPeer::MEMBER_ID, $this->getUser()->getId());
        $this->blocks = BlockPeer::doSelectJoinMemberRelatedByProfileId($c);
    }

    public function executeAdd()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        $block = new Block();
        $block->setMemberId($this->getUser()->getId());
        $block->setProfileId($profile->getId());
        $block->save();
        $msg_ok = sfI18N::getInstance()->__('You just blocked %USERNAME% from seeing and contacting you. To undo, <a href="%UNDO_URL%" class="sec_link">click here</a>.', 
                array('%USERNAME%' => $profile->getUsername(), '%UNDO_URL%' => $this->getController()->genUrl('block/remove?id=' . $block->getId())));
        $this->setFlash('msg_ok', $msg_ok);
        
        $this->redirect('@profile?username=' . $profile->getUsername());
    }

    public function validateAdd()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        
        if( $this->getUser()->getId() == $profile->getId() )
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            $this->redirect('profile/index?username=' . $profile->getUsername() );
        }

				if( $profile->getStatusId() != StatusPeer::ACTIVE )
				{
					$this->setFlash('msg_error', sfI18N::getInstance()->__('%USERNAME%\'s Profile is no longer available', array('%USERNAME%' => $profile->getUsername())));
					$this->redirectToReferer();
				}
                
        $c = new Criteria();
        $c->add(BlockPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(BlockPeer::PROFILE_ID, $profile->getId());
        $cnt = BlockPeer::doCount($c);
        if ($cnt > 0)
        {
            $this->getRequest()->setError('block', 'This member is already in your block list.');
            return false;
        }
        return true;
    }

    public function handleErrorAdd()
    {
        $c = new Criteria();
        $c->addDescendingOrderByColumn(BlockPeer::CREATED_AT);
        $c->add(BlockPeer::MEMBER_ID, $this->getUser()->getId());
        $this->blocks = BlockPeer::doSelectJoinMemberRelatedByProfileId($c);

        $this->getUser()->getBC()->removeLast();
        $this->setTemplate('index');
        return sfView::SUCCESS;
    }

    public function executeRemove()
    {
        $c = new Criteria();
        $c->add(BlockPeer::ID, $this->getRequestParameter('id'));
        $c->add(BlockPeer::MEMBER_ID, $this->getUser()->getId());
        $block = BlockPeer::doSelectOne($c);
        $this->forward404Unless($block);
        $block->delete();
        $username = $block->getMemberRelatedByProfileId()->getUsername();
        
        $msg = 'You have just unblocked %USERNAME%.';
        $ref = $this->getUser()->getRefererUrl();
        if( stripos($ref, 'profile/index') ) $msg .= ' Click here to see <a href="%PROFILE_URL%" class="sec_link">full profile</a>';
        $msg_ok = sfI18N::getInstance()->__($msg, array('%USERNAME%' => $username, '%PROFILE_URL%' => $this->getController()->genUrl('@profile?username=' . $username)));
        $this->setFlash('msg_ok', $msg_ok);
        
        $this->redirectToReferer();
        //$this->redirect('@blocked_members');
    }
}
