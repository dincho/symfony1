<?php use_helper('prDate', 'Javascript') ?>
<?php //print_r($sf_data->getRaw('sf_request')->getParameter('selected'));exit(); ?>

<?php if( count($received_messages) > 0): ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_tick">-</span>]', 'show_hide_tick("messages_form")', 'class=sec_link') ?> <span class="public_reg_notice">Received Messages</span>
</div>
<?php if($sf_request->hasParameter('confirm_delete')): ?>
    <?php $action = 'messages/delete' ?>
<?php else: ?>
    <?php $action = 'messages/index?confirm_delete=1&form_id=messages_form'; ?>
<?php endif; ?>

<?php echo form_tag($action, array('id' => 'messages_form', 'name' => 'messages_form')) ?>
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
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, array('class' => 'checkbox', 'read' => (int) $message->getIsRead())) ?></td>
            <td><?php echo link_to($message->getMemberRelatedByFromMemberId()->getUsername(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
            <td><?php echo link_to($message->getSubject(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
            <td><?php echo link_to(format_date_pr($message->getCreatedAt(null)), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
</form>
<?php endif; ?>

<?php if( count($sent_messages) > 0): ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_sent_tick">+</span>]', 'show_hide_tick("messages_form_sent")', 'class=sec_link') ?> <span class="public_reg_notice">Sent Messages</span>
</div>

<?php if($sf_request->hasParameter('confirm_delete')): ?>
    <?php $action = 'messages/delete' ?>
<?php else: ?>
    <?php $action = 'messages/index?confirm_delete=1&form_id=messages_form_sent'; ?>
<?php endif; ?>

<?php echo form_tag($action, array('id' => 'messages_form_sent', 'name' => 'messages_form_sent', 'style' => 'display: none;')) ?>    
    <?php include_partial('actions', array('form_name' => 'messages_form_sent', 'no_read_unread' => true)); ?>
    <table cellspacing="0" cellpadding="0" class="messages" id="sent_messages"> 
    <?php foreach ($sent_messages as $message): ?>
        
        <?php unset($class); ?>
        <?php $is_selected = in_array($message->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
        <?php if( $sf_request->getParameter('confirm_delete') && $is_selected ): ?> 
            <?php $class = 'delete'; ?>
        <?php endif; ?>
        
        <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
            <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, 'class=checkbox') ?></td>
            <td><?php echo link_to($message->getMemberRelatedByToMemberId()->getUsername(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
            <td><?php echo link_to($message->getSubject(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
            <td><?php echo link_to(format_date_pr($message->getCreatedAt(null)), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php include_partial('actions', array('form_name' => 'messages_form_sent', 'no_read_unread' => true)); ?>
</form>
<?php endif; ?>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
