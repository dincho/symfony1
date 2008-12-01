<?php use_helper('Object', 'dtForm') ?>

<?php echo __('Here you can change your Privacy Settings.') ?><br />
<span><?php echo __('Change selection and click Save.') ?></span><br />
<?php echo form_tag('dashboard/privacy', array('id' => 'privacy')) ?>
    <?php echo object_checkbox_tag($member, 'getDontUsePhotos') ?>
    <?php echo pr_label_for('dont_use_photos', 'I don\'t want my photos to be used on the home page.') ?><br />
    
    <?php if( $member->getSubscriptionId() != SubscriptionPeer::FREE ): ?>
        <?php echo object_checkbox_tag($member, 'getContactOnlyFullMembers') ?>
        <?php echo pr_label_for('contact_only_full_members', 'I want to be contacted by Full Members only.') ?><br />
    <?php endif; ?>
    
    <div class="center_text">
        <?php echo __('You may also deactivate (hide) your profile by <a href="{DEACTIVATE_URL}" class="sec_link">clicking here</a>.', array('{DEACTIVATE_URL}' => url_for('dashboard/deactivate'))) ?><br /><br />
        <?php echo __('You may also delete your account by <a href="{DELETE_PROFILE_URL}" class="actions">clicking here</a>.', array('{DELETE_PROFILE_URL}' => url_for('dashboard/deleteYourAccount'))) ?>
    </div>
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>