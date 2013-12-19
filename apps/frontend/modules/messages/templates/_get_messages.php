<?php use_helper('prDate', 'prProfilePhoto') ?>
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