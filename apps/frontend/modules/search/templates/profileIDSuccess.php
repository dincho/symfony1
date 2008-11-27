<?php use_helper('prDate') ?>

<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/profileID')?>" method="post">
    <label for="profile_id"><?php echo __('Enter profile ID, e.g. "999 9999"') ?></label>
    <input type="text" name="profile_id" class="input_text_width" id="profile_id" /><br />
    <?php echo submit_tag(__('Search'), array('class' => 'button')) ?>
</form>

<br /><br />

<?php if( isset($member) ): ?>
<div class="member">
        <div class="member_box">
            <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2><span><?php echo $member->getId() ?></span>
            <?php echo image_tag($member->getMainPhoto()->getImg('100x100'), array('style' => 'vertical-align:middle;')) ?>
            
            <div class="profile_info">
                <p class="profile_location"><?php echo format_country($member->getCountry()) . ', ' . $member->getCity() ?></p>
                <p></p>
                <p><?php echo link_to('View Profile', '@profile?username=' . $member->getUsername(), array('class' => 'sec_link')) ?></p>
                <p><?php echo link_to(__('Add to hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?></p>
                <p></p>
                <?php $when =  ($member->isLoggedIn()) ? 'Online' : pr_distance_of_time_in_words($member->getLastLogin(null)); ?>
                <p><?php echo __('Last seen: %WHEN%', array('%WHEN%' => $when)) ?></p>
            </div>
        </div>
</div>
<?php endif; ?>




