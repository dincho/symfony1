<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<div id="profile_right">
    <?php include_partial('profile_pager', array('pager' => $profile_pager)); ?>
   
   <div id="profile_top">
        <?php echo link_to_unless($sf_user->getProfile() && $sf_user->getProfile()->hasWinkTo($member->getId()), __('Wink'), 'winks/send?profile_id=' . $member->getId(), 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php echo link_to(__('Send Mail'), 'messages/send?profile_id=' . $member->getId(), 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        
        <?php if( $sf_user->getProfile() && $sf_user->getProfile()->hasInHotlist($member->getId()) ): ?>
           <?php echo link_to_ref(__('Remove from Hotlist'), 'hotlist/delete?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php else: ?>
          <?php echo link_to_ref(__('Add to Hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php endif; ?>
        
        <?php echo link_to_unless($sf_user->getProfile() && $sf_user->getProfile()->hasBlockFor($member->getId()), __('Block'), 'block/add?profile_id=' . $member->getId(), 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <?php echo link_to(__('Flag'), 'content/flag?username=' . $member->getUsername(), 'class=sec_link') ?>
   </div>
    <span class="profile_gift">
        <?php if( $member->getSubscriptionId() != SubscriptionPeer::FREE ): ?>
            <?php if( $current_culture == "en" ): ?>
                <?php echo link_to(image_tag('full_member.gif'), 'subscription/index') ?>
            <?php else:?>
                <?php echo link_to(image_tag('full_member_pl.gif'), 'subscription/index') ?>
            <?php endif; ?> 
        <?php else:?>
            <?php if( $current_culture == "en" ): ?>
                <?php echo link_to(image_tag('buy_gift_' . $member->getSex() . '.gif'), 'subscription/giftMembership?profile=' . $member->getUsername()) ?>
            <?php else:?>
                <?php echo link_to(image_tag('buy_gift_pl.gif'), 'subscription/giftMembership?profile=' . $member->getUsername()) ?>
            <?php endif; ?>    
        <?php endif; ?>
        
    </span>
    <div id="profile_double_box">
        <div class="left">
            <div class="middle">
                <?php if( $sf_user->isAuthenticated() && $sf_user->getId() != $member->getId() && $match): ?>
                    <?php if( $sf_user->getProfile()->hasSearchCriteria() ): ?>
                        <?php echo __('%she_he% matches you: %MATCH%%', array('%MATCH%' => $match->getPct(), '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?><br />
                    <?php else: ?>
                        <?php echo __('%she_he% matches you: (no result)', array('%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?><br />
                    <?php endif; ?>
                    
                    <?php if( $member->hasSearchCriteria() ): ?>
                        <?php echo __('You match %her_him%: %REVERSE_MATCH%%', array('%REVERSE_MATCH%' => $match->getReversePct(), '%her_him%' => ( $member->getSex() == 'M' ) ? 'him' : 'her')) ?><br />
                    <?php else: ?>
                        <?php echo __('You match %her_him%: (no result)', array('%REVERSE_MATCH%' => $match->getReversePct(), '%her_him%' => ( $member->getSex() == 'M' ) ? 'him' : 'her')) ?><br />
                    <?php endif; ?>
                    
                    <?php if( $match->getCombinedMatch() > 0 ): ?>
                        <?php echo __('Your combined match is: %COMBINED_MATCH%%', array('%COMBINED_MATCH%' => $match->getCombinedMatch()) ) ?><br />
                    <?php endif; ?>  
                                         
                <?php endif; ?>
            </div>
        </div>
        <div class="right">
            <?php echo __('Last log in: ') ?>
            <?php if( $member->isLoggedIn() ): ?>
                <?php echo __('Currently Online') ?>
            <?php else: ?>
                <?php echo time_ago_in_words($member->getLastLogin(null)) ?>
            <?php endif; ?>
            <br />
            <?php echo __('Profile ID:') . '&nbsp;' . $member->getId(); ?> 
        </div>
    </div>
    <div id="desc_map_container">
        <div id="profile_desc">
            <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch') ?>
            <?php $area_info = ($member->getAdm1Id() && $member->getAdm1()->getInfo()) ? addslashes(link_to(__('Area Information'), '@area_info?area_id=' . $member->getAdm1Id() . '&username=' . $member->getUsername(), array('class' => 'sec_link'))) : null; ?>
            <?php echo link_to_function(__('Map'), 
                        'show_profile_map("'. $member->getGAddress() . '", "'. $area_info .'")', 
                        'class=switch inactive');
             ?>
            <br class="clear" />
            <dl>
                <dt><?php echo __('Orientation') ?></dt><dd><?php echo __($member->getOrientationString()) ?></dd>
                <dt><?php echo __('Country') ?></dt><dd><?php echo format_country($member->getCountry()) ?></dd>
                <dt><?php echo __('Area') ?></dt><dd><?php echo ($member->getAdm1Id()) ? $member->getAdm1() : __('None') ?>&nbsp;<?php if($member->getAdm1Id()) echo link_to(__('(other profiles from this area)'), 'search/areaFilter?id=' . $member->getAdm1Id(), 'class=sec_link') ?></dd>
                <dt><?php echo __('District') ?></dt><dd><?php echo ($member->getAdm2Id()) ? $member->getAdm2() : __('None') ?></dd>
                <dt><?php echo __('City') ?></dt><dd><?php echo $member->getCity() ?></dd>
                <?php if( !$member->getDontDisplayZodiac() ): ?>
                    <dt><?php echo __('Zodiac') ?></dt><dd><?php echo __($member->getZodiac()->getSign()) ?></dd>
                <?php endif; ?>
                <?php foreach ($questions as $question): ?>
                    <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <dt><?php echo __($question->getDescTitle(ESC_RAW)) ?></dt>
                            <dd>
                                <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                    <?php echo __($answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle(ESC_RAW)) ?>
                                <?php else: ?>
                                    <?php echo $member_answers[$question->getId()]->getOther(); ?>
                                <?php endif; ?>
                            </dd>
                        <?php endif; ?>
                    <?php elseif( $question->getType() == 'native_lang' && ( isset($member_answers[$question->getId()])) ): ?>
                    
                    <dt><?php echo __('Language'); ?></dt><dd><?php echo ( is_null($member_answers[$question->getId()]->getOther()) ) ? format_language($member_answers[$question->getId()]->getCustom()) : $member_answers[$question->getId()]->getOther() ?> (<?php echo __('native'); ?>)</dd>
                    <?php elseif( $question->getType() == 'other_langs' ): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                <?php $lang_answers = $member_answers[$question->getId()]->getOtherLangs(); ?>
                                <?php foreach ($lang_answers as $lang_answer): ?>
                                    <?php if( $lang_answer['lang'] ): ?>
                                        <dt>&nbsp;</dt><dd><?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)</dd>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <dt>&nbsp;</dt><dd><?php echo $member_answers[$question->getId()]->getOther(); ?></dd>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                
            </dl>
        </div>
        <div id="profile_map" style="display: none;">
            <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch inactive') ?>
            <?php echo link_to_function(__('Map'), 'show_profile_map()', 'class=switch') ?>
            <br class="clear" />
            <div id="gmap"></div>
        </div>
        <br class="clear" />
    </div>
    <table class="conversations_messages" cellspacing="0" cellpadding="0">
        <tr>
            <th colspan="2"><?php echo __('Recent Conversations')?></th>
            <th class="right_column"><?php echo link_to(__('See all messages'), 'messages/index', 'class=sec_link') ?></th>
        </tr>
        <?php if( count($recent_conversations) > 0 ): ?>
            <?php foreach ($recent_conversations as $message): ?>
                <?php $user = ($message->getFromMemberId() == $member->getId() ) ? $member->getUsername() : __('You'); ?>
                <tr>
                    <td><?php echo link_to($user, 'messages/view?id=' . $message->getId(), 'class=sec_link') ?></td>
                    <td><?php echo link_to(Tools::truncate($message->getSubject(), 30), 'messages/view?id=' . $message->getId(), 'class=sec_link') ?></td>
                    <td><?php echo link_to(format_date_pr($message->getCreatedAt(null), $time_format = ', hh:mm', $date_format = 'dd MMMM'), 'messages/view?id=' . $message->getId(), 'class=sec_link') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="3" class="color-gray"><?php echo __('You don\'t have any messages with %username% yet.', array('%username%' => $member->getUsername())) ?></th>
        </tr>
        <?php endif; ?>
    </table>            
</div>
<div id="profile_left">
    <div style="min-height: 350px">
        <?php 
              $image_options = array('id' => 'member_image');
              $link_options = array('id' => 'member_image_link');
              
              if( !is_null($member->getMainPhotoId()) ): //has main photo
              echo light_image($member->getMainPhoto()->getImg('350x350', 'file'), 
                               $member->getMainPhoto()->getImageUrlPath('file'), $link_options, $image_options );
              else: //has no main photo, so lightbox and link should not be applied
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
    <p style="width: 350px;"><?php echo $member->getEssayIntroduction() ?></p>
    <span><?php echo __('Viewed by %count% visitors', array('%count%' => $member->getCounter('ProfileViews'))) ?></span>
</div>
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
