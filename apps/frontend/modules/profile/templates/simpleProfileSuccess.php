<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<?php $public_photos = $member->getPublicMemberPhotos(null, null, sfConfig::get('app_settings_profile_max_photos')); ?>
<?php $private_photos = $member->getPrivateMemberPhotos(null, null, sfConfig::get('app_settings_profile_max_private_photos')); ?>

<div id="profile_left" style="padding-top: 9px">
    <p class="photo_authenticity"><?php echo ($member->hasAuthPhoto()) ? __('photo authenticity verified') : __('photo authenticity not verified'); ?></p><br class="clear" />
    <div style="min-height: 350px">
        <?php 
              _addLbRessources();
              
              if( !is_null($member->getMainPhotoId()) ): //has main photo
                
                echo content_tag('a', image_tag($member->getMainPhoto()->getImg('350x350', 'file'), array('id' => 'member_image')), 
                                    array('href' => $member->getMainPhoto()->getImg(null, 'file'),
                                          'rel' => 'lightbox[public_photos]',
                                          'title' => $member->getUsername(),
                                          'id' => 'member_image_link'
                                ));
                
              else: //has no main photo ( this means no photos at all ), so lightbox and link should not be applied
                echo image_tag($member->getMainPhoto()->getImg('350x350', 'file'));
              endif; 
        ?>
    </div>
    
    <?php include_partial('profile/photos', array('photos' => $public_photos, 'member' => $member, 'block_id' => 'public_photos')); ?>

    <?php if( count($private_photos) > 0 ): ?>
        <hr />
        <p class="private_photos_headline"><?php echo  __('%USERNAME% has private photos.', array('%USERNAME%' => $member->getUsername())); ?></p>
        <?php for($i=0; $i<count($private_photos); $i++): ?>
            <?php echo image_tag('/images/no_photo/'. $member->getSex() .'/50x50_lock.jpg', array('class' => 'thumb')); ?>
        <?php endfor; ?>
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

        <?php include_partial('profile/membership', array('member' => $member)); ?>

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
