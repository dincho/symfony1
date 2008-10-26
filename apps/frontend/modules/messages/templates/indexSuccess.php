<?php use_helper('prDate', 'Javascript') ?>

<?php if( count($received_messages) > 0): ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_tick">-</span>]', 'show_hide_tick("messages_form")', 'class=sec_link') ?> <span class="public_reg_notice">Received Messages</span>
</div>
<?php echo form_tag('messages/delete', array('id' => 'messages_form')) ?>
    <fieldset class="text_1">
        <input type="submit" class="delete" value="" /> Select: <a href="#" class="sec_link_small">All</a>, <a href="#" class="sec_link_small">None</a>, <a href="#" class="sec_link_small">Read</a>, <a href="#" class="sec_link_small">Unread (2)</a>
    </fieldset>
    <table cellspacing="0" cellpadding="0" class="messages"> 
    <?php foreach ($received_messages as $message): ?>
    <?php echo ( $message->getIsRead() ) ? '<tr>' : '<tr class="bold">'; ?>
        <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), false, 'class=checkbox') ?></td>
        <td><?php echo link_to($message->getMemberRelatedByFromMemberId()->getUsername(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
        <td><?php echo link_to($message->getSubject(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
        <td><?php echo link_to(format_date_pr($message->getCreatedAt(null)), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>

    <fieldset class="text_1">
        <input type="submit" class="delete" value="" /> Select: <a href="#" class="sec_link_small">All</a>, <a href="#" class="sec_link_small">None</a>, <a href="#" class="sec_link_small">Read</a>, <a href="#" class="sec_link_small">Unread (2)</a>
    </fieldset>
</form>
<?php endif; ?>

<?php if( count($sent_messages) > 0): ?>
<div class="text_1 messages_show_hide">
    <?php echo link_to_function('[<span id="messages_form_sent_tick">+</span>]', 'show_hide_tick("messages_form_sent")', 'class=sec_link') ?> <span class="public_reg_notice">Sent Messages</span>
</div>

<?php echo form_tag('messages/delete', array('id' => 'messages_form_sent', 'style' => 'display: none;')) ?>    
    <fieldset class="text_1">
        <input type="submit" class="delete" value="" /> Select: <a href="#" class="sec_link_small">All</a>, <a href="#" class="sec_link_small">None</a>, <a href="#" class="sec_link_small">Read</a>, <a href="#" class="sec_link_small">Unread (2)</a>
    </fieldset>
    <table cellspacing="0" cellpadding="0" class="messages" id="sent_messages"> 
    <?php foreach ($sent_messages as $message): ?>
    <tr>
        <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), false, 'class=checkbox') ?></td>
        <td><?php echo link_to($message->getMemberRelatedByToMemberId()->getUsername(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
        <td><?php echo link_to($message->getSubject(), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
        <td><?php echo link_to(format_date_pr($message->getCreatedAt(null)), 'messages/view?id=' . $message->getId(), array('class' => 'sec_link')) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <fieldset class="text_1">
        <input type="submit" class="delete" value="" /> Select: <a href="#" class="sec_link_small">All</a>, <a href="#" class="sec_link_small">None</a>, <a href="#" class="sec_link_small">Read</a>, <a href="#" class="sec_link_small">Unread (2)</a>
    </fieldset>
</form>
<?php endif; ?>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
