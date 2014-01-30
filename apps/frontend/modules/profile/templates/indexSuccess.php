<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink', 'Window') ?>

<?php $public_photos = $member->getPublicMemberPhotos(null, null, sfConfig::get('app_settings_profile_max_photos')); ?>
<?php $private_photos = $member->getPrivateMemberPhotos(null, null, sfConfig::get('app_settings_profile_max_private_photos')); ?>

<div id="profile_left" style="padding-top: 9px">
    <p class="photo_authenticity"><?php echo ($member->hasAuthPhoto()) ? __('photo authenticity verified') : __('photo authenticity not verified'); ?></p><br class="clear" />
    <div style="min-height: 350px">
        <?php _addLbRessources(); ?>
              
        <?php if( !is_null($member->getMainPhotoId()) ): //has main photo ?>
                
               <?php echo content_tag('a', image_tag($member->getMainPhoto()->getImg('350x350', 'file'), array('id' => 'member_image')), 
                                    array('href' => $member->getMainPhoto()->getImg(null, 'file'),
                                          'rel' => 'lightbox[public_photos]',
                                          'title' => $member->getUsername(),
                                          'id' => 'member_image_link'
                                )); ?>
                
        <?php elseif( count($private_photos) > 0 && $private_photos_perm ):?>
                <?php $mainPhoto = $private_photos[0]; ?>
                <?php echo content_tag('a', image_tag($mainPhoto->getImg('350x350', 'file'), array('id' => 'member_image')), 
                                    array('href' => $mainPhoto->getImg(null, 'file'),
                                          'rel' => 'lightbox[private_photos]',
                                          'title' => $member->getUsername(),
                                          'id' => 'member_image_link'
                                )); ?>
        <?php else : ?>
            <?php echo image_tag($member->getMainPhoto()->getImg('350x350', 'file')); ?>
        <?php endif; ?>
    </div>
    
    <?php include_partial('profile/photos', array('photos' => $public_photos, 'member' => $member, 'block_id' => 'public_photos')); ?>
    
    <?php if( count($private_photos) > 0 ): ?>
        <hr />

        <?php if( $show_request_warning ): ?>
            <?php echo javascript_include_tag('messagebar') ?>
            <?php echo javascript_tag('messagebar_message("' . $request_warning . '");' ); ?>
        <?php endif; ?>

        <?php if( $private_photos_perm ): ?>
            <p class="private_photos_headline"><?php echo __('%USERNAME% has private photos below and you have access to them. Click to enlarge.', array('%USERNAME%' => $member->getUsername())); ?></p>
            <?php include_partial('profile/photos', array('photos' => $private_photos, 'member' => $member, 'block_id' => 'private_photos')); ?>
        <?php else: ?>
            <?php if( $private_photos_request ): ?>
              <p class="private_photos_headline"><?php echo __('You already requested access to %USERNAME%\'s private photos.', array('%USERNAME%' => $member->getUsername())); ?></p>
            <?php else: ?>
              <div id="private_photos" class="private_photos_headline">
                <?php echo __('%USERNAME% has private photos.', array('%USERNAME%' => $member->getUsername()))." " . link_to_remote( __('Request access.'), array(
                                        'url' => '@send_private_photos_request?toggle_link=1&username=' . $member->getUsername(),
                                        'update' => array('success' => 'msg_container'),
                                        'script' => true, 
                                ), array('id' => 'photo_req_link', 'class' => 'sec_link', )); ?><br />
              </div>
            <?php endif; ?>

            <?php for($i=0; $i<count($private_photos); $i++): ?>
                <?php echo image_tag('/images/no_photo/'. $member->getSex() .'/50x50_lock.jpg', array('class' => 'thumb')); ?>
            <?php endfor; ?>
          <?php endif; ?>
    <?php endif; ?>
    
    <?php if( sfConfig::get('app_settings_profile_display_video') && $member->getYoutubeVid() ): ?>
        <br /><br />
        <object width="350" height="355">
            <param name="movie" value="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=0"></param>
            <param name="wmode" value="transparent"></param>
            <embed src="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=0" type="application/x-shockwave-flash" wmode="transparent" width="350" height="355"></embed>
        </object>
    <?php endif; ?>
    <p style="width: 350px;"><?php echo nl2br($member->getEssayIntroduction()) ?></p>
</div>


