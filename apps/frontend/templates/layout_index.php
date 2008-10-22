<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
    <div id="box">              
        <!--- box border -->
        <div id="lb"><div id="rb">
        <div id="bb"><div id="blc">
        <div id="brc"><div id="tb">
        <div id="tlc"><div id="trc">&nbsp;
        <!--  -->   
        <div id="content">  
            <div id="header" class="index">
                <div id="left" class="index">
                    <?php echo link_to(image_tag('polska_versia.gif', 'alt=logo'), '@homepage?sf_culture=pl') ?>
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
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                        <a href=""><img src="/images/pic/index_img1.gif" alt="" border="0" /></a>
                    </div>
                    <div id="under_index_image">
                        <h2><?php echo __('BROWSE FOR FREE NOW') ?></h2>
                        <div id="register">
                            <?php use_helper('dtForm'); ?>
                            <?php echo form_tag('registration/joinNow') ?>
                                <fieldset>
                                    <?php echo pr_label_for('username'); ?><br />
                                    <?php echo input_tag('username') ?>
                                                                    
                                    <?php echo pr_label_for('email', 'Your email') ?><br />
                                    <?php echo input_tag('email') ?>
                                    
                                    <?php echo pr_label_for('password', 'Create Password') ?><br />
                                    <?php echo input_password_tag('password') ?>
                                    
                                    <?php echo pr_label_for('repeat_password', 'Repeat Password') ?><br />
                                    <?php echo input_password_tag('repeat_password') ?>
                                    
                                    <?php echo pr_label_for('looking_for', 'You are') ?><br />
                                    <?php echo select_tag('looking_for', looking_for_options()) ?>
        
                                    
                                    <?php $tos_text = __('I am 18 or older and I agree to the <a href="user_agreement.shtml" class="textsub">Terms of Use</a> and <a href="privacy_policy.shtml" class="textsub">Privacy Policy</a>.', 
                                                        array('%link_to_user_agreement%' => link_to(__('Terms of Use'), '@page?slug=user_agreement'),
                                                              '%link_to_privacy_policy%' => link_to(__('Privacy Policy'), '@page?slug=privacy_policy'))) ?>
                                    <?php echo pr_label_for('tos', $tos_text, array('class' => 'terms'), false) ?>
                                    <?php echo checkbox_tag('tos', 1, false, array('id' => 'terms')) ?>
                                    
                                </fieldset>
                                <?php echo submit_tag('', array('name' => 'go', 'id' => 'reg_submit')) ?>
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
        </div>
        <!--- end of box border -->
        </div></div></div></div>
        </div></div></div></div>
        <!-- -->
    </div>
    <?php include_component('content', 'footer'); ?>
</body>
</html>
