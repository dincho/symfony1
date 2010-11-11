<?php use_helper('Javascript', 'prProfilePhoto') ?>
<?php include_partial('member_details', array('member' => $member)); ?>
<?php $received_only = $sf_request->getParameter('received_only', 0); ?>

<?php echo form_tag('messages/delete', array('name' => 'member_messages')) ?>
<?php echo input_hidden_tag('received_only', $received_only, 'class=hidden') ?>
<?php echo input_hidden_tag('member_id', $member->getId(), 'class=hidden') ?>

    <div class="scrollable normal_scrollable" style="margin-top: 20px;">
        <table class="zebra">
            <thead>
                 <tr>
                    <td colspan="7">
                        Select: <?php echo link_to_function('All', 'msg_select(document.forms.member_messages.elements["marked[]"], true)') ?>, 
                                <?php echo link_to_function('None', 'msg_select(document.forms.member_messages.elements["marked[]"], false)') ?>
                    </td>
                 </tr>
                <tr>
                    <th></th>
                    <th class="firstcolumn"></th>
                    <?php if( $received_only ): ?>
                        <th>Received From</th>
                        <th>Subject</th>
                        <th>Date Received</th>
                    <?php else: ?>
                        <th>Sent To</th>
                        <th>Subject</th>
                        <th>Date Sent</th>
                    <?php endif; ?>
                </tr>
            </thead>
 
        <?php foreach ($messages as $message): ?>
            <tr rel="<?php echo url_for('messages/conversation?id=' . $message->getThreadId() . '&received_only=' . $received_only . '&member_id=' . $member->getId()) ?>" onmouseover="preview_click('<?php echo $message->getId();?>')" onmouseout2="preview_clear()">
                <td class="marked"><?php echo checkbox_tag('marked[]', $message->getId(), null) ?></td>
                <?php if( $received_only ): ?>
                  <?php $member = $message->getMemberRelatedBySenderId()?>
                <?php else: ?>
                  <?php $member = $message->getMemberRelatedByRecipientId()?>
                <?php endif; ?>
                <td>
                    <?php echo unless_profile_thumbnail_photo_tag($member) ?>
                </td>
                <td>
                    <?php echo $member->getUsername() ?>
                </td>
                
                <td><?php echo Tools::truncate($message->getThread()->getSubject(), 100); ?></td>
                <td><?php echo $message->getCreatedAt('m/d/Y'); ?></td>
                <td class="preview_button">
                    <?php echo button_to_remote('Preview', array('url' => 'ajax/getMessageById?no_links=1&id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        
        </table>
    </div>

    <div class="text-left">
        <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected messages?') ?>
    </div>

</form>
<div id="preview" class="scrollable mini_scrollable"></div>