<div id="profile_right">
    <div id="profile_pager">
        <?php include_partial('profile_pager', array('pager' => $profile_pager)); ?>
    </div>
   
   <div id="profile_top">
        <?php if( $sf_user->getProfile() && $sf_user->getProfile()->hasWinkTo($member->getId()) ): ?>
            <span class="sec_link"><?php echo __('Wink'); ?></span>
        <?php else: ?>
            <?php echo link_to_remote(__('Wink'), 
                                      array('url'     => 'winks/send?profile_id=' . $member->getId(),
                                            'update'  => 'msg_container',
                                            'success' => '$("wink_link").removeAttribute("onclick"); $("wink_link").addClassName("inactive_link");'
                                          ),
                                      array('class' => 'sec_link',
                                            'id'    => 'wink_link', 
                                            )
                        ); ?>
        <?php endif; ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        
        
        <?php if( $messageThread ): ?>
            <?php echo link_to(__('Send Mail'), 'messages/thread?id=' . $messageThread->getId(), array('class' => 'sec_link')); ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php else: ?>
            <?php echo link_to_prototype_window(__('Send Mail'), 'send_message', array('title' => __('Send Message to %USERNAME%', array('%USERNAME%' => $member->getUsername())), 
                                                            'url'            => 'messages/send?layout=window&recipient_id=' . $member->getId(), 
                                                            'id'             => '"send_message_window"', 
                                                            'width'          => '550', 
                                                            'height'         => '460',
                                                            'center'         => 'true', 
                                                            'minimizable'    => 'false',
                                                            'maximizable'    => 'false',
                                                            'closable'       => 'true', 
                                                            'destroyOnClose' => "true",
                                                            'showEffect'     => 'Element.show',
                                                            'onBeforeShow'   => 'function(event) {
                                                                $("send_message_link").hide();
                                                                $("send_message_span").show();
                                                            }', 
                                                            'onClose'        => 'function() { 
                                                                    if($("send_message_span")) $("send_message_span").hide();
                                                                    if($("send_message_link")) $("send_message_link").show();
                                                                 }',
                                                            'className'      => 'polishdate',
                                                        ), array('class' => 'sec_link', 
                                                                 'id'    => 'send_message_link'
                                                        )); ?>
                                                
                                                          
            <?php //used when the popup window is shown, so user can't click again on the below links ?>
            <span class="sec_link" id="send_message_span" style="display: none;"><?php echo __('Send Mail'); ?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php endif; ?>
         
        <?php $hotlist_link_title = ( $sf_user->getProfile()->hasInHotlist($member->getId()) ) ? __('Remove from Hotlist') : __('Add to Hotlist'); ?>
        <?php echo link_to_remote($hotlist_link_title,
                                  array('url'     => 'hotlist/toggle?update_selector=hotlist_link&profile_id=' . $member->getId(),
                                        'update'  => 'msg_container',
                                        'script'  => true
                                      ),
                                  array('class' => 'sec_link',
                                        'id'    => 'hotlist_link', 
                                        )
                    ); ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;


        <?php $block_link_title = ( $sf_user->getProfile() && $sf_user->getProfile()->hasBlockFor($member->getId()) ) ? __('Unblock') : __('Block'); ?>
        <?php echo link_to_remote($block_link_title,
                                  array('url'     => 'block/toggle?update_selector=block_link&profile_id=' . $member->getId(),
                                        'update'  => 'msg_container',
                                        'script'  => true
                                      ),
                                  array('class' => 'sec_link',
                                        'id'    => 'block_link', 
                                        )
                    ); ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
                    
        <?php echo link_to_prototype_window(__('Flag'), 'flag_profile', array('title'          => __('Flag %USERNAME%', array('%USERNAME%' => $member->getUsername())), 
                                                                                'url'            => 'content/flag?layout=window&username=' . $member->getUsername(), 
                                                                                'id'             => '"flag_profile_window"', 
                                                                                'width'          => '550', 
                                                                                'height'         => '200',
                                                                                'center'         => 'true', 
                                                                                'minimizable'    => 'false',
                                                                                'maximizable'    => 'false',
                                                                                'closable'       => 'true', 
                                                                                'destroyOnClose' => "true",
                                                                                'className'      => 'polishdate',
                                                                            ), 
                                                                         array('absolute'        => false, 
                                                                               'id'              => 'flag_profile_link_window',
                                                                               'class'           => 'sec_link',
                                                                             )); ?>
   </div>
    <span class="profile_gift">
        <?php if( $member->getMillionaire() ): ?>
            <div class="millionaire_mark"><?php echo __('M'); ?></div>
        <?php endif; ?>
        
        <?php include_partial('profile/membership', array('member' => $member)); ?>
        
        <br class="clear" />
    </span>
    <div id="profile_double_box">
        <div class="left">
            <div class="middle">
                <?php if( $match): ?>
                    <?php if( $sf_user->getProfile()->hasSearchCriteria() ): ?>
                        <?php echo __('%she_he% matches you: %MATCH%%', array('%MATCH%' => $match->getPct(), '%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?><br />
                    <?php else: ?>
                        <?php echo __('%she_he% matches you: (no result)', array('%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?><br />
                    <?php endif; ?>
                    
                    <?php if( $member->hasSearchCriteria() ): ?>
                        <?php echo __('You match %her_him%: %REVERSE_MATCH%%', array('%REVERSE_MATCH%' => $match->getReversePct(), '%her_him%' => ( $member->getSex() == 'M' ) ? __('him') : __('her'))) ?><br />
                    <?php else: ?>
                        <?php echo __('You match %her_him%: (no result)', array('%her_him%' => ( $member->getSex() == 'M' ) ? __('him') : __('her'))) ?><br />
                    <?php endif; ?>
                    
                    <?php if( $match->getCombinedPct() > 0 ): ?>
                        <?php echo __('Your combined match is: %COMBINED_MATCH%%', array('%COMBINED_MATCH%' => $match->getCombinedPct()) ) ?><br />
                    <?php endif; ?> 
                <?php endif; ?>
            </div>
        </div>
        <div class="right">
            <div class="middle">
                <?php if( $member->isLoggedIn() ): ?>
                    <?php echo __('Currently Online') ?>
                <?php else: ?>
                    <?php echo __('Last log in: ') ?>
                    <?php echo time_ago_in_words($member->getLastLogin(null)) ?>
                <?php endif; ?>
                <br />
                <?php echo __('Profile ID:') . '&nbsp;' . $member->getId(); ?><br />
                <?php echo __('Viewed by %count% visitors', array('%count%' => $member->getCounter('ProfileViews'))) ?>
            </div>
        </div>
    </div>
    <br />
    <?php echo link_to_remote(
        ($grant_private_photos_perm) ?
            __(
                'Revoke private photos view permissions',
                array('%USERNAME%' => $member->getUsername())
            ) :
            __(
                'Grant private photos view permissions',
                array('%USERNAME%' => $member->getUsername())
            ),
        array(
            'url' => '@toggle_private_photos_perm?toggle_link=1&username=' . $member->getUsername(),
            'update' => array('success' => 'msg_container'),
            'script' => true,
        ),
        array(
            'id' => 'photo_perm_link',
            'class' => 'sec_link' . ($grant_private_photos_perm ? ' red' : ''
            )
        )
    ); ?><br/><br/>

    <ul id="currentRatingStars" class="rating star<?php echo $rate; ?>">
      <li class="one">
        <?php echo link_to_remote('1',array(
          'url'         =>  'profile/rate?id='.$member->getId().'&rate=1',
          'update'      =>  'rateMessage',
          'complete'  =>  'changeRate(json)'
        ),array(
          'title' => __('1 Star')
        )) ?>
      </li>
      <li class="two">
        <?php echo link_to_remote('2',array(
          'url'         =>  'profile/rate?id='.$member->getId().'&rate=2',
          'update'      =>  'rateMessage',
          'complete'  =>  'changeRate(json)'
        ),array(
          'title' => __('2 Star')
        )) ?>
      </li>
      <li class="three">
        <?php echo link_to_remote('3',array(
          'url'         =>  'profile/rate?id='.$member->getId().'&rate=3',
          'update'      =>  'rateMessage',
          'complete'  =>  'changeRate(json)'
        ),array(
          'title' => __('3 Star')
        )) ?>
      </li>
      <li class="four">
        <?php echo link_to_remote('4',array(
          'url'         =>  'profile/rate?id='.$member->getId().'&rate=4',
          'update'      =>  'rateMessage',
          'complete'  =>  'changeRate(json)'
        ),array(
          'title' => __('4 Star')
        )) ?>
      </li>
      <li class="five">
        <?php echo link_to_remote('5',array(
          'url'         =>  'profile/rate?id='.$member->getId().'&rate=5',
          'update'      =>  'rateMessage',
          'complete'  =>  'changeRate(json)'
        ),array(
          'title' => __('5 Star')
        )) ?>
      </li>
    </ul>    
    <div id="rateMessage" style="float: left">
        <?php if( $rate == 0 ): ?>
            <?php echo __('rate this member')?>
        <?php else: ?>
            <?php echo __("You gave this member %NB% star", array('%NB%' => $rate)); ?>
        <?php endif; ?>
    </div>
    <br class="clear" />
    <?php if( $sf_user->getProfile()->getPrivateDating()): ?>
        <?php echo link_to_remote( ( $has_privacy_perm ) ? 
                                      __('%USERNAME% can see you. Do not let %USERNAME% see you.', array('%USERNAME%' => $member->getUsername())) : 
                                      __('%USERNAME% cannot see you. Let %USERNAME% see you.', array('%USERNAME%' => $member->getUsername())), 
                                  array(
                                    'url' => '@toggle_privacy_perm?toggle_link=1&username=' . $member->getUsername(),
                                    'update' => array('success' => 'msg_container'),
                                    'script' => true, 
                            ), array('id' => 'privacy_link', 'class' => 'sec_link', )); ?><br /><br />
    <?php endif; ?>


    <?php include_component('profile', 'descMap', array('member' => $member, 'sf_cache_key' => $member->getId())); ?>
    <?php include_partial('profile/recent_activities', array('member' => $member)); ?>

</div>

<br class="clear" />


<?php echo javascript_tag('function changeRate(json){ 
  $("currentRatingStars").className = "rating star" + json.currentRate;
  $("currentRate").innerHTML = json.currentRate;
}') ?>

