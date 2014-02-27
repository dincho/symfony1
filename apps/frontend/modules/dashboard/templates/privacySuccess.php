<?php use_helper('Object', 'dtForm') ?>

<?php echo javascript_include_tag('save_changes') ?>

<?php echo __('Privacy options headline content'); ?>

<?php echo form_tag('dashboard/privacy', array('id' => 'privacy')) ?>
    <?php echo object_checkbox_tag($member, 'getPrivateDating') ?>
    <?php echo pr_label_for('private_dating', __('Private Dating')) ?>
    <p><?php echo __('Private Dating option description'); ?></p>
    
    <?php echo object_checkbox_tag($member, 'getContactOnlyFullMembers') ?>
    <?php echo pr_label_for('contact_only_full_members', __('I want to be contacted by Full Members only.')) ?>
    <p><?php echo __('Contact only by full members option description'); ?></p>

    <?php echo object_checkbox_tag($member, 'getHideVisits') ?>
    <?php echo pr_label_for('hide_visits', __('Hide Visitors Counter')) ?>
    <p><?php echo __('Hide Visitors Counter on my profile page'); ?></p>

    <?php echo __('Privacy options footer content'); ?>
    <br />
    <?php echo submit_tag(__('Save'), array('class' => 'button', 'id' => 'save_btn')) ?>
    <?php echo button_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'button')) ?>
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>