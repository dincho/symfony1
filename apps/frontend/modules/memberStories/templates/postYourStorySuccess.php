<?php use_helper('dtForm') ?>

<?php echo __('If you have experience of personal relation with a Polish single and would like to share it with other members, please fill out the form below.<br />After review, we will publish your story and your name.') ?>
<?php echo form_tag('memberStories/postYourStory', array('class' => 'msg_form', 'id' => 'post_story')) ?>
    <fieldset>
        <?php if( !$sf_user->isAuthenticated() ): ?>
            <?php echo pr_label_for('your_name', 'Your Name') ?>
            <?php echo input_tag('your_name') ?><br />
            
            <?php echo pr_label_for('email', 'Email') ?>
            <?php echo input_tag('email') ?><br />
        <?php endif; ?>
        
        <?php echo pr_label_for('story_title', 'Title') ?>
        <?php echo input_tag('story_title') ?><br />
        
        <?php echo pr_label_for('your_story', 'Your Story') ?>
        <?php echo textarea_tag('your_story', null, array('rows' => 10, 'cols' => 30)) ?><br />
    </fieldset>
    <fieldset>
        <label><input type="checkbox" name="tos" id="tos" class="tos" value="1" /></label>
        
        <?php $tos_text = __('I am 18 or older and I agree to the <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> and <a href="%URL_FOR_PRIVACY_POLICY%" class="sec_link">Privacy Policy</a>.') ?>      
        <?php echo pr_label_for('tos', $tos_text, array('class' => 'tos')) ?>
    </fieldset>
    <fieldset class="actions">
        <?php echo link_to(__('Cancel and go back to previous page'), $sf_data->getRaw('sf_user')->getRefererUrl(), 'class=sec_link_small') ?><br />
        <?php echo submit_tag(__('Submit'), array('class' => 'button')) ?>
    </fieldset>
</form>
<?php if( $sf_user->isAuthenticated() ): ?>
    <?php slot('footer_menu') ?>
        <?php include_partial('content/footer_menu') ?>
    <?php end_slot(); ?>
<?php endif; ?>