<?php use_helper('prProfilePhoto', 'prLink') ?>

<span class="online-assistant"><?php echo link_to(__('Contact Online Assistant'), 'dashboard/contactYourAssistant', array('class' => 'sec_link')) ?></span>

<?php if( $member->getSubscriptionId() == SubscriptionPeer::FREE ): ?>
    <?php echo __('Your currently using Free Membership. To see what options are available to you, <a href="%URL_FOR_SUBSCRIPTION%" class="sec_link">click here</a>.', array('%URL_FOR_SUBSCRIPTION%' => url_for('subscription/index'))) ?><br />
<?php endif; ?>
	<?php if( !sfConfig::get('app_settings_imbra_disable') && is_null($member->getUsCitizen()) ): ?>
    	<?php echo link_to(__('Are you a US citizen?'), 'IMBRA/confirmImbraStatus', array('class' => 'sec_link')) ?><br />
	<?php endif; ?>
<br class="clear" />
<div id="dashboard-container">
    <div class="left">
        <div class="go-to"><?php echo __('Go to:') ?></div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Dash - Matches'), '@matches', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($matches as $match_profile): ?>
                <?php echo link_to_unless(!$match_profile->isActive(), profile_small_photo($match_profile), '@profile?username=' . $match_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Messages ( %count% )', array('%count%' => $messages_cnt)), 'messages/index', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($messages as $message_profile): ?>
                <?php echo link_to_unless(!$message_profile->isActive(), profile_small_photo($message_profile), '@profile?username=' . $message_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Winks ( %count% )', array('%count%' => $winks_cnt)), '@winks', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($winks as $wink_profile): ?>
                <?php echo link_to_unless(!$wink_profile->isActive(), profile_small_photo($wink_profile), '@profile?username=' . $wink_profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Hotlist ( %count% )', array('%count%' => $hotlist_cnt)), '@hotlist', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($hotlist as $hotlist_profile): ?>
                <?php echo link_to_unless(!$hotlist_profile->isActive(), profile_small_photo($hotlist_profile), '@profile?username=' . $hotlist_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Visitors ( %count% )', array('%count%' => $visits_cnt)), '@visitors', array('class' => 'sec_link menu_title')) ?>
            <?php if( $member->getSubscription()->getCanSeeViewed() ): ?>
                <?php foreach ($visits as $visit_profile): ?>
                    <?php echo link_to_unless(!$visit_profile->isActive(), profile_small_photo($visit_profile), '@profile?username=' . $visit_profile->getUsername()) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $max_no_photos = min($visits_cnt, 5); ?>
                <?php for($i=0; $i<$max_no_photos; $i++): ?>
                    <?php echo link_to(image_tag('static/member_photo/' . $member->getLookingFor() .'/no_photo_30x30.jpg'), '@visitors') ?>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Blocked Members'), '@blocked_members', 'class=sec_link_brown') ?>
        </div>
    </div>
    <div class="right">
        <span class="view_profile_like_others"><?php echo link_to(__('Your Profile (View Your profile as others see it)'), '@my_profile', 'class=sec_link_brown') ?></span>
        <ul class="top">
            <li><strong><?php echo __('Your Profile') ?></strong></li>
            <li><?php echo link_to(__('Registration'), 'editProfile/registration', array('class' => 'sec_link')) ?> <span><?php echo __('(name, email, password, country etc.)') ?></span></li>
            <li><?php echo link_to(__('Self-description'), 'editProfile/selfDescription', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Search Criteria (preferences)'), 'dashboard/searchCriteria', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Posing/Essay'), 'editProfile/essay', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Photos'), 'editProfile/photos', array('class' => 'sec_link')) ?></li>
            	<?php if( !sfConfig::get('app_settings_imbra_disable') && $member->getUsCitizen() == 1 ): ?>
                	<li><?php echo link_to(__('IMBRA Information'), 'IMBRA/index', array('class' => 'sec_link')) ?></li>
            	<?php endif; ?>
            <?php if( $member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED ): ?>
                <li><?php echo link_to(__('Activate profile (show)'), 'dashboard/deactivate', array('class' => 'sec_link')) ?></li>
            <?php elseif( $member->getMemberStatusId() == MemberStatusPeer::ACTIVE ): ?>
                <li><?php echo link_to(__('Deactivate profile (hide)'), 'dashboard/deactivate', array('class' => 'sec_link')) ?></li>
            <?php endif; ?>
        </ul>
        <ul class="left">
            <li><strong><?php echo __('Your Account') ?></strong></li>
            <li><?php echo link_to(__('Email notifications'), 'dashboard/emailNotifications', array('class' => 'sec_link')) ?></li>
            <li>
                <?php if( $member->getSubscriptionId() == SubscriptionPeer::FREE ): ?>
                    <?php echo link_to(__('Subscribe'), 'subscription/index', array('class' => 'sec_link')) ?>
                <?php else: ?>
                    <?php echo link_to(__('Manage Subscription'), 'subscription/manage', array('class' => 'sec_link')) ?>
                <?php endif; ?>
            </li>
            <li><?php echo link_to(__('Privacy'), 'dashboard/privacy', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Delete your account'), 'dashboard/deleteYourAccount', array('class' => 'sec_link_brown')) ?></li>
        </ul>
	        <ul class="right">
	            <?php $links_map = StaticPagePeer::getLinskMap(); ?>
	            <li><strong><?php echo __('Resources') ?></strong></li>
	            <li><?php if(array_key_exists('safety_tips', $links_map)) echo link_to($links_map['safety_tips'], '@page?slug=safety_tips', array('class' => 'sec_link')) ?></li>
	            <li><?php if(array_key_exists('legal_resources', $links_map)) echo link_to($links_map['legal_resources'], '@page?slug=legal_resources', array('class' => 'sec_link')) ?></li>
	            <li><?php if(array_key_exists('immigrant_rights', $links_map)) echo link_to($links_map['immigrant_rights'], '@page?slug=immigrant_rights', array('class' => 'sec_link')) ?></li>
	            <li><?php if(array_key_exists('best_videos', $links_map)) echo link_to($links_map['best_videos'], '@page?slug=best_videos', array('class' => 'sec_link')) ?></li>
	        </ul>
        
    </div>
    <?php if( count($recent_visits) > 0 ): ?>
        <div class="bottom">
            <strong style="float: left;"><?php echo __('Recently viewed profiles:') ?></strong><br class="clear" />
            <?php foreach ($recent_visits as $profile): ?>
                <div class="photo">
                    <?php echo profile_photo_dash_visitors($profile, 'profile_not_available_dash'); ?>
                    <p><?php echo link_to_unless_ref(!$profile->isActive(), $profile->getUsername(), '@profile?username=' . $profile->getUsername(), array('class' => 'sec_link')) ?></p>
                </div>            
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>