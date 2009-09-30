<?php use_helper('Javascript') ?>
<div id="header" class="index">
    <div id="left" class="index">
        <?php include_partial('content/lang');?>
    </div>
    <div id="polish_romance_logo">
        <?php echo domain_image_tag('logo_index.gif', 'alt=logo') ?>
    </div>
    <div id="right" class="index">
        <?php $current_culture = ($sf_user->getCulture() == 'pl') ? 'pl' : 'en'; ?>
        <?php if( $current_culture == "en" ): ?>
            <?php $signupbutton = link_to(image_tag('sign_in.gif', 'alt=logo'), 'profile/signIn') ?>
        <?php else: ?>
            <?php $signupbutton = link_to(image_tag('sign_in_pl.gif', 'alt=logo'), 'profile/signIn') ?>
        <?php endif; ?>
        <?php echo __('Already a Member?').$signupbutton ?>
    </div>
</div>
<div id="header_text" class="index">
    <?php echo __('Homepage headline'); ?>
</div>
<div id="middle">
    <div id="middle_left">
        <?php echo __('Homepage introduction') ?>
    </div>
    <div id="center">
        <div id="index_image">
            <?php include_component('content', 'homepagePhotoSet', array('homepage_set' => $homepage_set)); ?>
            
        </div>
        <br class="clear" />
        <div id="under_index_image">
            <h2><?php echo __('BROWSE FOR FREE NOW') ?></h2>
            <div id="register">
                <?php use_helper('dtForm'); ?>
                <?php echo form_tag('registration/joinNow', array('autocomplete' => 'off')) ?>
                    <fieldset>
                        <?php echo pr_label_for('username', __('Username')); ?>
                        <?php echo input_tag('username') ?><br class="clear" />
                        
                        <?php echo pr_label_for('email', __('Your email')) ?>
                        <?php echo input_tag('email') ?><br class="clear" />
                        
                        <?php echo pr_label_for('password', __('Create Password')) ?>
                        <?php echo input_password_tag('password') ?><br class="clear" />
                        
                        <?php echo pr_label_for('repeat_password', __('Repeat Password')) ?>
                        <?php echo input_password_tag('repeat_password') ?><br class="clear" />
                        
                        <?php echo pr_label_for('looking_for', __('You are')) ?>
                        <?php echo select_tag('looking_for', looking_for_options()) ?><br class="clear" />

                        
                        <?php $tos_text = __('I am 18 or older and I agree to the <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> and <a href="%URL_FOR_PRIVACY_POLICY%" class="sec_link">Privacy Policy</a>.') ?>
                        
                        <div class="tos_contaner">
                            <?php echo checkbox_tag('tos', 1, false, array('id' => 'terms')) ?>
                            <?php echo content_tag('label', $tos_text, array('class' => 'terms'), false) ?>
                        </div>
                        
                    </fieldset>
                    <div class="reg_submit_container">
                      <?php echo submit_tag('', array('name' => 'go', 'id' => 'reg_submit_' .$sf_user->getCulture())) ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="middle_right">
        <ul>
            <?php include_component('memberStories', 'homepageList'); ?>
        </ul>
    </div>
</div>