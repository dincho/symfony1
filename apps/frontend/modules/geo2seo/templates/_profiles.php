<?php use_helper('Date', 'dtForm') ?>

<div id="match_results">
    <div class="member">
        <?php $i=1;foreach($members as $member): ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">
                <div class="header">
                    <div class="age"><?php echo $member->getAge() ?></div>
                    <div class="headline"><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></div>
                </div>
                <?php echo image_tag($member->getMainPhoto()->getImg('80x100')) ?>
                <div class="profile_info">
                    <p class="profile_location"><?php echo Tools::truncate(pr_format_country($member->getCountry()) . ', ' . $member->getCity(), 45) ?></p>
                    <p></p>
                    <p><?php echo link_to('View Profile', 'registration/joinNow', array('class' => 'sec_link')) ?></p>
                    <p></p>
                    <p></p>
                    <p>
                       <?php echo __('Last log in: '); ?>
                       <?php echo distance_of_time_in_words($member->getLastLogin(null)); ?>
                    </p>
                </div>
            </div>
            <?php if( $i < 12 && $i%3 == 0): ?>
            </div>
            <div class="member">
            <?php endif; ?>
        <?php $i++;endforeach; ?>
    </div>
</div>
