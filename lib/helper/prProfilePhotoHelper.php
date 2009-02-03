<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Feb 3, 2009 1:07:02 PM
 * 
 */
 
function profile_photo($profile, $class="")
{
    if( $profile->isActive() )
    {
        return image_tag($profile->getMainPhoto()->getImg('80x100'));
    } else {
        return content_tag('div', __('Sorry, this profile is no longer available'), array('class' => 'profile_not_available ' . $class));
    }
}
