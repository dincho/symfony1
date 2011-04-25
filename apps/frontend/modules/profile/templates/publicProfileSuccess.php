<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<div>
  <div id="profile_top_right"> 
     <div id="profile_pager"></div>
  </div>
</div>
<br class="clear" />

<div id="profile_left" >
    <?php $form_style = 'background-image: url(/images/no_photo/'.$member->getSex().'/350x350.jpg);'; ?>
    <?php echo form_tag('profile/signIn', array('id' => 'sign_in', 'style' => $form_style)) ?>
        <?php echo input_hidden_tag('referer', url_for('@public_profile?username=' . $member->getUsername(), array('absolute' => true, ))) ?>
        <fieldset>
            <div style="background-color: #000000; padding: 2px 1px 2px 8px; text-align: left;">
                <?php echo __('Sign in') ?>
            </div>
            <label for="email"><?php echo __('Email') ?></label>
            <?php echo input_tag('email', null, array('class' => 'input_text_width')); ?><br />
        
            <label for="password"><?php echo __('Password') ?></label>
            <?php echo input_password_tag('password', null, array('class' => 'input_text_width')); ?><br />
        
            <span><?php echo link_to(__('Forgot your Password?'), 'profile/forgotYourPassword', array('class' => 'sec_link_small')) ?></span>
        </fieldset>

        <?php echo submit_tag(__('Sign In'), array('class' => 'button sign_in')) ?><br /><br />
        <?php echo __('New to PolishRomance.com? <a href="%URL_FOR_JOIN_NOW%" class="sec_link">Join for free</a>') ?>
    </form> 
    
    <p style="width: 350px;"><?php echo nl2br($member->getEssayIntroduction()) ?></p>
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
        <div class="membership">&nbsp;</div>
        <br class="clear" />
    </span>
    <div id="profile_double_box">
        <div class="left">
            <div class="middle">
                <?php echo __('%she_he% matches you:', array('%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
                
                <?php echo __('You match %her_him%:', array('%her_him%' => ( $member->getSex() == 'M' ) ? __('him') : __('her'))) ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
                
                <?php echo __('Your combined match is:') ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
            </div>
        </div>
        <div class="right">
            <div class="middle">
                <?php echo __('Last log in: ') ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
            
                <?php echo __('Profile ID:'); ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
                <?php echo __('Viewed by %count% visitors', array('%count%' => $member->getCounter('ProfileViews'))) ?>
            </div>
        </div>
    </div>
    <?php include_component('profile', 'descMap', array('member' => $member, 'sf_cache_key' => $member->getId())); ?>
    <table class="conversations_messages" cellspacing="0" cellpadding="0">
        <tr>
            <th colspan="2"><?php echo __('Your Recent Activities with %username%', array('%username%' => $member->getUsername()))?></th>
            <th class="right_column"><?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?></th>
        </tr>
        <tr>
            <td colspan="3" class="color-gray">&nbsp;</th>
        </tr>
    </table>
</div>

<br class="clear" />

