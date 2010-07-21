<?php use_helper('Javascript', 'prDate', 'prLink', 'prProfilePhoto', 'dtForm') ?>

<div class="thread_actions">
    <div class="float-left">
      <?php if( $sf_request->getParameter('mailbox') == 'sent' ): ?>
        &bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Sent'), 'messages/index?expand=sent'); ?> 
      <?php else: ?>
        &bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Inbox'), 'messages/index', array('class' => 'sec_link')); ?> 
      <?php endif; ?>
    </div>
    <?php if($profile): ?>
        <div class="float-right">&bull;&nbsp;&nbsp;<?php echo link_to(__('Flag'), 'content/flag?username=' . $profile->getUsername(), array('class' => 'sec_link')) ?></div>
        <div class="float-right">&bull;&nbsp;&nbsp;
            <?php $block_link_title = ( $sf_user->getProfile() && $sf_user->getProfile()->hasBlockFor($profile->getId()) ) ? __('Unblock') : __('Block'); ?>
            <?php echo link_to_remote($block_link_title,
                                      array('url'     => 'block/toggle?update_selector=block_link&profile_id=' . $profile->getId(),
                                            'update'  => 'msg_container',
                                            'script'  => true
                                          ),
                                      array('class' => 'sec_link',
                                            'id'    => 'block_link', 
                                            )
                        ); ?>
            &nbsp;&nbsp;
        </div>
    <?php endif; ?>
    
    <br class="clear" />
</div>
<br />
<p class="thread_headline"><?php echo $thread->getSubject(); ?></p>

<?php foreach($messages as $message): ?>
<?php $sender = ( $message->getSenderId() == $member->getId()) ?  $member : $profile; ?>
    <a name="message_<?php echo $message->getId();?>"></a>
    <table class="threaded_message">  
            <tr>
                <td class="profile_photo">
                    <?php if( $sender ): ?>
                        <?php echo link_to_unless(!$sender->isActive(), profile_thumbnail_photo_tag($sender), '@profile?username=' . $sender->getUsername()); ?>
                    <?php endif; ?>
                </td>
                <td class="message_info">
                    <?php if( $sender ): ?>
                        <?php echo link_to_unless(!$sender->isActive(), $sender->getUsername(), '@profile?username=' . $sender->getUsername(), array('class' => 'sec_link'));?><br />
                    <?php else: ?>
                        <?php echo __('Internal System'); ?><br />
                    <?php endif; ?>
                    <?php echo format_date_pr($message->getCreatedAt(null), null, null, $member->getTimezone()); ?>
                </td>
                <td  class="message_body">
                    <?php echo strip_tags($message->getBody(ESC_RAW), '<br><a>'); ?>
                </td>
            </tr>
    </table>
    
<?php endforeach; ?>

<?php if( $profile && $profile->isActive() ): ?>
    <span id="feedback">&nbsp;</span>

    <?php echo form_tag('messages/thread', array('class'  => 'msg_form', 'id' => 'reply_message_form')) ?>
        <?php echo input_hidden_tag('id', $thread->getId(), 'class=hidden') ?>
        <?php echo input_hidden_tag('draft_id', $draft->getId(), 'class=hidden') ?>
        <?php echo input_hidden_tag('title', $thread->getSubject(), array('class' => 'hidden'));?>
        
        <fieldset class="background_f4">
            <?php echo pr_label_for('predefined_message', __('Template:')); ?>
            <?php include_component('messages', 'selectPredefinedMessage', array('subject_field_id' => '', 'body_field_id' => 'your_story', )); ?><br />
            
            <?php echo pr_label_for('your_story', __('Message:')) ?>
            <?php echo textarea_tag('content',  $draft->getBody(), array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?><br />
   
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
            <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
            <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button', 'id' => 'save_to_draft_btn', 'disabled' => 'disabled')) ?>
            <?php echo button_to(__('Discard'), 'messages/discard?draft_id=' . $draft->getId(), array('class' => 'button', )) ?>
            <br />
        </fieldset>
    </form>

    <?php include_partial('draft_save', array('draft' => $draft)); ?>
<?php endif; ?>

<br /><br />
<div class="thread_actions">
    <?php if( $sf_request->getParameter('mailbox') == 'sent' ): ?>
        &bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Sent'), 'messages/index?expand=sent', array('class' => 'sec_link')); ?> 
    <?php else: ?>
        &bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Inbox'), 'messages/index', array('class' => 'sec_link')); ?> 
    <?php endif; ?>
</div>

<?php echo javascript_tag('
Event.observe(window, "load", function() {
    setTimeout("$(\"your_story\").focus();",1);
});
');?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>