<?php use_helper('Date', 'prProfilePhoto', 'prLink', 'dtForm', 'Javascript') ?>

<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/profileID')?>" method="post">
    <label for="profile_id"><?php echo __('Enter profile ID') ?></label>
    <?php echo input_tag('profile_id', null, array('id' => 'profile_id', 'class' => 'input_text_width')); ?><br />
    <?php echo submit_tag(__('Search'), array('class' => 'button')) ?>
</form>

<br /><br />

<?php if( isset($match) ): ?>
<?php $member = $match->getMemberRelatedByMember2Id(); ?>
<div class="member">
        <div class="member_box">
            <div class="header">
                <div class="age"><?php echo $member->getAge() ?></div>
                <div class="headline"><?php echo Tools::truncate($member->getEssayHeadline(), 38) ?></div>
            </div>
            <?php echo profile_photo($member, 'float-left') ?>            
            <div class="profile_info">
                <p class="profile_location"><?php echo Tools::truncate(pr_format_country($member->getCountry()) . ', ' . $member->getCity(), 45) ?></p>
                <p><?php echo link_to_ref('View Profile', '@profile?username=' . $member->getUsername(), array('class' => 'sec_link')) ?></p>
                <p>
                <?php $hotlist_link_title = ( $sf_user->getProfile()->hasInHotlist($member->getId()) ) ? __('Remove from Hotlist') : __('Add to Hotlist'); ?>
                <?php echo link_to_remote($hotlist_link_title,
                                          array('url'     => 'hotlist/toggle?update_selector=hotlist_link&profile_id=' . $member->getId(),
                                                'update'  => 'msg_container',
                                                'script'  => true
                                              ),
                                          array('class' => 'sec_link',
                                                'id'    => 'hotlist_link', 
                                                )
                            ); ?>
                </p>
                <p></p>
                <?php $when =  ($member->isLoggedIn()) ? __('Online') : distance_of_time_in_words($member->getLastLogin(null)); ?>
                <p><?php echo __('Last seen: %WHEN%', array('%WHEN%' => $when)) ?></p>
            </div>
        </div>
</div>
<?php elseif($sf_request->getParameter('profile_id')): ?>
    <div class="msg_error text-center"><?php echo __('We could not find a member with the ID you specified, please make sure you have the right ID number or use another type of search') ?></div>
<?php endif; ?>




