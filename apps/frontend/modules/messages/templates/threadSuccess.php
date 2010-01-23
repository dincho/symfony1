<?php use_helper('Javascript', 'prDate', 'prLink', 'prProfilePhoto', 'dtForm') ?>

<p>Conversation between You and <?php echo $profile->getUsername(); ?></p>

<?php foreach($messages as $message): ?>
<?php $sender = ( $message->getSenderId() == $member->getId()) ?  $member : $profile; ?>
    <a name="message_<?php echo $message->getId();?>"></a>
    <table class="threaded_message" style="border: 1px solid #3D3D3D; border-width: 0 0 1px 0;">
            <tr>
                <td colspan="3" style="background-color: #3D3D3D;"><b><a name="message_<?php echo $message->getId();?>">&nbsp;</a></b></td>
            </tr>    
            <tr>
                <td width="55px"><?php echo link_to_unless(!$sender->isActive(), profile_thumbnail_photo_tag($sender), '@profile?username=' . $sender->getUsername()); ?></td>
                <td width="140px"><?php echo link_to_unless(!$sender->isActive(), $sender->getUsername(), '@profile?username=' . $sender->getUsername(), array('class' => 'sec_link'));?><br />
                    <?php echo format_date_pr($message->getCreatedAt(null), $time_format = ', hh:mm', $date_format = 'dd MMMM'); ?>
                </td>
                <td  style="background-color: #4f4f4f;">
                    <?php echo strip_tags($message->getBody(ESC_RAW), '<br><a>'); ?>
                </td>
            </tr>
    </table>
    
<?php endforeach; ?>

<?php if( $profile->isActive() ): ?>
    <span id="feedback">&nbsp;</span>

    <?php echo form_tag('messages/thread', array('class'  => 'msg_form')) ?>
        <?php echo input_hidden_tag('id', $thread->getId(), 'class=hidden') ?>
        <?php echo input_hidden_tag('draft_id', $draft->getId(), 'class=hidden') ?>
        <?php echo input_hidden_tag('title', $thread->getSubject(), array('class' => 'hidden'));?>
        
        <fieldset class="background_f4">
            <?php echo pr_label_for('your_story', 'Message:') ?>
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
            <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?>
            <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button_mini', 'id' => 'save_to_draft_btn', 'disabled' => 'disabled')) ?>
            <?php echo button_to(__('Discard'), 'messages/discard?draft_id=' . $draft->getId(), array('class' => 'button_mini', )) ?>
            <br />
        </fieldset>
    </form>

    <?php include_partial('draft_save', array('draft' => $draft)); ?>
<?php endif; ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>