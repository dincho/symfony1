<?php use_helper('prDate', 'Javascript', 'prProfilePhoto') ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var formId = '<?php echo $sf_request->getParameter('form_id')?>';
	if(formId){
			jQuery("form").hide();
			jQuery("#"+formId).show();
			jQuery("#messages_group").find("a").removeClass("active_group");
			jQuery("#messages_group").find("a").each(function(){
				if(jQuery(this).attr("rel") == formId){
					jQuery(this).addClass("active_group");
				}
			});
		}
});
</script>
<div id="messages_group">
	<a href="#received" id="received_messages" rel="messages_form" class="active_group" ><?php echo __('Received Messages <strong>(%cnt_unread%)</strong>', array('%cnt_unread%' => $cnt_unread))?></a>
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href="#draft" id="draft_messages" rel="messages_form_draft" ><?php echo __('Draft Messages (%NUM_DRAFTS%)', array('%NUM_DRAFTS%' => count($draft_messages))) ?></a>
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href="#sent" id="sent_messages" rel="messages_form_sent" ><?php echo __('Sent Messages')?></a>
</div>

<?php if( !count($threads_received) > 0 && !count($draft_messages) > 0 && !count($sent_threads) > 0 ): ?>
    <p><?php echo __('You currently have no messages'); ?></p>
<?php endif; ?>

<?php if( count($threads_received) > 0): ?>
<?php if($sf_request->hasParameter('confirm_delete')): ?>
    <?php $action = 'messages/delete' ?>
<?php else: ?>
    <?php $action = 'messages/index?confirm_delete=1&form_id=messages_form'; ?>
<?php endif; ?>

<?php //$style = ($sf_request->hasParameter('expand')) ? 'display: none;' : ''; ?>
<?php echo form_tag($action, array('id' => 'messages_form', 'name' => 'messages_form', 'style' => '')) ?>
    <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
    <table cellspacing="0" cellpadding="0" class="messages"> 
    <?php foreach ($threads_received as $thread): ?>
        <?php unset($class); ?>
        <?php $is_selected = in_array($thread->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( !$thread->isRead() ) $class = 'bold' ?>
        <?php if( $sf_request->getParameter('confirm_delete') && $is_selected ): ?> 
            <?php $class = ( isset($class) ) ? 'delete bold' : 'delete'; ?>
        <?php endif; ?>
    
        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="unread_circle">
                <?php if( !$thread->isRead() ): ?>
                    <?php echo image_tag('circle-blue.png'); ?>
                <?php elseif( $thread->getSnippetMemberId() == $sf_user->getId() ): ?>
                    <?php echo image_tag('reply_left_arrow.png'); ?>
                <?php else: ?>&nbsp;
                <?php endif;?>
            </td>          
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $thread->getId(), $is_selected, array('class' => 'checkbox', 'read' => (int) $thread->isRead())) ?></td>
          
            <td class="profile_image">
                <?php if( $thread->object): ?>
                    <?php echo link_to(profile_thumbnail_photo_tag($thread->object), '@profile?username=' . $thread->object->getUsername()); ?>
                <?php endif; ?>
            </td>
            <td class="message_from">
                <?php //var_dump($thread->object);exit(); ?>
                <?php if( $thread->object ): ?>
                    <?php echo link_to($thread->object->getUsername(), '@profile?username=' . $thread->object->getUsername(), array('class' => 'sec_link')) ?>
                    <?php if ($thread->getCntMessages() > 1): ?>
                        <span class="message_count">(<?php echo $thread->getCntMessages(); ?>)</span>
                    <?php endif; ?>
                    <br />
                <?php else: ?>
                    <?php echo __('Internal System'); ?><br />
                <?php endif; ?>
                <a href="<?php echo url_for('messages/thread?mailbox=inbox&id=' . $thread->getId()); ?>" class="sec_link"><?php echo format_date_pr($thread->getUpdatedAt(null), null, 'dd-MMM-yyyy', $member->getTimezone()); ?></a>
            </td>
            <td class="message_body">
                <a href="<?php echo url_for('messages/thread?mailbox=inbox&id=' . $thread->getId()); ?>" class="sec_link"><?php echo $thread->getSubject(); ?></a><?php if ($thread->getCntDrafts() > 0): ?>, <span class="draft"><?php echo __('Draft'); ?></span><?php endif; ?><br />
                <?php echo Tools::truncate($thread->getSnippet(), $received_messages_truncate_limit) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
</form>
<?php endif; ?>


<?php if( count($draft_messages) > 0): ?>

<?php if($sf_request->hasParameter('confirm_delete_draft')): ?>
    <?php $action = 'messages/deleteDraft' ?>
<?php else: ?>
    <?php $action = 'messages/index?expand=drafts&confirm_delete_draft=1&form_id=messages_form_draft'; ?>
<?php endif; ?>

