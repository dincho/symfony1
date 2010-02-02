<?php
function pr_link_to($name = '', $internal_uri = '', $options = array())
{
    $current_uri = sfRouting::getInstance()->getCurrentInternalUri();
    return link_to_unless( ereg($internal_uri, $current_uri) , $name, $internal_uri, $options);
}

function link_to_ref($name = '', $internal_uri = '', $options = array())
{
    $ret_uri = remove_return_url(sfRouting::getInstance()->getCurrentInternalUri());
    $ret_uri = strtr(base64_encode($ret_uri), '+/=', '-_,');
    
    $ref = array('query_string' => 'return_url=' . $ret_uri);
    $options = array_merge($options, $ref);
    
    return link_to($name, $internal_uri, $options);
}

function link_to_if_ref($condition, $name = '', $internal_uri = '', $options = array())
{
    $ret_uri = remove_return_url(sfRouting::getInstance()->getCurrentInternalUri());
    $ret_uri = strtr(base64_encode($ret_uri), '+/=', '-_,');
    
    $ref = array('query_string' => 'return_url=' . $ret_uri);
    return link_to_if($condition, $name, $internal_uri, $options);
}

function link_to_unless_ref($condition, $name = '', $url = '', $options = array())
{
    return link_to_if_ref(!$condition, $name, $url, $options);
}

function remove_return_url($url)
{
    $url = preg_replace('/(return_url=.+&)/i', '', $url);
    return $url;
}


function url_for_activity($activity)
{
    switch ($activity->getActivity()) {
        case 'mailed':
                return ($activity->getActionId()) ? 'messages/thread?id=' . $activity->getActionId() : '#';
            break;        
            
            case 'winked':
                return '@winks';
            break;
            
            case 'hotlisted':
                return '@hotlist';
            break;
            
            case 'visited':
                return '@visitors';
            break;                        
        
        default:
                return '@dashboard';
            break;
    }
}

function link_for_extra_activity_field($activity, $member)
{
    $viewer = sfContext::getInstance()->getUser()->getProfile();
    
    static $has_matual_wink = null;
    static $has_matual_hotlist = null;
    
    switch ($activity->getActivity()) {
        case 'mailed':
                return link_to(__('see all'), 'messages/index', array('class' => 'sec_link') );
            break;        
            
            case 'winked':
                if( is_null($has_matual_wink) )
                {
                    $has_matual_wink = (bool) (
                                                ( $activity->getMemberId() == $viewer->getId() && $member->hasWinkTo($viewer->getId()) ) ||  
                                                ( $activity->getMemberId() == $member->getId() && $viewer->hasWinkTo($member->getId()) )
                                               );
                }            
                return ($has_matual_wink) ? image_tag('/images/heart.gif', array('width' => 13, 'height' => 11, 'onmouseover' => 'RA_balloon.showTooltip(event,"'. __('You both winked at each other') .'")')) : null;
            break;
            
            case 'hotlisted':
                if( is_null($has_matual_hotlist) )
                {
                    $has_matual_hotlist = (bool) (
                                                ( $activity->getMemberId() == $viewer->getId() && $member->hasInHotlist($viewer->getId()) ) ||  
                                                ( $activity->getMemberId() == $member->getId() && $viewer->hasInHotlist($member->getId()) )
                                               );
                }            
                return ($has_matual_hotlist) ? image_tag('/images/heart.gif', array('width' => 13, 'height' => 11, 'onmouseover' => 'RA_balloon.showTooltip(event,"'. __('You both added themselves to the hotlist') .'")')) : null;
            break;
                                   
        
        default:
                return null;
            break;
    }    
}