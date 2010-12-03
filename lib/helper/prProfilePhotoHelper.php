<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Feb 3, 2009 1:07:02 PM
 * 
 */
use_helper('prLink');
 
function profile_photo($profile, $class="")
{
    if( $profile->isActive() )
    {
        return image_tag($profile->getMainPhoto()->getImg('80x100'));
    } else {
        return image_tag('no_photo/' . $profile->getSex() . '/80x100.jpg');
    }
}

function profile_small_photo($profile)
{
  $image_tag = image_tag($profile->getMainPhoto()->getImg('30x30'));
  return ( $profile->isActive() ) ? link_to_ref($image_tag, '@profile?pager=1&bc=search&username=' . $profile->getUsername()) : $image_tag;
}

function profile_photo_dash_visitors($profile, $class="")
{
    if( $profile->isActive() )
    {
        return link_to_ref(image_tag($profile->getMainPhoto()->getImg('80x100')), '@profile?pager=1&bc=search&username='.$profile->getUsername());
    } else {
        return content_tag('div', __('Sorry, this profile is no longer available'), array('class' => 'profile_not_available ' . $class));
    }
}

function profile_thumbnail_photo_tag($profile, $size = '50x50')
{
  return image_tag($profile->getMainPhoto()->getImg($size));
}

function unless_profile_thumbnail_photo_tag($profile, $size = '30x30')
{
  if(!is_null($profile->getMainPhotoId()))
  {
    return image_tag($profile->getMemberPhoto()->getImg($size));
  }
  else 
  {
    return image_tag('no_photo/' . $profile->getSex() . '/30x21.gif');
  }
}