<?php use_helper('prProfilePhoto', 'Url', 'Javascript') ?>
<span class="online-assistant"><?php echo link_to(__('Contact Online Assistant'), 'dashboard/contactYourAssistant', array('class' => 'sec_link')) ?></span>

<?php if( $member->isFree() ): ?>
    <?php echo __('Your currently using Free Membership. To see what options are available to you, <a href="%URL_FOR_SUBSCRIPTION%" class="sec_link">click here</a>.', array('%URL_FOR_SUBSCRIPTION%' => url_for('subscription/index'))) ?><br />
<?php endif; ?>
  <?php if( !sfConfig::get('app_settings_imbra_disable') && is_null($member->getUsCitizen()) ): ?>
      <?php echo link_to(__('Are you a US citizen?'), 'IMBRA/confirmImbraStatus', array('class' => 'sec_link')) ?><br />
  <?php endif; ?>
<br class="clear" />
<div id="dashboard-container">
    <div class="left<?php echo ($sf_user->getProfile()->getPrivateDating())?'_privacy':'' ?>">
        <div class="go-to"><?php echo __('Go to:') ?></div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Dash - Matches'), '@matches', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($matches as $match_profile): ?>
                <?php echo link_to_unless(!$match_profile->isActive(), profile_small_photo($match_profile), '@profile?username=' . $match_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Messages ( %count%/%count_all% )', array('%count%' => $messages_cnt, '%count_all%' => $messages_all_cnt)), 'messages/index', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($messages as $message_profile): ?>
                <?php echo link_to(profile_small_photo($message_profile), '@profile?username=' . $message_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Winks ( %count%/%count_all% )', array('%count%' => $winks_cnt, '%count_all%' => $winks_all_cnt)), '@winks', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($winks as $wink_profile): ?>
                <?php echo link_to_unless(!$wink_profile->isActive(), profile_small_photo($wink_profile), '@profile?bc=winks&username=' . $wink_profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Hotlist ( %count%/%count_all% )', array('%count%' => $hotlist_cnt, '%count_all%' => $hotlist_all_cnt)), '@hotlist', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($hotlist as $hotlist_profile): ?>
                <?php echo link_to_unless(!$hotlist_profile->isActive(), profile_small_photo($hotlist_profile), '@profile?bc=hotlist&username=' . $hotlist_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Visitors ( %count%/%count_all% )', array('%count%' => $visits_cnt, '%count_all%' => $visits_all_cnt)), '@visitors', array('class' => 'sec_link menu_title')) ?>
            <?php if( $member->getSubscriptionDetails()->getCanSeeViewed() ): ?>
                <?php foreach ($visits as $visit_profile): ?>
                    <?php echo link_to_unless(!$visit_profile->isActive(), profile_small_photo($visit_profile), '@profile?bc=visitors&username=' . $visit_profile->getUsername()) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $max_no_photos = min($visits_cnt, 5); ?>
                <?php for($i=0; $i<$max_no_photos; $i++): ?>
                    <?php echo link_to(image_tag('no_photo/' . $member->getLookingFor() .'/30x30.jpg'), '@visitors') ?>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
        <div class="dashboard-menu">     
            <?php echo link_to(__('Private Photo Access ( %count%/%count_all% )', array('%count%' => $private_photos_profiles_cnt,'%count_all%' => $private_photos_profiles_all_cnt)), '@photo_access', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($private_photos_profiles as $private_photos_profile): ?>
                <?php echo link_to_unless(!$private_photos_profile->isActive(), profile_small_photo($private_photos_profile), '@profile?bc=photoAccess&username=' . $private_photos_profile->getUsername()) ?>
            <?php endforeach; ?>
        </div>    
        <?php if( $sf_user->getProfile()->getPrivateDating()): ?> 
          <div class="dashboard-menu">
              <?php echo link_to(__('Who Can See You ( %count% )', array('%count%' => $open_privacy_perms_cnt)), '@who_can_see_you', array('class' => 'sec_link menu_title')) ?>
              <?php foreach ($open_privacy_perms as $item): ?>
                  <?php echo link_to_unless(!$item->isActive(), profile_small_photo($item), '@profile?username=' . $item->getUsername()) ?>
              <?php endforeach; ?>
          </div>
        <?php endif; ?>
    
        <div class="dashboard-menu">
            <?php echo link_to(__('Blocked Members ( %count% )', array('%count%' => $blocked_cnt)), '@blocked_members', 'class=sec_link_brown') ?>
        </div>
    </div>
    <div class="right<?php echo ($sf_user->getProfile()->getPrivateDating())?'_privacy':'' ?>">
        <span class="view_profile_like_others"><?php echo link_to(__('Your Profile (View Your profile as others see it)'), '@my_profile', 'class=sec_link_brown') ?></span>
        <div class="go-to"><?php echo __('See profiles in your area:') ?></div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Newly registered ( %count% )', array('%count%' => $newly_registered_cnt)), 'search/mostRecent?filters[location]=1', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($newly_registered as $item): ?>
                <?php $profile = $item->getMemberRelatedByMember2Id(); ?>
                <?php echo link_to_unless(!$profile->isActive(), profile_small_photo($profile), '@profile?username=' . $profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Most recent visitors ( %count% )', array('%count%' => $most_recent_visitors_cnt)), 'search/lastLogin?filters[location]=1', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($most_recent_visitors as $item): ?>
                <?php $profile = $item->getMemberRelatedByMember2Id(); ?>
                <?php echo link_to_unless(!$profile->isActive(), profile_small_photo($profile), '@profile?username=' . $profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Best matching you ( %count% )', array('%count%' => $best_matching_you_cnt)), 'search/criteria?filters[location]=1', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($best_matching_you as $item): ?>
                <?php $profile = $item->getMemberRelatedByMember2Id(); ?>
                <?php echo link_to_unless(!$profile->isActive(), profile_small_photo($profile), '@profile?username=' . $profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('You match them best ( %count% )', array('%count%' => $you_match_them_best_cnt)), 'search/reverse?filters[location]=1', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($you_match_them_best as $item): ?>
                <?php $profile = $item->getMemberRelatedByMember2Id(); ?>
                <?php echo link_to_unless(!$profile->isActive(), profile_small_photo($profile), '@profile?username=' . $profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Best mutual matches ( %count% )', array('%count%' => $best_mutual_matches_cnt)), 'search/matches?filters[location]=1', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($best_mutual_matches as $item): ?>
                <?php $profile = $item->getMemberRelatedByMember2Id(); ?>
                <?php echo link_to_unless(!$profile->isActive(), profile_small_photo($profile), '@profile?username=' . $profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        <div class="dashboard-menu">
            <?php echo link_to(__('Per your own rating ( %count% )', array('%count%' => $per_your_own_rating_cnt)), 'search/byRate?filters[location]=1', array('class' => 'sec_link menu_title')) ?>
            <?php foreach ($per_your_own_rating as $item): ?>
                <?php $profile = $item->getMemberRelatedByMember2Id(); ?>
                <?php echo link_to_unless(!$profile->isActive(), profile_small_photo($profile), '@profile?username=' . $profile->getUsername()) ?>
            <?php endforeach; ?>            
        </div>
        
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
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>
