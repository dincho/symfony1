<?php use_helper('dtForm') ?>

<?php echo ( $member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED ) ? __('Here you can activate your profile') : __('Here you can deactivate your profile') ?><br />
<?php echo __('When deactivated, your profile is not visible, but you are still be able to change your profile and settings.') ?> <?php echo link_to(__('To delete your account, click here.'), 'dashboard/deleteYourAccount', array('class' => 'sec_link')) ?><br />
<span><?php echo __('Make changes and click Save.') ?></span>
<?php echo form_tag('dashboard/deactivate', array('id' => 'deactivate')) ?>
    <?php if( $member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED ): ?>
        <span class="public_reg_notice"><?php echo __('Your profile is currently <b>DEACTIVE</b>') ?></span><br />
    <?php else: ?>
        <span class="public_reg_notice"><?php echo __('Your profile is currently <b>ACTIVE</b>') ?></span><br />
    <?php endif; ?>
    
    <?php echo radiobutton_tag('deactivate_profile', 0, ($member->getMemberStatusId() != MemberStatusPeer::DEACTIVATED) ) ?>
    <?php echo pr_label_for('deactivate_profile', 'Activate your profile') ?><br />
    
    <?php echo radiobutton_tag('deactivate_profile', 1, ($member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED) ) ?>
    <?php echo pr_label_for('deactivate_profile', 'Deactivate your profile') ?><br />
    
    <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button', 'name' => 'save')) ?>
</form>