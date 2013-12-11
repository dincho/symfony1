<?php use_helper('Javascript', 'prDate', 'prLink', 'prProfilePhoto', 'dtForm', 'Window', 'Date') ?>

<?php echo javascript_tag('submitted = false;'); ?>

<div class="thread_actions">
    <div class="float-left">
        &bull;&nbsp;&nbsp;<?php echo link_to_function(__('back to previous page'), 'history.go(-1)'); ?> 
        &nbsp;&bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Inbox'), 'messages/index', array('class' => 'sec_link')); ?>
    </div>
    <?php if($profile): ?>
        <div class="float-right">&bull;&nbsp;&nbsp;
            <?php echo link_to_prototype_window(__('Flag'), 'flag_profile', array('title'          => __('Flag %USERNAME%', array('%USERNAME%' => $profile->getUsername())), 
                                                                                    'url'            => 'content/flag?layout=window&username=' . $profile->getUsername(), 
                                                                                    'id'             => '"flag_profile_window"', 
                                                                                    'width'          => '550', 
                                                                                    'height'         => '340',
                                                                                    'center'         => 'true', 
                                                                                    'minimizable'    => 'false',
                                                                                    'maximizable'    => 'false',
                                                                                    'closable'       => 'true', 
                                                                                    'destroyOnClose' => "true",
                                                                                    'className'      => 'polishdate',
                                                                                ), 
                                                                             array('absolute'        => false, 
                                                                                   'id'              => 'flag_profile_link_window',
                                                                                   'class'           => 'sec_link',
                                                                                 )); ?>
        </div>
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
                    <?php echo format_date_pr($message->getCreatedAt(null), null, 'dd-MMM-yyyy', $member->getTimezone()); ?>
                </td>
                <td class="message_body">
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
        
        <fieldset class="background_f4 thread_msg">
            <?php echo pr_label_for('your_story', __('Message:')) ?>
            <div id="thread_text"><?php echo __('Never include your last name, e-mail address, home address, phone number, place of work and any other identifying information in initial messages with other members'); ?>
            </div>
            <?php echo textarea_tag('content',  isset($content)? $content : $draft->getBody(), array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?>
            <br />
   
            <?php if( !$member->getLastImbra(true) && $profile->getLastImbra(true) ): ?>
              <label><?php echo checkbox_tag('tos', 1, false, array('id' => 'tos', 'class' => 'tos')) ?></label>
              <label class="imbra_tos">
                  <?php echo __('I am familiar with this member IMBRA and I accept the TOS', 
                  array('%URL_FOR_PROFILE_IMBRA%' => url_for('@profile?username=' . $profile->getUsername() . '#profile_imbra_info'), '%URL_FOR_IMMIGRANT_RIGHTS%' => url_for('@page?slug=immigrant_rights'))) ?>
              </label>
            <?php endif; ?>
        </fieldset>
    
        <fieldset class="background_000">
            <label></label>
            <?php echo submit_tag(__('Send'), array('class' => 'button', 'onclick' => "if(submitted) return false; messagebar_message('".__('Sending message...')."'); submitted = true; return true;") ) ?>
            <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button', 'id' => 'save_to_draft_btn')) ?>
            <?php echo button_to(__('Discard'), 'messages/discard?draft_id=' . $draft->getId(), array('class' => 'button', )) ?>
            <br />
        </fieldset>
    </form>

    <?php include_partial('draft_save', array('draft' => $draft)); ?>
<?php endif; ?>

<br /><br />
<div class="thread_actions">
        &bull;&nbsp;&nbsp;<?php echo link_to_function(__('back to previous page'), 'history.go(-1)'); ?> 
        &nbsp;&bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Inbox'), 'messages/index', array('class' => 'sec_link')); ?>
</div>

<?php echo javascript_tag('
Event.observe(window, "load", function() {
    setTimeout("$(\"your_story\").focus();",1);
});
');?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
