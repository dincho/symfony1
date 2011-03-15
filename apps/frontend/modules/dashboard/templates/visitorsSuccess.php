<?php use_helper('prDate', 'prProfilePhoto', 'Date', 'prLink') ?>

<p><?php echo __('To get new match results, change your <a href="%URL_FOR_SEARCH_CRITERIA%" class="sec_link">Search Criteria</a>') ?></p>
<?php include_partial('content/newProfiles') ?>
<br />
<br />


<div id="winks">
    <?php foreach ($visits as $visit): ?>
        <?php $member = $visit->getMemberRelatedByMemberId() ?>
        <div class="member_profile_viewers">
            <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $member->getAge() ?></span>
            <?php echo link_to_unless_ref(!$member->isActive(), profile_photo($member, 'float-left'), '@profile?bc=visitors&username=' . $member->getUsername()) ?>
            <div class="input">
                <span class="public_reg_notice"><?php echo __('Viewed you %date%', array('%date%' => distance_of_time_in_words($visit->getUpdatedAt(null)))) ?></span>
                <?php echo link_to_unless_ref(!$member->isActive(), __('View Profile'), '@profile?bc=visitors&username=' . $member->getUsername(), array('class' => 'sec_link')) ?>
                <?php if( $visit->getIsNew() ): ?>
                  <div>
                    <?php echo image_tag('circle-blue.png'); ?>
                  </div>
                <?php endif;?>
            </div>
        </div>        
    <?php endforeach; ?>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
