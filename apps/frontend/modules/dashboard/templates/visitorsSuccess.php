<?php use_helper('prDate') ?>
<div id="winks">
    <?php foreach ($visits as $visit): ?>
        <?php $member = $visit->getMemberRelatedByMemberId() ?>
        <div class="member_profile_viewers">
            <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $member->getId() ?></span>
            <?php echo link_to(image_tag($member->getMainPhoto()->getImg('80x100')), '@profile?username=' . $member->getUsername()) ?>
            <div class="input">
                <span class="public_reg_notice"><?php echo __('Viewed you %date%', array('%date%' => format_date_pr($member->getCreatedAt(null)))) ?></span>
                <?php echo link_to(__('View Profile'), '@profile?username=' . $member->getUsername(), array('class' => 'sec_link')) ?>
            </div>
        </div>        
    <?php endforeach; ?>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
