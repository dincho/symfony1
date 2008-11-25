<?php use_helper('dtForm') ?>

<?php echo __('Here you may change the way you receive notifications from our website.') ?><br />
<span><?php echo __('Make changes and click Save.') ?></span>
<?php echo form_tag('dashboard/emailNotifications', array('id' => 'deactivate')) ?>
    <?php echo __('When I receive a new message, please send me an email:') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 0, ($member->getEmailNotifications() == 0), array('id' => 'email_notifications_0')) ?>
    <?php echo pr_label_for('email_notifications_0', 'Each time I receive a message') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 1, ($member->getEmailNotifications() == 1), array('id' => 'email_notifications_1')) ?>
    <?php echo pr_label_for('email_notifications_0', 'Every 24 hours') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 3, ($member->getEmailNotifications() == 3), array('id' => 'email_notifications_3')) ?>
    <?php echo pr_label_for('email_notifications_0', 'Every 3 days') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 7, ($member->getEmailNotifications() == 7), array('id' => 'email_notifications_7')) ?>
    <?php echo pr_label_for('email_notifications_0', 'Every 7 days') ?><br />
    
    <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>