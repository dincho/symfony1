<?php if($sf_flash->has('msg_tpl')): ?>
    <?php include_partial('content/messages/' . $sf_flash->get('msg_tpl')); ?>
<?php endif; ?>
