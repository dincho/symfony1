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
        $c->add(BlockPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addDescendingOrderByColumn(BlockPeer::CREATED_AT);
        $this->blocks = BlockPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $this->getUser()->getBC()->replaceLast(array('name' => 'Blocked members headline'));
    }
    
    public function executeToggle()
    {
        $this->forward404Unless($this->getRequestParameter('profile_id'));
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        
        $member = $this->getUser()->getProfile();
        
        $c = new Criteria();
        $c->add(BlockPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(BlockPeer::PROFILE_ID, $profile->getId());
        $block = BlockPeer::doSelectOne($c);
        
        if( $block )
        {
            $block->delete();
            $username = $profile->getUsername();
            
            $msg = 'You have just unblocked %USERNAME%.';
            if( $this->getRequestParameter('show_profile_link') ) $msg .= ' Click here to see <a href="%PROFILE_URL%" class="sec_link">full profile</a>';
            $msg_ok = sfI18N::getInstance()->__($msg, array('%USERNAME%' => $username, '%PROFILE_URL%' => $this->getController()->genUrl('@profile?username=' . $username)));
                    
        } else {
            
            $block = new Block();
            $block->setMemberId($member->getId());
            $block->setProfileId($profile->getId());
            $block->save();

            sfLoader::LoadHelpers(array('Url', 'Javascript', 'Tag'));
            
            $undo_url = 'block/toggle?undo=1&profile_id=' . $profile->getId();
            if( $this->getRequestParameter('update_selector') ) $undo_url .= '&update_selector=' . $this->getRequestParameter('update_selector');
            if( $this->getRequestParameter('show_element') ) $undo_url .= '&show_element=' . $this->getRequestParameter('show_element');
            
            $undo_link = link_to_remote(__('click here'),
                                  array('url'     => $undo_url,
                                        'update'  => 'msg_container',
                                        'script'  => true
                                      ),
                                  array('class' => 'sec_link',)
                    );
                                
            $msg_ok = sfI18N::getInstance()->__('You just blocked %USERNAME% from seeing and contacting you. To undo, %UNDO_LINK%.', 
                                          array('%USERNAME%' => $profile->getUsername(), 
                                                '%UNDO_LINK%' => $undo_link)
                            );

        }
        
        $this->setFlash('msg_ok', $msg_ok, false);
        $this->block = $block;
    }
    
    public function validateToggle()
    {
        if( $this->getUser()->getId() == $this->getRequestParameter('profile_id') )
        {
            $this->getRequest()->setError('block', 'You can\'t use this function on your own profile');
            
            return false;
        }
        
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        
        if( $profile->getMemberStatusId() != MemberStatusPeer::ACTIVE )
        {
            $this->getRequest()->setError('block', sfI18N::getInstance()->__('%USERNAME%\'s Profile is no longer available', array('%USERNAME%' => $profile->getUsername())));
            return false;
        }        
        
        return true;
    }
    
    public function handleErrorToggle()
    {
        $this->getResponse()->setStatusCode(400);
        return $this->renderText(get_partial('content/formErrors'));
    }    
}
