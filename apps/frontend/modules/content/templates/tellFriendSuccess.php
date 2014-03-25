<?php use_helper('dtForm') ?>

<?php echo __('I\'d like tell my friend about PolishRomance.com') ?>

<?php echo form_tag('content/tellFriend', array('id' => 'tell_a_friend')) ?>
    <fieldset>
        <div class="form_info">
            <strong><?php echo __('Our Privacy Policy') ?></strong><br /><br />
            <?php echo __('To assure your friend\'s confidentiality:') ?><br />
            &bull;&nbsp;<?php echo __('We will only contact your friend once.') ?><br />
            &bull;&nbsp;<?php echo __('We will not use your friend\'s contact information for any other purpose.') ?><br />
            &bull;&nbsp;<?php echo __('We will not save your friend\'s contact information.') ?><br />
            &bull;&nbsp;<?php echo __('We will not forward your friend\'s contact information to any other organization.') ?><br />
        </div>
        
        <?php echo pr_label_for('friend_email', __('Your Friend Email')) ?>
        <?php echo input_tag('friend_email') ?><br />
        
        <?php echo pr_label_for('email', __('Your email')) ?>
        <?php echo input_tag('email') ?><br />
    </fieldset>

    <fieldset class="actions">
        <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
        <?php echo link_to(__('Cancel'), 'dashboard/index', array('class' => 'button cancel')) ?><br />
    </fieldset>
    
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>