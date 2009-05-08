<?php use_helper('Javascript', 'prDate') ?>

<div id="message_details">
    <div class="message_header">
            <p>
                <?php if( $message->getSentBox() ): ?>
                    <?php $to_member = $message->getMemberRelatedByToMemberId(); ?>
                    <?php echo __('To:') . '&nbsp;' . $to_member->getUsername() ?>
										<?php if( $to_member->isActive() ): ?>
                    &nbsp;&nbsp;&nbsp;<?php echo link_to(__('See Profile'), '@profile?bc=messages&username=' . $to_member->getUsername(), 'class=sec_link') ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Flag'), 'content/flag?username=' . $to_member->getUsername(), array('class' => 'sec_link')) ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Block'), 'block/add?profile_id=' . $message->getToMemberId(), 'class=sec_link') ?>
										<?php endif; ?>
                <?php else: ?>
                    <?php $from_member = $message->getMemberRelatedByFromMemberId(); ?>
                    <?php echo __('From:') . '&nbsp;' . $from_member->getUsername() ?>
										<?php if( $from_member->isActive() ): ?>
                    &nbsp;&nbsp;&nbsp;<?php echo link_to(__('See Profile'), '@profile?bc=messages&username=' . $from_member->getUsername(), 'class=sec_link') ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Flag'), 'content/flag?username=' . $from_member->getUsername(), array('class' => 'sec_link')) ?>
                    &nbsp;&nbsp;<?php echo link_to(__('Block'), 'block/add?profile_id=' . $message->getFromMemberId(), 'class=sec_link') ?>                  
										<?php endif; ?>
                <?php endif; ?>
            </p>
            <p><?php echo __('Sent:') . '&nbsp;' . format_date_pr($message->getCreatedAt(null)); ?></p>
            <p><?php echo __('Subject:') . '&nbsp;' . $message->getSubject() ?></p>
    </div>
    <div class="message_desc"><?php echo strip_tags($sf_data->getRaw('message')->getContent(), '<br><a>'); ?></div>
    <div class="actions" style="margin: 3px;">
      <?php echo button_to(__('Delete'), 'messages/delete?selected[]=' . $message->getId(), array('class' => 'button_mini', 'confirm' => 'Are you sure you want to delete this message?')) ?>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo button_to(__('Close'), 'messages/index', 'class=button_mini') ?>
      <?php if( !$message->getIsReplied() && !$message->getSentBox() && $from_member->isActive()): ?>
        &nbsp;<?php echo button_to(__('Reply'), 'messages/reply?profile_id=' . $from_member->getId() . '&id=' . $message->getId(), 'class=button_mini') ?>
      <?php endif; ?>
    </div>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
