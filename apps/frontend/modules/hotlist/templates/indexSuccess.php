<?php use_helper('prDate', 'prProfilePhoto') ?>

<div id="winks">
    <div class="you_recived">
        <?php echo __('You\'re on the Hotlist of these members')?><br /><br /><br />
        <?php foreach ($others_hotlists as $others_hotlist_row): ?>
            <?php $member = $others_hotlist_row->getMemberRelatedByMemberId(); ?>
            <div class="member_profile">
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2> <span class="number"><?php echo $member->getAge() ?></span>
                <?php echo link_to_unless(!$member->isActive(), profile_photo($member, 'float-left'), '@profile?bc=hotlist&username=' . $member->getUsername()) ?>
                <div class="input">
                    <span class="public_reg_notice">
                        <?php echo __('%she_he% added you to %her_his% hotlist %date%', 
                                   array('%date%' => format_date_pr($others_hotlist_row->getCreatedAt(null)),
                                         '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She',
                                         '%her_his%' => ( $member->getSex() == 'M' ) ? 'his' : 'her'
                               )); ?>
                    </span>
                    <?php echo link_to_unless(!$member->isActive(), __('View Profile'), '@profile?bc=hotlist&username=' . $member->getUsername(), array('class' => 'sec_link')) ?>
                </div>
            </div>        
        <?php endforeach; ?>
    </div>
    <div class="you_sent">
        <?php echo __('You\'ve added these members to your Hotlist')?><br />
        <span><?php echo __('Click on the "x" in the lower corner of a profile to remove it from the list.')?></span><br /><br />
        <?php foreach ($hotlists as $hotlist_row): ?>
            <?php $profile = $hotlist_row->getMemberRelatedByProfileId(); ?>
            <div class="member_profile">
                <h2><?php echo Tools::truncate($profile->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $profile->getAge() ?></span>
                <?php echo link_to_unless(!$profile->isActive(), profile_photo($profile, 'float-left'), '@profile?bc=hotlist&username=' . $profile->getUsername()) ?>
                <div class="input">
                    <span class="public_reg_notice"><?php echo __('Added to your hotlist %date%', array('%date%' => format_date_pr($hotlist_row->getCreatedAt(null)))) ?></span>
                    <?php echo link_to_unless(!$profile->isActive(), __('View Profile'), '@profile?bc=hotlist&username=' . $profile->getUsername(), array('class' => 'sec_link')) ?><br />
                    <?php echo link_to(__('Remove from Hotlist'), 'hotlist/delete?id=' . $hotlist_row->getId()) ?>
                </div>
                <?php echo link_to(image_tag('butt_x.gif', 'class=x'), 'hotlist/delete?id=' . $hotlist_row->getId()) ?>

            </div>        
        <?php endforeach; ?>        
    </div>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>

