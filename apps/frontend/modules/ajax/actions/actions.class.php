<?php

/**
 * ajax actions.
 *
 * @package    pr
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class ajaxActions extends prActions
{

    public function executeGetStatesByCountry()
    {
        if ($country = $this->getRequestParameter('country'))
        {
            $states = StatePeer::getAllByCountry($country);
            
            $states_tmp = array();
            foreach ($states as $state)
            {
                $tmp['id'] = $state->getId();
                $tmp['title'] = $state->getTitle();
                $states_tmp[] = $tmp;
            }
            
            $output = json_encode($states_tmp);
            $this->getResponse()->setHttpHeader("X-JSON", '(' . $output . ')');
        }
        return sfView::HEADER_ONLY;
    }

    public function executeUsernameExists()
    {
        $username = $this->getRequestParameter('username');
        if( $username )
        {
            $member = MemberPeer::retrieveByUsername($username);
            $response =  ($member) ? '<p class="msg_error">Sorry, username "%USERNAME%" is already taken.</p>' : '<p class="msg_ok">Congratulations, your username "%USERNAME%" is available.</p>';
            
            sfLoader::loadHelpers(array('I18N'));
            
            return $this->renderText(sfContext::getInstance()->getI18N()->__($response, array('%USERNAME%' => $username)));
        } else {
            return sfView::NONE;
        }
    }
}
