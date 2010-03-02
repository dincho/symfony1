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
                echo image_tag($member->getMainPhoto()->getImg('350x350', 'file'), $image_options);
              endif; 
        ?>
    </div>
    <?php $i=1;foreach ($member->getMemberPhotos(sfConfig::get('app_settings_profile_max_photos')) as $photo): ?>
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
    <?php if( $member->getYoutubeVid() && sfConfig::get('app_settings_profile_display_video') ): ?>
        <br /><br /><object width="350" height="355"><param name="movie" value="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=0"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=0" type="application/x-shockwave-flash" wmode="transparent" width="350" height="355"></embed></object>
    <?php endif; ?>
    <p style="width: 350px;"><?php echo nl2br($member->getEssayIntroduction()) ?></p>
</div>

<div id="profile_right"> 
   <div id="profile_pager"></div>
   
   <div id="profile_top">
        <span class="sec_link"><?php echo __('Wink');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Send Mail');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Add to Hotlist');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Block');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Flag');?></span>
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
            </div>
        </div>
        <div class="right">
            <div class="middle">
                <?php echo __('Currently Online') ?>
                <br />
                <?php echo __('Profile ID:') . '&nbsp;' . $member->getId(); ?><br />
                <?php echo __('Viewed by %count% visitors', array('%count%' => $member->getCounter('ProfileViews'))) ?>
            </div>
        </div>
    </div>
    <?php include_component('profile', 'descMap', array('member' => $member, 'sf_cache_key' => $member->getId())); ?>
    <?php include_partial('profile/recent_activities', array('member' => $member)); ?>
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
