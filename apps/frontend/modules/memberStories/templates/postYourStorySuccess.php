<?php use_helper('dtForm', 'Javascript', 'recaptcha') ?>

<?php echo __('If you have experience of personal relation with a Polish single and would like to share it with other members, please fill out the form below.<br />After review, we will publish your story and your name.') ?>
<?php echo form_tag('memberStories/postYourStory', array('class' => 'msg_form', 'id' => 'post_story')) ?>
    <fieldset>
        <?php if( !$sf_user->isAuthenticated() ): ?>
            <?php echo pr_label_for('your_name', __('Your Name')) ?>
            <?php echo input_tag('your_name') ?><br />
            
            <?php echo pr_label_for('email', __('Email')) ?>
            <?php echo input_tag('email') ?><br />
        <?php endif; ?>
        
        <?php echo pr_label_for('story_title', __('Title')) ?>
        <?php echo input_tag('story_title') ?><br />
        
        <?php echo pr_label_for('your_story', __('Your Story')) ?>
        <?php echo textarea_tag('your_story', null, array('rows' => 10, 'cols' => 30, 'maxlength' => 2500)) ?><br />
        <?php echo javascript_tag('parseCharCounts();') ?><br />
                            
        <div id="recaptcha_post_your_story">
          <?php $recaptcha_keys = sfConfig::get('app_recaptcha_' . str_replace('.', '_', $sf_request->getHost())); ?>
          <?php echo recaptcha_get_html($recaptcha_keys['publickey']); ?>
        </div>
    </fieldset>
    <fieldset>
        <label><input type="checkbox" name="tos" id="tos" class="tos" value="1" /></label>
        
        <?php $tos_text = __('I am 18 or older and I agree to the <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> and <a href="%URL_FOR_PRIVACY_POLICY%" class="sec_link">Privacy Policy</a>.') ?>      
        <?php echo pr_label_for('tos', $tos_text, array('class' => 'tos')) ?>
    </fieldset>
    <fieldset class="actions">
        <?php echo submit_tag(__('Submit'), array('class' => 'button')) ?>
        <?php echo link_to(__('Cancel'), $sf_data->getRaw('sf_user')->getRefererUrl(),  array('class' => 'button')) ?>
    </fieldset>
</form>


<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>
