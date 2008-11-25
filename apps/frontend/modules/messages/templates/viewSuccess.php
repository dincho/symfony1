<?php use_helper('Javascript', 'prDate') ?>
<?php slot('header_title') ?>
    <?php echo __('Messages') ?>
<?php end_slot(); ?>

<div id="message_details">
    <div class="message_header">
            <p>
                <?php if( $message->getSentBox() ): ?>
                    <?php echo __('To:') . '&nbsp;' . $message->getMemberRelatedByToMemberId()->getUsername() ?>
                    &nbsp;&nbsp;&nbsp;<?php echo link_to(__('See Profile'), '@profile?username=' . $message->getMemberRelatedByToMemberId()->getUsername(), 'class=sec_link') ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Flag'), 'content/flag?username=' . $message->getMemberRelatedByToMemberId()->getUsername(), array('class' => 'sec_link')) ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Block'), 'block/add?profile_id=' . $message->getToMemberId(), 'class=sec_link') ?>
                <?php else: ?>
                    <?php echo __('From:') . '&nbsp;' . $message->getMemberRelatedByFromMemberId()->getUsername() ?>
                    &nbsp;&nbsp;&nbsp;<?php echo link_to(__('See Profile'), '@profile?username=' . $message->getMemberRelatedByFromMemberId()->getUsername(), 'class=sec_link') ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Flag'), 'content/flag?username=' . $message->getMemberRelatedByFromMemberId()->getUsername(), array('class' => 'sec_link')) ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Block'), 'block/add?profile_id=' . $message->getFromMemberId(), 'class=sec_link') ?>                  
                <?php endif; ?>
            </p>
            <p><?php echo __('Sent:') . '&nbsp;' . format_date_pr($message->getCreatedAt(null)); ?></p>
            <p><?php echo __('Subject:') . '&nbsp;' . $message->getSubject() ?></p>
    </div>
    <div class="message_desc"><?php echo strip_tags($sf_data->getRaw('message')->getContent(), '<br>'); ?></div>
    <div class="actions">
      <?php echo button_to(__('Delete'), 'messages/delete?selected[]=' . $message->getId(), array('class' => 'button_mini', 'confirm' => 'Are you sure you want to delete this message?')) ?>
      <?php echo button_to(__('Close'), 'messages/index', 'class=button_mini') ?>
      <?php if( !$message->getIsReplied() && !$message->getSentBox()): ?>
        <?php echo button_to(__('Reply'), 'messages/reply?profile_id=' . $message->getMemberRelatedByFromMemberId()->getId() . '&id=' . $message->getId(), 'class=button_mini') ?>
      <?php endif; ?>
    </div>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
