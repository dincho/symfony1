<?php
/**
 * hotlist actions.
 *
 * @package    pr
 * @subpackage hotlist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class hotlistActions extends prActions
{
    public function executeIndex()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));

        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $this->hotlists = HotlistPeer::doSelectJoinMemberRelatedByProfileId($c);

        $c = new Criteria();
        $c->add(HotlistPeer::PROFILE_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles

        //privacy check
        $c->addJoin(HotlistPeer::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. HotlistPeer::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);

        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $this->others_hotlists = HotlistPeer::doSelectJoinMemberRelatedByMemberId($c);
    }

    public function executeToggle()
    {
        $this->forward404Unless($this->getRequestParameter('profile_id'));
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);

        $member = $this->getUser()->getProfile();

        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $member->getId());
        $c->add(HotlistPeer::PROFILE_ID, $profile->getId());
        $hotlist = HotlistPeer::doSelectOne($c);

        if ($hotlist) {
            $hotlist->delete();

            sfLoader::LoadHelpers(array('Url', 'Javascript', 'Tag'));

            $undo_url = 'hotlist/toggle?undo=1&profile_id=' . $profile->getId();
            if( $this->getRequestParameter('update_selector') ) $undo_url .= '&update_selector=' . $this->getRequestParameter('update_selector');
            if( $this->getRequestParameter('show_element') ) $undo_url .= '&show_element=' . $this->getRequestParameter('show_element');

            $undo_link = link_to_remote(__('click here'),
                                  array('url'     => $undo_url,
                                        'update'  => 'msg_container',
                                        'script'  => true
                                      ),
                                  array('class' => 'sec_link',
                                        )
                    );

            $msg_ok = sfI18N::getInstance()->__('%USERNAME% has been removed from your hotlist. To undo, %UNDO_LINK%.',
                                          array('%USERNAME%' => $profile->getUsername(),
                                                '%UNDO_LINK%' => $undo_link)
                            );

        } else {
            $undo = (bool) $this->getRequestParameter('undo');

            $hotlist = new Hotlist();
            $hotlist->setMemberId($member->getId());
            $hotlist->setProfileId($profile->getId());
            $hotlist->save(null, !$undo);

            if (!$member->getPrivateDating() || $member->hasOpenPrivacyFor($profile->getId())) {
                if ($profile->getEmailNotifications() === 0) {
                    Events::triggerAccountActivityHotlist($profile, $member);
                }

                MemberNotificationPeer::addNotification(
                    $profile,
                    $member,
                    MemberNotificationPeer::HOTLIST
                );
            }

            $msg_ok = sfI18N::getInstance()->__('%USERNAME% has been added to your hotlist. <a href="%URL_FOR_HOTLIST%" class="sec_link">See your hot-list</a>',
                                          array('%USERNAME%' => $profile->getUsername()));
        }

        $this->setFlash('msg_ok', $msg_ok, false);
        $this->hotlist = $hotlist;
    }

    public function validateToggle()
    {
        if ( $this->getUser()->getId() == $this->getRequestParameter('profile_id') ) {
            $this->getRequest()->setError('hotlist', 'You can\'t use this function on your own profile');

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
