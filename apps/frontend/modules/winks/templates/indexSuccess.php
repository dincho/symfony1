<?php use_helper('prDate', 'prProfilePhoto', 'Date', 'prLink') ?>

<?php echo __('These are the winks you received and sent. Click on the "x" in the lower corner of a profile to remove it from the list.') ?>
<div id="winks">
    <div class="you_recived">
        <?php echo __('Winks you received')?><br /><br />
        <?php foreach ($received_winks as $received_wink): ?>
            <?php $member = $received_wink->getMemberRelatedByMemberId(); ?>        
            <div class="member_profile">
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2> <span class="number"><?php echo $member->getAge() ?></span>
                <?php echo link_to_ref(profile_photo($member, 'float-left'), '@profile?bc=winks&username=' . $member->getUsername()) ?>
                <div class="input">
                    <span class="public_reg_notice">
                        <?php echo __('%she_he% winked at you %date%', 
                                   array('%date%' => distance_of_time_in_words($received_wink->getCreatedAt(null)),
                                         '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She',
                               )); ?>
                    </span>
                    <?php echo link_to_ref(__('View Profile'), '@profile?bc=winks&username=' . $member->getUsername(), array('class' => 'sec_link')) ?><br />
                    <?php echo link_to_ref(__('Remove from Winks'), 'winks/delete?id=' . $received_wink->getId()) ?>
                </div>                
                <?php echo link_to_ref(image_tag('butt_x.gif', 'class=x'), 'winks/delete?id=' . $received_wink->getId()) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="you_sent">
        <?php echo __('Winks you sent') ?><br /><br />
        <?php foreach ($sent_winks as $sent_wink): ?>
            <?php $profile = $sent_wink->getMemberRelatedByProfileId(); ?>        
            <div class="member_profile">
                <h2><?php echo Tools::truncate($profile->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $profile->getAge() ?></span>
                <?php echo link_to_ref(profile_photo($profile, 'float-left'), '@profile?bc=winks&username=' . $profile->getUsername()) ?>
                <div class="input">
                    <span class="public_reg_notice">
                        <?php echo __('You winked at %her_his% %date%', 
                                   array('%date%' => distance_of_time_in_words($sent_wink->getCreatedAt(null)),
                                         '%her_his%' => ( $profile->getSex() == 'M' ) ? 'him' : 'her',
                               )); ?>
                    </span>
                    <?php echo link_to_ref(__('View Profile'), '@profile?bc=winks&username=' . $profile->getUsername(), array('class' => 'sec_link')) ?><br />
                    <?php echo link_to_ref(__('Remove from Winks'), 'winks/delete?id=' . $sent_wink->getId()) ?>
                </div>
                <?php echo link_to_ref(image_tag('butt_x.gif', 'class=x'), 'winks/delete?id=' . $sent_wink->getId()) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>