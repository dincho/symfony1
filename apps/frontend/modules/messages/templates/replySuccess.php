<?php use_helper('Javascript', 'dtForm') ?>

<span id="feedback">&nbsp;</span>

<?php echo form_tag('messages/reply', array('class'  => 'msg_form')) ?>
    <?php echo input_hidden_tag('id', $message->getId(), 'class=hidden') ?>
    <?php echo input_hidden_tag('draft_id', $draft->getId(), 'class=hidden') ?>
    <?php $profile =  $message->getMemberRelatedByFromMemberId(); ?>
    <?php $member =  $message->getMemberRelatedByToMemberId(); ?>
    
    <fieldset class="background_000">
        <?php echo pr_label_for('to', 'To:') ?>
        <span class="msg_to"><?php echo $profile->getUsername() ?></span><br /><br />
        
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php echo input_tag('subject', $draft->getSubject(), 'id=title') ?><br />        
    </fieldset>
    
    <fieldset class="background_f4">
        <?php echo pr_label_for('content', 'Message:') ?>
        <?php echo textarea_tag('content',  $draft->getContent(), array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?><br />
   
        <?php if( !$member->getLastImbra(true) && $profile->getLastImbra(true) ): ?>
          <label><?php echo checkbox_tag('tos', 1, false, array('id' => 'tos', 'class' => 'tos')) ?></label>
          <label class="imbra_tos">
              <?php echo __('I am familiar with <a href="%URL_FOR_PROFILE_IMBRA%" class="sec_link">background check information provided by this member</a> and I have read the <a href="%URL_FOR_IMMIGRANT_RIGHTS%" class="sec_link">Information About Legal Rights and Resources for Immigrant Victims of Domestic Violence</a>. I also understand that Polish-Romance never reveals my personal information (email, address etc.) to other members.', 
              array('%URL_FOR_PROFILE_IMBRA%' => url_for('@profile?username=' . $profile->getUsername() . '#profile_imbra_info'), '%URL_FOR_IMMIGRANT_RIGHTS%' => url_for('@page?slug=immigrant_rights'))) ?>
          </label>
        <?php endif; ?>
    </fieldset>
    
    <fieldset class="background_000">
        <label></label>
        <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?>
        <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button_mini', 'id' => 'save_to_draft_btn', 'disabled' => 'disabled')) ?>
        <?php echo button_to(__('Discard'), 'messages/discard?draft_id=' . $draft->getId(), array('class' => 'button_mini', )) ?>
        <br />
    </fieldset>
</form>

<?php include_partial('draft_save', array('draft' => $draft)); ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>