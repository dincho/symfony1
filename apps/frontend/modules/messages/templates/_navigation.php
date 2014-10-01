<div id="messages_group">
    <a href="<?php echo url_for('messages/index') ?>"
       id="received_messages"
       rel="messages_form"
       class="<?php echo ($active == "received") ? "active_group" : "" ?>">
            <?php echo __('Received Messages <strong>(%cnt_unread%)</strong>', array('%cnt_unread%' => $cntUnread))?>
    </a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="<?php echo url_for('messages/drafts') ?>"
       id="draft_messages"
       rel="messages_form_draft"
       class="<?php echo ($active == "drafts") ? "active_group" : "" ?>">
            <?php echo __('Draft Messages (%NUM_DRAFTS%)', array('%NUM_DRAFTS%' => $cntDrafts)) ?>
    </a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="<?php echo url_for('messages/sent') ?>"
       id="sent_messages"
       rel="messages_form_sent"
       class="<?php echo ($active == "sent") ? "active_group" : "" ?>">
            <?php echo __('Sent Messages')?>
    </a>
</div>
