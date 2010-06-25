<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<?php $member_photos = $member->getMemberPhotos(sfConfig::get('app_settings_profile_max_photos')); ?>

<div id="profile_left" style="padding-top: 14px">
    <p class="photo_authenticity"><?php echo ($member->hasAuthPhoto()) ? __('photo authenticity verified') : __('photo authenticity not verified'); ?></p>
    <div style="min-height: 350px">
        <?php 
              _addLbRessources();
              
              if( !is_null($member->getMainPhotoId()) ): //has main photo
                
                echo content_tag('a', image_tag($member->getMainPhoto()->getImg('350x350', 'file'), array('id' => 'member_image')), 
                                    array('href' => $member->getMainPhoto()->getImageUrlPath('file'),
                                          'rel' => 'lightbox[slide]',
                                          'title' => $member->getUsername(),
                                          'id' => 'member_image_link'
                                ));
                foreach ($member_photos as $photo):
                    echo content_tag('a', null, array('href' => $photo->getImageUrlPath('file'), 'rel' => 'lightbox[slide]'));
                endforeach;
                
              else: //has no main photo ( this means no photos at all ), so lightbox and link should not be applied
                echo image_tag($member->getMainPhoto()->getImg('350x350', 'file'));
              endif; 
        ?>
    </div>
    <?php $i=1;foreach ($member_photos as $photo): ?>
        <?php if ($member->getMainPhoto()->getId() == $photo->getId()): ?>
            <?php $class = 'current_thumb';?>
            <script type="text/javascript">current_thumb_id = <?php echo $photo->getId() ?>;</script>
        <?php else: ?>
            <?php $class = 'thumb'; ?>
        <?php endif; ?>
        <?php $the_img = image_tag($photo->getImg('50x50'), array('id' => 'thumb_' . $photo->getId(), 'class' => $class)); ?>
        <?php echo link_to_function($the_img, 'show_profile_image("'. $photo->getImg('350x350', 'file').'", '. $photo->getId() .', "'. $photo->getImageUrlPath('file') .'")', array()) ?>
        <?php if($i++ % 6 == 0 ): ?>
            <br />
        <?php endif; ?>
    <?php endforeach; ?>
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
        <?php $cancel_url =  strtr(base64_encode(sfRouting::getInstance()->getCurrentInternalUri()), '+/=', '-_,'); ?>
        <?php echo link_to_unless_ref($sf_user->getProfile() && $sf_user->getProfile()->hasWinkTo($member->getId()), __('Wink'), 'winks/send?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php echo link_to(__('Send Mail'), 'messages/send?recipient_id=' . $member->getId() . '&cancel_url=' . $cancel_url, 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        

        <?php if( $sf_user->getProfile()->hasInHotlist($member->getId()) ): ?>
         <?php echo link_to_ref(__('Remove from Hotlist'), 'hotlist/delete?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php else: ?>
            <?php echo link_to_ref(__('Add to Hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php endif; ?>

        <?php if( $sf_user->getProfile() && $sf_user->getProfile()->hasBlockFor($member->getId()) ): ?>
            <?php echo link_to(__('Unblock'), 'block/remove?profile_id=' . $member->getId(), 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php else: ?>
            <?php echo link_to(__('Block'), 'block/add?profile_id=' . $member->getId(), 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php endif; ?>
        
        <?php echo link_to(__('Flag'), 'content/flag?username=' . $member->getUsername() . ($sf_request->hasParameter('pager')?'&pager=1':''), 'class=sec_link') ?>
   </div>
    <span class="profile_gift">
        <?php if( $member->getMillionaire() ): ?>
            <div class="millionaire_mark"><?php echo __('M'); ?></div>
        <?php endif; ?>
        <div class="membership">
            <?php if( $member->getSubscriptionId() != SubscriptionPeer::FREE ): ?>
              <?php echo link_to(image_tag($sf_user->getCulture().'/full_member.gif'), 'subscription/index') ?>
            <?php elseif(sfConfig::get('app_settings_enable_gifts')): ?>
              <?php echo image_tag($sf_user->getCulture().'/buy_gift_' . $member->getSex() . '.gif'); ?>
            <?php endif; ?>
        </div>
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
                    
                    <?php if( $match->getCombinedMatch() > 0 ): ?>
                        <?php echo __('Your combined match is: %COMBINED_MATCH%%', array('%COMBINED_MATCH%' => $match->getCombinedMatch()) ) ?><br />
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
    <br>

    <div>

    <?php /* <ul id="currentRatingStars" class="rating star<?php echo round($member->getRate()) ?>" style="float: left; margin-right: 5px"> */ ?>
      <ul id="currentRatingStars" class="rating star<?php echo $member->getMemberRate() ?>" style="float: left; margin-right: 5px">
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
      <li style="float: left">
        aaaa
        dsfdfsd
      </li>
    </ul>    
    &nbsp;&nbsp;&nbsp;&nbsp;
    <div id="rateMessage" style="float: left"></div> <br class="clear">
    
    <!-- <div style="clear: both"> -->

    <?php include_component('profile', 'descMap', array('member' => $member, 'sf_cache_key' => $member->getId())); ?>
    <?php include_partial('profile/recent_activities', array('member' => $member)); ?>
    </div> 
</div>

<br class="clear" />

<?php if(!sfConfig::get('app_settings_imbra_disable') && $imbra ): ?>
    <a name="profile_imbra_info" class="sec_link"><?php echo link_to_function('[<span id="profile_imbra_details_tick">-</span>] ' . __('IMBRA Information'), 'show_hide_tick("profile_imbra_details")', 'class=sec_link') ?></a>
    <div id="profile_imbra_details">
        <p class="profile_imbra_version">
            <?php echo __('Member since: ' . $member->getCreatedAt('m/d/y')) ?><br />
            <?php echo __('Imbra updated %TIMES% times. Most recently on %IMBRA_DATE%', array('%TIMES%' => $member->countMemberImbras(), '%IMBRA_DATE%' => $imbra->getCreatedAt('m/d/Y'))) ?>
        </p>
        <?php echo $sf_data->getRaw('imbra')->getText(); ?>
        <p>
            <?php echo $imbra->getName() ?><br />
            <?php echo $imbra->getCreatedAt('%B %d, %Y') ?><br />
            <?php echo __('Born ') .  $imbra->getDob()?><br />
            <?php printf('%s, %s, USA', $imbra->getCity(), $imbra->getGeo()->getName() ) ?>
        </p>
    </div>
<?php endif; ?>

<?php echo javascript_tag('function changeRate(json){ 
  $("currentRatingStars").className = "rating star" + json.currentRate;
  $("currentRate").innerHTML = json.currentRate;
}') ?>
