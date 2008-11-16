<?php use_helper('Javascript', 'dtForm') ?>
<span><?php echo __('Message will be automatically saved to drafts every 1 minute') ?></span>
<?php echo form_tag('messages/reply', array('class'  => 'msg_form')) ?>
    <?php echo input_hidden_tag('id', $message->getId(), 'class=hidden') ?>
    <?php $profile =  $message->getMemberRelatedByFromMemberId(); ?>
    <fieldset class="background_000">
        <?php echo pr_label_for('to', 'To:') ?>
        <span class="msg_to"><?php echo $profile->getUsername() ?></span><br /><br />
        
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php echo input_tag('subject', null, 'id=title') ?><br />
    </fieldset>
    <fieldset class="background_f4">
        <?php echo pr_label_for('content', 'Message:') ?>
        <?php echo textarea_tag('content', null, array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?><br />
        
        <?php if( $profile->getLastImbra(true) ): ?>
          <label><?php echo checkbox_tag('tos', 1, false, array('id' => 'tos', 'class' => 'tos')) ?></label>
          <label class="imbra_tos">I am familiar with <a href="profile_man.shtml#imbra" class="sec_link">background check information provided by this member</a> and I have read the <a href="immigrant_rights.shtml" class="sec_link">Information About Legal Rights and Resources for Immigrant Victims of Domestic Violence</a>. I also understand that Polish-Romance never reveals my personal information (email, address etc.) to other members.</label>
        <?php endif; ?>
    </fieldset>
    <fieldset class="background_000">
        <label><?php echo link_to_function(__('Cancel'), 'window.history.go(-1)', 'class=sec_link') ?></label>
        <?php echo submit_tag('', 'class=send_mini') ?><br />
    </fieldset>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>