<?php echo form_tag($action, array('id' => 'messages_form_draft', 'name' => 'messages_form_draft', 'style' => 'display: none;')) ?>    
    <?php include_partial('actionsdraft', array('form_name' => 'messages_form_draft', 'no_read_unread' => true)); ?>
    <table cellspacing="0" cellpadding="0" class="messages" id="draft_messages"> 
    <?php foreach ($draft_messages as $message): ?>
        
        <?php unset($class); ?>
        <?php $is_selected = in_array($message->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( $sf_request->getParameter('confirm_delete_draft') && $is_selected ): ?> 
            <?php $class = 'delete'; ?>
        <?php endif; ?>
        
        <?php if( $message->getThreadId() ): ?>
            <?php $message_form_link = 'messages/thread?draft_id='.$message->getId().'&id=' . $message->getThreadId() ?>
        <?php else: ?>
            <?php $message_form_link = 'messages/send?draft_id='.$message->getId().'&recipient_id=' . $message->getRecipientId() ?>
        <?php endif; ?>

        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="unread_circle">&nbsp;</td>          
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, array('class' => 'checkbox')) ?></td>
          
            <td class="profile_image"><?php echo link_to(profile_thumbnail_photo_tag($message->getMemberRelatedByRecipientId()), '@profile?username=' . $message->getMemberRelatedByRecipientId()->getUsername()); ?></td>
            <td class="message_from">
                <?php echo link_to($message->getMemberRelatedByRecipientId()->getUsername(), '@profile?username=' . $message->getMemberRelatedByRecipientId()->getUsername(), array('class' => 'sec_link')) ?><br />
                <?php echo link_to(format_date_pr($message->getUpdatedAt(null), null, 'dd-MMM-yyyy', $member->getTimezone()), $message_form_link, array('class' => 'sec_link')) ?>
            </td>
            <td class="message_body">
                <?php echo link_to($message->getSubject(), $message_form_link, array('class' => 'sec_link')) ?><br />
                <?php echo Tools::truncate($message->getBody(), 80) ?>
            </td>
        </tr>
                
    <?php endforeach; ?>
    </table>
    <?php include_partial('actionsdraft', array('form_name' => 'messages_form_draft', 'no_read_unread' => true)); ?>
</form>
<?php endif; ?>


<?php if( count($sent_threads) > 0): ?>

<?php if($sf_request->hasParameter('confirm_delete')): ?>
    <?php $action = 'messages/delete' ?>
<?php else: ?>
    <?php $action = 'messages/index?expand=sent&confirm_delete=1&form_id=messages_form_sent'; ?>
<?php endif; ?>

<?php echo form_tag($action, array('id' => 'messages_form_sent', 'name' => 'messages_form_sent', 'style' => 'display: none;')) ?>    
    <?php include_partial('actions', array('form_name' => 'messages_form_sent', 'no_read_unread' => true)); ?>
    <table cellspacing="0" cellpadding="0" class="messages" id="sent_messages"> 
    <?php foreach ($sent_threads as $thread): ?>
        
        <?php unset($class); ?>
        <?php $is_selected = in_array($thread->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( $sf_request->getParameter('confirm_delete') && $is_selected ): ?> 
            <?php $class = 'delete'; ?>
        <?php endif; ?>
        
        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="unread_circle">
                <?php if( $thread->getSnippetMemberId() == $sf_user->getId() ): ?>
                    <?php echo image_tag('reply_left_arrow.png'); ?>
                <?php else: ?>&nbsp;
                <?php endif;?>
            </td>       
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $thread->getId(), $is_selected, array('class' => 'checkbox')) ?></td>
          
            <td class="profile_image"><?php echo link_to(profile_thumbnail_photo_tag($thread->object), '@profile?username=' .$thread->object->getUsername()); ?></td>
            <td class="message_from">
                <?php echo link_to($thread->object->getUsername(), '@profile?username=' .$thread->object->getUsername(), array('class' => 'sec_link')) ?>
                <?php if ($thread->getCntMessages() > 1): ?>
                    <span class="message_count">(<?php echo $thread->getCntMessages(); ?>)</span>
                <?php endif; ?>
                <br />
                <a href="<?php echo url_for('messages/thread?mailbox=sent&id=' . $thread->getId()); ?>" class="sec_link"><?php echo format_date_pr($thread->getUpdatedAt(null), null, 'dd-MMM-yyyy', $member->getTimezone()); ?></a>
            </td>
            <td class="message_body">
                <a href="<?php echo url_for('messages/thread?mailbox=sent&id=' . $thread->getId()); ?>" class="sec_link"><?php echo $thread->getSubject(); ?></a><?php if ($thread->getCntDrafts() > 0): ?>, <span class="draft"><?php echo __('Draft'); ?></span><?php endif; ?>
                <br />
                <?php echo Tools::truncate($thread->getSnippet(), 80) ?>
            </td>
        </tr>
                
    <?php endforeach; ?>
    </table>
    <?php include_partial('actions', array('form_name' => 'messages_form_sent', 'no_read_unread' => true)); ?>
</form>
<?php endif; ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
