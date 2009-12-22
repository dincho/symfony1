<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox', 'prLink') ?>

<div id="profile_right"> 
   <div id="profile_pager"></div>
   
   <div id="profile_top">
        <span class="sec_link"><?php echo __('Wink');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Send Mail');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Add to Hotlist');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Block');?></span>&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;
        <span class="sec_link"><?php echo __('Flag');?></span>
   </div>
    <span class="profile_gift">
    </span>
    <div id="profile_double_box">
        <div class="left">
            <div class="middle">
                <?php echo __('%she_he% matches you:', array('%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
                
                <?php echo __('You match %her_him%:', array('%her_him%' => ( $member->getSex() == 'M' ) ? 'him' : 'her')) ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
                
                <?php echo __('Your combined match is:') ?>
                <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
            </div>
        </div>
        <div class="right">
            <?php echo __('Last log in: ') ?>
            <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?><br />
            
            <?php echo __('Profile ID:'); ?>
            <?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?>
        </div>
    </div>
    <div id="desc_map_container">
        <div id="profile_desc">
            <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch') ?>
            <?php $area_info = ($member->getAdm1Id() && $member->getAdm1()->getInfo()) ? addslashes(link_to(__('Area Information'), '@area_info?area_id=' . $member->getAdm1Id() . '&username=' . $member->getUsername(), array('class' => 'sec_link'))) : null; ?>
            <?php echo link_to_function(__('Map'), 
                        'show_profile_map("'. $member->getGAddress() . '", "'. $area_info .'")', 
                        'class=switch inactive');
             ?>
            <br class="clear" />
            <dl>
                <dt><?php echo __('Orientation') ?></dt><dd><?php echo __($member->getOrientationString()) ?></dd>
                <dt><?php echo __('Country') ?></dt><dd><?php echo format_country($member->getCountry()) ?></dd>
                <dt><?php echo __('Area') ?></dt><dd><?php echo ($member->getAdm1Id()) ? $member->getAdm1() : __('None') ?>&nbsp;<?php if($member->getAdm1Id()) echo link_to(__('(other profiles from this area)'), 'search/areaFilter?id=' . $member->getAdm1Id(), 'class=sec_link') ?></dd>
                <dt><?php echo __('District') ?></dt><dd><?php echo ($member->getAdm2Id()) ? $member->getAdm2() : __('None') ?></dd>
                <dt><?php echo __('City') ?></dt><dd><?php echo $member->getCity() ?></dd>
                <?php if( !$member->getDontDisplayZodiac() ): ?>
                    <dt><?php echo __('Zodiac') ?></dt><dd><?php echo __($member->getZodiac()->getSign()) ?></dd>
                <?php endif; ?>

                <?php foreach ($questions as $question): ?>
                    <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                    
                        <?php if( isset($member_answers[$question->getId()]) && 
                                  ($member_answers[$question->getId()]->getDescAnswerId() || $member_answers[$question->getId()]->getOther()) ): ?>
                            <dt><?php echo __($question->getDescTitle(ESC_RAW)) ?></dt>
                            <dd>
                                <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                    <?php echo __($answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle(ESC_RAW)) ?>
                                <?php else: ?>
                                    <?php echo $member_answers[$question->getId()]->getOther(); ?>
                                <?php endif; ?>
                            </dd>
                        <?php endif; ?>
                    <?php elseif( $question->getType() == 'native_lang' && ( isset($member_answers[$question->getId()])) ): ?>
                    
                    <dt><?php echo __('Language'); ?></dt><dd><?php echo ( is_null($member_answers[$question->getId()]->getOther()) ) ? format_language($member_answers[$question->getId()]->getCustom()) : $member_answers[$question->getId()]->getOther() ?> (<?php echo __('native'); ?>)</dd>
                    <?php elseif( $question->getType() == 'other_langs' ): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                <?php $lang_answers = $member_answers[$question->getId()]->getOtherLangs(); ?>
                                <?php foreach ($lang_answers as $lang_answer): ?>
                                    <?php if( $lang_answer['lang'] ): ?>
                                        <dt>&nbsp;</dt><dd><?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)</dd>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <dt>&nbsp;</dt><dd><?php echo $member_answers[$question->getId()]->getOther(); ?></dd>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                
            </dl>
        </div>
        <div id="profile_map" style="display: none;">
            <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch inactive') ?>
            <?php echo link_to_function(__('Map'), 'show_profile_map()', 'class=switch') ?>
            <br class="clear" />
            <div id="gmap"></div>
        </div>
        <br class="clear" />
    </div>
    <table class="conversations_messages" cellspacing="0" cellpadding="0">
        <tr>
            <th colspan="2"><?php echo __('Recent Conversations')?></th>
            <th class="right_column"><?php echo link_to(__('sign in'), '@signin', array('class' => 'sec_link')); ?></th>
        </tr>
        <tr>
            <td colspan="3" class="color-gray">&nbsp;</th>
        </tr>        
    </table>
</div>
<div id="profile_left">
    <?php $form_style = 'background-image: url(/images/no_photo/'.$member->getSex().'/350x350.jpg);'; ?>
    <?php echo form_tag('profile/signIn', array('id' => 'sign_in', 'style' => $form_style)) ?>
        <?php echo input_hidden_tag('referer', url_for('@public_profile?username=' . $member->getUsername(), array('absolute' => true, ))) ?>
        <fieldset>
            <div style="background-color: #000000; padding: 1px; padding-left: 8px; text-align: left;">
                <?php echo __('Sign in') ?>
            </div>
            <label for="email"><?php echo __('Email') ?></label>
            <?php echo input_tag('email', null, array('class' => 'input_text_width')); ?><br />
        
            <label for="password"><?php echo __('Password') ?></label>
            <?php echo input_password_tag('password', null, array('class' => 'input_text_width')); ?><br />
        
            <span><?php echo link_to(__('Forgot your Password?'), 'profile/forgotYourPassword', array('class' => 'sec_link_small')) ?></span>
        </fieldset

        <?php echo submit_tag(__('Sign In'), array('class' => 'button sign_in')) ?><br /><br />
        <?php echo __('New to PolishRomance.com? <a href="%URL_FOR_JOIN_NOW%" class="sec_link">Join for free</a>') ?>
    </form> 
    
    <p style="width: 350px;"><?php echo nl2br($member->getEssayIntroduction()) ?></p>
    <span><?php echo __('Viewed by %count% visitors', array('%count%' => $member->getCounter('ProfileViews'))) ?></span>
</div>

