<?php use_helper('prDate', 'prProfilePhoto', 'Date', 'prLink', 'Javascript') ?>

<div id="winks">
    <div class="you_recived">
        <?php echo __('You\'re on the Hotlist of these members')?>  <br /><br /><br />
        <?php foreach ($others_hotlists as $others_hotlist_row): ?>
            <?php $member = $others_hotlist_row->getMemberRelatedByMemberId(); ?>
            <div class="member_profile" >
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2> <span class="number"><?php echo $member->getAge() ?></span>
                <?php echo link_to_ref(profile_photo($member), '@profile?bc=hotlist&username=' . $member->getUsername(), array('class' => 'photo_link', )) ?>
                <div class="input">
                    <span class="public_reg_notice">
                        <?php echo __('%she_he% added you to %her_his% hotlist %date%',
                                   array('%date%' => distance_of_time_in_words($others_hotlist_row->getCreatedAt(null)),
                                         '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She',
                                         '%her_his%' => ( $member->getSex() == 'M' ) ? 'his' : 'her'
                               )); ?>
                    </span>
                    <?php echo link_to_ref(__('View Profile'), '@profile?bc=hotlist&username=' . $member->getUsername(), array('class' => $others_hotlist_row->getIsNew()?'sec_link':'last')) ?>
                    <?php include_partial('content/onlineProfile', array('member' => $member)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="you_sent" id="sent_hotlist">
        <?php echo __('You\'ve added these members to your Hotlist')?><br />
        <span><?php echo __('Click on the "x" in the lower corner of a profile to remove it from the list.')?></span><br /><br />
        <?php foreach ($hotlists as $hotlist_row): ?>
            <?php include_partial('hotlist/sent_hotlist_profile', array('hotlist' => $hotlist_row)); ?>
        <?php endforeach; ?>
    </div>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
