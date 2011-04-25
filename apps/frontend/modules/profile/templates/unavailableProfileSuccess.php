<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<div>
  <div id="profile_top_right"> 
    <div id="profile_pager">
        <?php include_partial('profile_pager', array('pager' => $profile_pager)); ?>
    </div>
  </div>
</div>
<br class="clear" />

<div id="profile_left">
    <div style="min-height: 350px">
        <?php echo image_tag('/images/no_photo/' .$member->getSex().'/350x350.jpg', array( 'class' => 'member_image')); ?>
    </div>
</div>

<div id="profile_right">    
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

<?php if(!sfConfig::get('app_settings_imbra_disable') && $imbra ): ?>
    <a name="profile_imbra_info" class="sec_link"><?php echo link_to_function('[<span id="profile_imbra_details_tick">-</span>] ' . __('IMBRA Information'), 'show_hide_tick("profile_imbra_details")', 'class=sec_link') ?></a>
    <div id="profile_imbra_details">
        <p class="profile_imbra_version">
            <?php echo __('Member since: ' . $member->getCreatedAt('m/d/y')) ?><br />
            <?php echo __('Imbra updated %TIMES% times. Most recently on %IMBRA_DATE%', array('%TIMES%' => $member->countMemberImbras(), '%IMBRA_DATE%' => $imbra->getCreatedAt('m/d/Y'))) ?>
        </p>
        <?php echo $sf_data->getRaw('imbra')->getText(); ?>
        <p>
            <?php echo $imbra->getName() ?><br />
            <?php echo $imbra->getCreatedAt('%B %d, %Y') ?><br />
            <?php echo __('Born ') .  $imbra->getDob()?><br />
            <?php printf('%s, %s, USA', $imbra->getCity(), $imbra->getGeo()->getName() ) ?>
        </p>
    </div>
<?php endif; ?>
