<?php use_helper('Object', 'dtForm') ?>

<?php echo __('Privacy options headline content'); ?>

<?php echo form_tag('dashboard/privacy', array('id' => 'privacy')) ?>
    <?php echo object_checkbox_tag($member, 'getPrivateDating') ?>
    <?php echo pr_label_for('private_dating', __('Private Dating')) ?>
    <p><?php echo __('Private Dating option description'); ?></p>
    
    <?php echo object_checkbox_tag($member, 'getContactOnlyFullMembers') ?>
    <?php echo pr_label_for('contact_only_full_members', __('I want to be contacted by Full Members only.')) ?>
    <p><?php echo __('Contact only by full members option description'); ?></p>
    
    <?php echo __('Privacy options footer content'); ?>
        
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>