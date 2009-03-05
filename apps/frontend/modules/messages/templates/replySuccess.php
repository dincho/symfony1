<?php use_helper('Javascript', 'dtForm') ?>
<span><?php echo __('Message will be automatically saved to drafts every 1 minute') ?></span>
<?php echo form_tag('messages/reply', array('class'  => 'msg_form')) ?>
    <?php echo input_hidden_tag('id', $message->getId(), 'class=hidden') ?>
    <?php echo input_hidden_tag('draft_id', $sf_request->getParameter('draft_id'), 'class=hidden') ?>
    <?php $profile =  $message->getMemberRelatedByFromMemberId(); ?>
    <?php $member =  $message->getMemberRelatedByToMemberId(); ?>
    <fieldset class="background_000">
        <?php echo pr_label_for('to', 'To:') ?>
        <span class="msg_to"><?php echo $profile->getUsername() ?></span><br /><br />
        
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php if(isset($draft)): ?>
            <?php echo input_tag('subject', $draft->getSubject(), 'id=title') ?><br />		    
        <?php else: ?>
        <?php echo input_tag('subject', null, 'id=title') ?><br />
        <?php endif; ?>
    </fieldset>
    <fieldset class="background_f4">
        <?php echo pr_label_for('content', 'Message:') ?>
        <?php if(isset($draft)): ?>
		    <?php echo textarea_tag('content',  $draftcontent, array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?><br />
         <?php else: ?>
        <?php echo textarea_tag('content', null, array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?><br />
         <?php endif; ?>
   <!-- PVL -->  
   
   <div id="selected_location" ></div>
     <?php echo periodically_call_remote(array(
    'frequency' => 60,
    'update'    => 'selected_location',
    'url'       => 'ajax/SaveToDraft?draft_id='.$draft->getId(),
    'with'      => "'content=' + \$F('your_story') + '&subject=' + \$F('title')"
    )) ?>
       <!-- PVL --> 
		
        <?php if( !$member->getLastImbra(true) && $profile->getLastImbra(true) ): ?>
          <label><?php echo checkbox_tag('tos', 1, false, array('id' => 'tos', 'class' => 'tos')) ?></label>
          <label class="imbra_tos">
              <?php echo __('I am familiar with <a href="%URL_FOR_PROFILE_IMBRA%" class="sec_link">background check information provided by this member</a> and I have read the <a href="%URL_FOR_IMMIGRANT_RIGHTS%" class="sec_link">Information About Legal Rights and Resources for Immigrant Victims of Domestic Violence</a>. I also understand that Polish-Romance never reveals my personal information (email, address etc.) to other members.', 
              array('%URL_FOR_PROFILE_IMBRA%' => url_for('@profile?username=' . $profile->getUsername() . '#profile_imbra_info'), '%URL_FOR_IMMIGRANT_RIGHTS%' => url_for('@page?slug=immigrant_rights'))) ?>
          </label>
        <?php endif; ?>
    </fieldset>
    <fieldset class="background_000">
        <label><?php echo link_to_function(__('Cancel'), 'window.history.go(-1)', 'class=sec_link') ?></label>
        <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?><br />
    </fieldset>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>