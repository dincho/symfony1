<?php use_helper('Javascript') ?>
<div id="header" class="index">
    <div id="left" class="index">
        <?php if( $sf_user->getCulture() != 'en' ): ?>
            <?php echo link_to(image_tag('english_version.gif', 'alt=logo'), '@homepage?sf_culture=en') ?>
        <?php else: ?>
            <?php echo link_to(image_tag('polska_versia.gif', 'alt=logo'), '@homepage?sf_culture=pl') ?>
        <?php endif; ?>
    </div>
    <div id="polish_romance_logo">
        <?php echo link_to(image_tag('polish_romance.gif', 'alt=logo'), '#') ?>
    </div>
    <div id="right" class="index">
        <?php echo __('Already a Member?') . link_to(image_tag('sign_in.gif', 'alt=logo'), 'profile/signIn') ?>
    </div>
</div>
<div id="header_text" class="index">
    <?php echo __('Modern and beautiful singles with traditional values. For those who want love.'); ?>
</div>
<div id="middle">
    <div id="middle_left">
        Charming and gorgeous on one side, devoted to husband and children on the other, Polish Women are truly unique in today's egocentric and family hostile world. It's not surprising that in recent years they have become rare and highly demanded objects of admiration from men all over the world.<br /><br />
        Our site allows to meet both Polish men and Polish women, but it is created especially for men. It gives you a chance to meet, date or marry a woman who never rejected her feminine side, but nurtured it instead. This woman does exist and is waiting for the right guy. It might be you. You'll never know. Unless you try. Good Luck.
    </div>
    <div id="center">
        <div id="index_image">
            <?php echo link_to(image_tag('static/homepage/image_1.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_2.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_3.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_4.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_5.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_6.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_7.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_8.jpg'), 'registration/joinNow') ?>
            <?php echo link_to(image_tag('static/homepage/image_9.jpg'), 'registration/joinNow') ?>
        </div>
        <div id="under_index_image">
            <h2><?php echo __('BROWSE FOR FREE NOW') ?></h2>
            <div id="register">
                <?php use_helper('dtForm'); ?>
                <?php echo form_tag('registration/joinNow') ?>
                    <fieldset>
                        <?php echo pr_label_for('username'); ?>
                        <?php echo input_tag('username') ?><br class="clear" />
                        
                        <?php echo pr_label_for('email', 'Your email') ?>
                        <?php echo input_tag('email') ?><br class="clear" />
                        
                        <?php echo pr_label_for('password', 'Create Password') ?>
                        <?php echo input_password_tag('password') ?><br class="clear" />
                        
                        <?php echo pr_label_for('repeat_password', 'Repeat Password') ?>
                        <?php echo input_password_tag('repeat_password') ?><br class="clear" />
                        
                        <?php echo pr_label_for('looking_for', 'You are') ?>
                        <?php echo select_tag('looking_for', looking_for_options()) ?><br class="clear" />

                        
                        <?php $tos_text = __('I am 18 or older and I agree to the %link_to_user_agreement% and %link_to_privacy_policy%.', 
                                            array('%link_to_user_agreement%' => link_to(__('Terms of Use'), '@page?slug=user_agreement', array('class' => 'textsub')),
                                                  '%link_to_privacy_policy%' => link_to(__('Privacy Policy'), '@page?slug=privacy_policy'), array('class' => 'textsub'))) ?>
                        
                        <div class="tos_contaner">
                            <?php echo checkbox_tag('tos', 1, false, array('id' => 'terms')) ?>
                            <?php echo pr_label_for('tos', $tos_text, array('class' => 'terms'), false) ?>
                        </div>
                        
                    </fieldset>
                    <div class="reg_submit_container">
                        <?php echo submit_tag('', array('name' => 'go', 'id' => 'reg_submit')) ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="middle_right">
        <ul>
            <?php include_component('memberStories', 'shortList'); ?>
        </ul>
    </div>
</div>