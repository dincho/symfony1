<?php use_helper('Javascript') ?>
<?php include_partial('member_details', array('member' => $member)); ?>
<?php $received_only = $sf_request->getParameter('received_only'); ?>

<?php echo form_tag('messages/delete') ?>
<?php echo input_hidden_tag('received_only', $received_only, 'class=hidden') ?>
<?php echo input_hidden_tag('member_id', $member->getId(), 'class=hidden') ?>

    <div class="scrollable normal_scrollable" style="margin-top: 20px;">
        <table class="zebra">
            <thead>
                <tr>
                    <th></th>
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
            <tr rel="<?php echo url_for('messages/conversation?id=' . $message->getId() . '&received_only=' . $received_only) ?>" onmouseover="preview_click('<?php echo $message->getId();?>')" onmouseout2="preview_clear()">
                <td class="marked"><?php echo checkbox_tag('marked[]', $message->getId(), null) ?></td>
                <td>
                    <?php if( $received_only ): ?>
                        <?php echo $message->getMemberRelatedBySenderId()->getUsername() ?>
                    <?php else: ?>
                        <?php echo $message->getMemberRelatedByRecipientId()->getUsername() ?>
                    <?php endif; ?>
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