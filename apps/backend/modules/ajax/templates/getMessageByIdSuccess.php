<?php if( $message ): ?>
    <?php use_helper('Javascript') ?>
    <?php if( $sf_request->getParameter('details')): ?>
        <?php echo $message->getBody() ?>
    <?php else: ?>
        <?php echo Tools::truncate($message->getBody(), 400, '...' . link_to_remote('More', array('url' => 'ajax/getMessageById?details=1&id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()), false)  ?>
    <?php endif; ?>
    <br /><br />
    <?php if(!$sf_request->getParameter('no_links')): ?>
        <?php echo link_to('see all messages of this sender', 'messages/member?id=' . $message->getSenderId()) . '&nbsp;|&nbsp;' . 
                    link_to('see the whole conversation', 'messages/conversation?member_id=' . $message->getSenderId() . '&id=' . $message->getThreadId()) ?>
    <?php endif; ?>
<?php endif; ?>