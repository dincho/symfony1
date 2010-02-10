<?php use_helper('dtForm', 'Javascript') ?>

<?php echo __('Please describe what\'s not working or how we could improve our service:') ?>
<?php echo form_tag('content/reportBug', array('id' => 'report_bug')) ?>
    <fieldset>
        <?php echo pr_label_for('subject', __('Subject:')) ?>
        <?php echo input_tag('subject') ?><br />
        
        <?php echo pr_label_for('description', __('Description:')) ?>
        <?php echo textarea_tag('description') ?>
    </fieldset>
    <fieldset class="actions">
        <?php echo link_to_function(__('Cancel and go back to previous page'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?>
    </fieldset>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>