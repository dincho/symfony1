<?php if( $message ): ?>
    <?php use_helper('Javascript') ?>
    <?php if( $sf_request->getParameter('details')): ?>
        <p><b><?php echo $message->getSubject() ?></b></p>
        <?php echo nl2br(strip_tags($message->getBody(), 'br')) ?>
    <?php else: ?>
        <?php echo Tools::truncate($message->getBody(), 400, '...' . link_to_remote('More', array('url' => 'ajax/getPrMailMessageById?details=1&id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()), false)  ?>
    <?php endif; ?>
<?php endif; ?>