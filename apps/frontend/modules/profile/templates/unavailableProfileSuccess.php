<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<div id="profile_left">
    <div style="min-height: 350px">
        <?php echo image_tag('/images/no_photo/' .$member->getSex().'/350x350.jpg', array( 'class' => 'member_image')); ?>
    </div>
</div>

<div id="profile_right"> 
   <div id="profile_pager">
        <?php include_partial('profile_pager', array('pager' => $profile_pager)); ?>
   </div>
   
   <div id="profile_top">
        <span class="sec_link"><?php echo __('Wink');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Send Mail');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Add to Hotlist');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Block');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Flag');?></span>
   </div>
    <span class="profile_gift">
        <?php if( $member->getMillionaire() ): ?>
            <div class="millionaire_mark"><?php echo __('M'); ?></div>
        <?php endif; ?>

        <?php include_partial('profile/membership', array('member' => $member)); ?>

        <br class="clear" />
    </span>
    <div id="profile_double_box">
        <div class="left">
            <div class="middle">
            </div>
        </div>
        <div class="right">
            <div class="middle">
                <?php echo __('Profile ID:') . '&nbsp;' . $member->getId(); ?><br />
            </div>
        </div>
    </div>
    <?php include_partial('profile/recent_activities', array('member' => $member)); ?>
</div>

<br class="clear" />
