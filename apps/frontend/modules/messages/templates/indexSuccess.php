<?php use_helper('prDate', 'Javascript', 'prProfilePhoto') ?>

<?php if( !count($received_messages) > 0 && !count($draft_messages) > 0 && !count($sent_messages) > 0 ): ?>
    <p><?php echo __('You currently have no messages'); ?></p>
<?php endif; ?>

<?php if( count($received_messages) > 0): ?>
<?php $tick = ($sf_request->hasParameter('expand')) ? '+' : '-'; ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_tick">-</span>]', 'show_hide_tick("messages_form")', 'class=sec_link') ?> <span class="public_reg_notice"><?php echo __('Received Messages <strong>(%cnt_unread%)</strong>', array('%cnt_unread%' => $cnt_unread))?></span>
</div>
<?php if($sf_request->hasParameter('confirm_delete')): ?>
    <?php $action = 'messages/delete' ?>
<?php else: ?>
    <?php $action = 'messages/index?confirm_delete=1&form_id=messages_form'; ?>
<?php endif; ?>

<?php $style = ($sf_request->hasParameter('expand')) ? 'display: none;' : ''; ?>
<?php echo form_tag($action, array('id' => 'messages_form', 'name' => 'messages_form', 'style' => $style)) ?>
    <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
    <table cellspacing="0" cellpadding="0" class="messages"> 
    <?php foreach ($received_messages as $message): ?>
        <?php unset($class); ?>
        <?php $is_selected = in_array($message->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( !$message->getIsRead() ) $class = 'bold' ?>
        <?php if( $sf_request->getParameter('confirm_delete') && $is_selected ): ?> 
            <?php $class = ( isset($class) ) ? 'delete bold' : 'delete'; ?>
        <?php endif; ?>
    
        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="unread_circle">
                <?php echo ( !$message->getIsRead() ) ? image_tag('circle-blue.png') : '&nbsp;'; ?>
            </td>          
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, array('class' => 'checkbox', 'read' => (int) $message->getIsRead())) ?></td>
          
            <td class="profile_image"><?php echo link_to(profile_thumbnail_photo_tag($message->getMemberRelatedByFromMemberId()), 'messages/view?id=' . $message->getId()); ?></td>
            <td class="message_from">
                <?php echo link_to($message->getMemberRelatedByFromMemberId()->getUsername(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?><br />
                <?php echo link_to(format_date_pr($message->getCreatedAt(null), $time_format = ', hh:mm', $date_format = 'dd MMMM'), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?>
            </td>
            <td>
                <?php echo link_to($message->getSubject(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?><br />
                <?php echo Tools::truncate($message->getContent(), 80) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
</form>
<?php endif; ?>


<?php if( count($draft_messages) > 0): ?>
<?php $tick = ($sf_request->getParameter('expand') == 'drafts') ? '-' : '+'; ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_draft_tick">'.$tick.'</span>]', 'show_hide_tick("messages_form_draft")', 'class=sec_link') ?> 
    <span class="public_reg_notice"><?php echo __('Draft Messages (%NUM_DRAFTS%)', array('%NUM_DRAFTS%' => count($draft_messages))) ?></span>
</div>

<?php if($sf_request->hasParameter('confirm_delete_draft')): ?>
    <?php $action = 'messages/DeleteDraft' ?>
<?php else: ?>
    <?php $action = 'messages/index?expand=drafts&confirm_delete_draft=1&form_id=messages_form_draft'; ?>
<?php endif; ?>

<?php $style = ($sf_request->getParameter('expand') == 'drafts') ? '' : 'display: none;'; ?>
<?php echo form_tag($action, array('id' => 'messages_form_draft', 'name' => 'messages_form_draft', 'style' => $style)) ?>    
    <?php include_partial('actionsdraft', array('form_name' => 'messages_form_draft', 'no_read_unread' => true)); ?>
    <table cellspacing="0" cellpadding="0" class="messages" id="draft_messages"> 
    <?php foreach ($draft_messages as $message): ?>
        
        <?php unset($class); ?>
        <?php $is_selected = in_array($message->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( $sf_request->getParameter('confirm_delete_draft') && $is_selected ): ?> 
            <?php $class = 'delete'; ?>
        <?php endif; ?>
        
        <?php if( $message->getReplyTo() ): ?>
            <?php $message_form_link = 'messages/reply?draft_id='.$message->getId().'&profile_id=' . $message->getToMemberId() . '&id=' . $message->getReplyTo() ?>
        <?php else: ?>
            <?php $message_form_link = 'messages/send?draft_id='.$message->getId().'&profile_id=' . $message->getToMemberId() ?>
        <?php endif; ?>

        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="unread_circle">&nbsp;</td>          
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, array('class' => 'checkbox')) ?></td>
          
            <td class="profile_image"><?php echo link_to(profile_thumbnail_photo_tag($message->getMemberRelatedByToMemberId()), $message_form_link); ?></td>
            <td class="message_from">
                <?php echo link_to($message->getMemberRelatedByToMemberId()->getUsername(), $message_form_link, array('class' => 'sec_link')) ?><br />
                <?php echo link_to(format_date_pr($message->getUpdatedAt(null), $time_format = ', hh:mm', $date_format = 'dd MMMM'), $message_form_link, array('class' => 'sec_link')) ?>
            </td>
            <td>
                <?php echo link_to($message->getSubject(), $message_form_link, array('class' => 'sec_link')) ?><br />
                <?php echo Tools::truncate($message->getContent(), 80) ?>
            </td>
        </tr>
                
    <?php endforeach; ?>
    </table>
    <?php include_partial('actionsdraft', array('form_name' => 'messages_form_draft', 'no_read_unread' => true)); ?>
</form>
<?php endif; ?>

<?php if( count($sent_messages) > 0): ?>
<?php $tick = ($sf_request->getParameter('expand') == 'sent') ? '-' : '+'; ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_sent_tick">'.$tick.'</span>]', 'show_hide_tick("messages_form_sent")', 'class=sec_link') ?> <span class="public_reg_notice"><?php echo __('Sent Messages')?></span>
</div>

<?php if($sf_request->hasParameter('confirm_delete')): ?>
    <?php $action = 'messages/delete' ?>
<?php else: ?>
    <?php $action = 'messages/index?expand=sent&confirm_delete=1&form_id=messages_form_sent'; ?>
<?php endif; ?>


<?php $style = ($sf_request->getParameter('expand') == 'sent') ? '' : 'display: none;'; ?>
<?php echo form_tag($action, array('id' => 'messages_form_sent', 'name' => 'messages_form_sent', 'style' => $style)) ?>    
    <?php include_partial('actions', array('form_name' => 'messages_form_sent', 'no_read_unread' => true)); ?>
    <table cellspacing="0" cellpadding="0" class="messages" id="sent_messages"> 
    <?php foreach ($sent_messages as $message): ?>
        
        <?php unset($class); ?>
        <?php $is_selected = in_array($message->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( $sf_request->getParameter('confirm_delete') && $is_selected ): ?> 
            <?php $class = 'delete'; ?>
        <?php endif; ?>
        
        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="unread_circle">&nbsp;</td>          
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, array('class' => 'checkbox')) ?></td>
          
            <td class="profile_image"><?php echo link_to(profile_thumbnail_photo_tag($message->getMemberRelatedByToMemberId()), 'messages/view?id=' . $message->getId()); ?></td>
            <td class="message_from">
                <?php echo link_to($message->getMemberRelatedByToMemberId()->getUsername(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?><br />
                <?php echo link_to(format_date_pr($message->getCreatedAt(null), $time_format = ', hh:mm', $date_format = 'dd MMMM'), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?>
            </td>
            <td>
                <?php echo link_to($message->getSubject(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?><br />
                <?php echo Tools::truncate($message->getContent(), 80) ?>
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
