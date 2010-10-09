<?php use_helper('dtForm', 'Javascript'); ?>


<div>
    <?php if ($photo) : ?>
        <?php echo image_tag(($photo->getImageFilename('cropped') ? $photo->getImageUrlPath('cropped', '220x225') : $photo->getImageUrlPath('file', '220x225')), array('id' => 'join_now_photo')); ?>
    <?php endif; ?>
    
<?php echo __('JoinNow instructions') ?>
<?php echo form_tag('registration/joinNow', array('id' => 'registration_box_complete_page', 'autocomplete' => 'off')) ?>


    <fieldset>
        <?php echo pr_label_for('email', __('Your email') . '<span style="color:red;">*</span>') ?>
        <?php echo input_tag('email') ?><br />
        
        <?php echo pr_label_for('password', __('Create Password') . '<span style="color:red;">*</span>') ?>
        <?php echo input_password_tag('password') ?><br />
        
        <?php echo pr_label_for('repeat_password', __('Repeat Password') . '<span style="color:red;">*</span>') ?>
        <?php echo input_password_tag('repeat_password') ?><br />
        
        <?php echo pr_label_for('looking_for', __('You are') . '<span style="color:red;">*</span>') ?>
        <?php echo select_tag('looking_for', looking_for_options()) ?><br />

        <?php echo pr_label_for('username', __('Username') . '<span style="color:red;">*</span>'); ?>
        <?php echo input_tag('username') ?>
        <div class="check_available">
        <?php echo button_to_remote(__('Check Availability'), array(
            'update' => 'ajax_response',
            'url'    => 'ajax/usernameExists',
            'with'     => "'username=' + $('username').value",
            'script'    => true
        ), array('class' => 'button_mini butt_availability')) ?>        
        </div><br  />
    </fieldset>
    <div id="ajax_response"></div>
    
    <br class="clear" />
    
    <div id="tos_container">
    <?php $tos_text = __('I am 18 or older and I agree to the <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> and <a href="%URL_FOR_PRIVACY_POLICY%" class="sec_link">Privacy Policy</a>.') ?>
      <?php echo pr_label_for('tos', $tos_text, array('class' => 'tos'), false) ?>
      <?php echo checkbox_tag('tos', 1, false, array('class' => 'tos_input')) ?>
    </div>

    <?php echo submit_tag(__('GO!'), array('class' => 'button_save_and_cont')) ?>
</form>
</div>

<?php echo javascript_tag('
Event.observe(window, "load", function() {
    setTimeout("$(\"registration_box_complete_page\").findFirstElement().focus();",1);
});
');?>

<!-- Google Code for LoveStreet Conversion Page -->
<script type="text/javascript">
<!--
var google_conversion_id = 1064048011;
var google_conversion_language = "pl";
var google_conversion_format = "1";
var google_conversion_color = "333333";
var google_conversion_label = "nuahCKWStgEQi6uw-wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1064048011/?label=nuahCKWStgEQi6uw-wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>