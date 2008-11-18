<span class="online-assistant"><?php echo link_to(__('Contact Online Assistant'), 'dashboard/contactYourAssistant', array('class' => 'sec_link')) ?></span>

<?php if( $member->getSubscriptionId() == SubscriptionPeer::FREE ): ?>
    <?php echo __('Your currently using Free Membership. To see what options are available to you, <a href="%URL_FOR_SUBSCRIPTION%" class="sec_link">click here</a>.', array('%URL_FOR_SUBSCRIPTION%' => url_for('subscription/index'))) ?><br />
<?php endif; ?>

<?php if( is_null($member->getUsCitizen()) ): ?>
    <?php echo link_to(__('Are you a US citizen?'), 'IMBRA/confirmImbraStatus', array('class' => 'sec_link')) ?><br />
<?php endif; ?>
<br class="clear" />

<div id="dashboard-container">
    <div class="left">
        <div class="go-to"><?php echo __('Go to:') ?></div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Matches'), '@matches', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($matches as $match_profile): ?>
                <?php echo link_to(image_tag($match_profile->getMainPhoto()->getImg('30x30')), '@profile?username=' . $match_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Messages ( %count% )', array('%count%' => $messages_cnt)), 'messages/index', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($messages as $message_profile): ?>
                <?php echo link_to(image_tag($message_profile->getMainPhoto()->getImg('30x30')), '@profile?username=' . $message_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Winks ( %count% )', array('%count%' => $winks_cnt)), '@winks', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($winks as $wink_profile): ?>
                <?php echo link_to(image_tag($wink_profile->getMainPhoto()->getImg('30x30')), '@profile?username=' . $wink_profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Hotlist ( %count% )', array('%count%' => $hotlist_cnt)), '@hotlist', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($hotlist as $hotlist_profile): ?>
                <?php echo link_to(image_tag($hotlist_profile->getMainPhoto()->getImg('30x30')), '@profile?username=' . $hotlist_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Visitors ( %count% )', array('%count%' => $visits_cnt)), '@visitors', array('class' => 'sec_link menu_title')) ?>
            <?php if( $member->getSubscription()->getCanSeeViewed() ): ?>
                <?php foreach ($visits as $visit_profile): ?>
                    <?php echo link_to(image_tag($visit_profile->getMainPhoto()->getImg('30x30')), '@profile?username=' . $visit_profile->getUsername()) ?>
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
        <span class="view_profile_like_others"><?php echo link_to(__('View Your Profile (as others see it)'), '@profile?username=' . $sf_user->getUsername(), 'class=sec_link_brown') ?></span>
        <ul class="top">
            <li><strong><?php echo __('Your Profile') ?></strong></li>
            <li><?php echo link_to(__('Registration'), 'editProfile/registration', array('class' => 'sec_link')) ?> <span><?php echo __('(name, email, password, country etc.)') ?></span></li>
            <li><?php echo link_to(__('Self-description'), 'editProfile/selfDescription', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Search Criteria (preferences)'), 'dashboard/searchCriteria', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Posing/Essay'), 'editProfile/essay', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Photos'), 'editProfile/photos', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('IMBRA Information'), 'IMBRA/index', array('class' => 'sec_link')) ?></li>
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
            <li><strong><?php echo __('Resources') ?></strong></li>
            <li><?php echo link_to(__('Safety Tips'), '@page?slug=safety_tips', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Moving Abroad'), '@page?slug=legal_resources', array('class' => 'sec_link')) ?></li>
            <li><?php echo link_to(__('Immigrants Rights'), '@page?slug=immigrant_rights', array('class' => 'sec_link')) ?></li>
            <!--  <li><?php //echo link_to(__('Best Videos'), '@page?slug=best_videos', array('class' => 'sec_link')) ?></li> -->
        </ul>
    </div>
    <?php if( count($recent_visits) > 0 ): ?>
        <div class="bottom">
            <strong><?php echo __('Recently viewed profiles:') ?></strong>
            <?php foreach ($recent_visits as $profile): ?>
                <?php //$profile = $recent_visit->getMemberRelatedByProfileId(); ?>
                <div class="photo">
                    <?php echo link_to(image_tag($profile->getMainPhoto()->getImg('80x100')), '@profile?username=' . $profile->getUsername()) ?>
                    <p><?php echo link_to($profile->getUsername(), '@profile?username=' . $profile->getUsername(), 'class=sec_link') ?></p>
                </div>            
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
