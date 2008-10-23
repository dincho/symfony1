<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm') ?>
<div id="profile_right">
    <ul id="profile_top">
        <li class="left_profile_top"><?php echo link_to(__('Wink'), 'winks/send?profile_id=' . $member->getId(), 'class=sec_link') ?></li>
        <li><?php echo link_to(__('Send Mail'), 'messages/send?profile_id=' . $member->getId(), 'class=sec_link') ?></li>
        <li><?php echo link_to(__('Add to Hotlist'), 'hotlist/add?profile_id=' . $member->getId(), 'class=sec_link') ?></li>
        <li><?php echo link_to(__('Block'), 'block/add?profile_id=' . $member->getId(), 'class=sec_link') ?></li>
        <li><?php echo link_to(__('Flag'), 'content/flag?username=' . $member->getUsername(), 'class=sec_link') ?></li>
    </ul>
    <span class="profile_gift">
        <?php if( $member->getSubscriptionId() != SubscriptionPeer::FREE ): ?>
            <?php echo image_tag('full_member.gif') ?>
        <?php else: ?>
            <a href="#"><?php echo image_tag('buy_gift_' . $member->getSex() . '.gif') ?></a>
        <?php endif; ?>
        
    </span>
    <div id="profile_double_box">
        <div class="left">
            She matches you 67%<br />
            You match her 34%<br />
            Your combined match is 40%
        </div>
        <div class="right">
            <?php echo __('Last log in: ') ?>
            <?php if( $sessions > 0 ): ?>
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
            <?php echo link_to_function(__('Map'), 
                        'show_profile_map("'. $member->getGAddress() . '", "'. addslashes(link_to(__('City Information'), '@city_info?city=' . $member->getCity())) .'")', 
                        'class=switch inactive');
             ?>
            <br class="clear" />
            <dl>
                <dt><?php echo __('Country') ?></dt><dd><?php echo format_country($member->getCountry()) ?></dd>
                <dt><?php echo __('State/Province') ?></dt><dd><?php echo ($member->getStateId()) ? $member->getState() : __('None') ?></dd>
                <dt><?php echo __('City') ?></dt><dd><?php echo $member->getCity() ?> <a href="#" class="sec_link">(other profiles from this city)</a></dd>
                <?php if( !$member->getDontDisplayZodiac() ): ?>
                    <dt><?php echo __('Zodiac') ?></dt><dd><?php echo $member->getZodiac()->getSign() ?></dd>
                <?php endif; ?>
                <?php foreach ($questions as $question): ?>
                    <?php if( $question->getType() == 'radio' || $question->getType() == 'select'): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <dt><?php echo $question->getDescTitle() ?></dt><dd><?php echo $answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle() ?></dd>
                        <?php endif; ?>
                    <?php elseif( $question->getType() == 'other_langs' ): ?>
                        <dt><?php echo __('Language'); ?></dt><dd><?php echo format_language($member->getLanguage()) ?> (native)</dd>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <?php $lang_answers = $member_answers[$question->getId()]->getOtherLangs(); ?>
                            <?php foreach ($lang_answers as $lang_answer): ?>
                                <?php if( $lang_answer['lang'] ): ?>
                                    <dt>&nbsp;</dt><dd><?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)</dd>
                                <?php endif; ?>
                            <?php endforeach; ?>
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
            <th colspan="2">Recent Conversations</th>
            <th class="right_column"><?php echo link_to(__('See all messages'), '@messages', 'class=sec_link') ?></th>
        </tr>
        <?php if( count($recent_conversations) > 0 ): ?>
            <?php foreach ($recent_conversations as $message): ?>
                <?php $user = ($message->getFromMemberId() == $member->getId() ) ? $member->getUsername() : __('You'); ?>
                <tr>
                    <td><?php echo link_to($user, 'messages/view?id=' . $message->getId(), 'class=sec_link') ?></td>
                    <td><?php echo link_to(Tools::truncate($message->getSubject(), 30), 'messages/view?id=' . $message->getId(), 'class=sec_link') ?></td>
                    <td><?php echo link_to(format_date_pr($message->getCreatedAt(null)), 'messages/view?id=' . $message->getId(), 'class=sec_link') ?></td>
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
    <?php echo image_tag($member->getMainPhoto()->getImg('350x350'), array('id' => 'member_image')) ?><br />
    <!--<a href="#"><img src="/images/pic/M_thumb1.jpg" alt="m_thumb" class="thumb_selected" border="0" /></a> -->
    <?php foreach ($member->getMemberPhotos() as $photo): ?>
        <?php echo link_to_function(image_tag($photo->getImg('50x50'), 'class=thumb'), 'document.getElementById("member_image").src="'. $photo->getImg('350x350').'"') ?>
    <?php endforeach; ?>
    <?php if( $member->getYoutubeVid() ): ?>
        <object width="350" height="355"><param name="movie" value="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=0"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=0" type="application/x-shockwave-flash" wmode="transparent" width="350" height="355"></embed></object>
    <?php endif; ?>
    <p><?php echo $member->getEssayIntroduction() ?></p>
    <span><?php echo __('Viewed by %count% visitors', array('%count%' => $member->getCounter('ProfileViews'))) ?></span>
</div>
