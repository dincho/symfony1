<?php if($sf_data->get('sf_flash')->has('s_msg')): ?>
    <?php echo __(html_entity_decode($sf_data->get('sf_flash')->get('s_msg')), $sf_flash->getRaw('s_vars')) ?>
<?php else: ?>
    <?php echo __(html_entity_decode($sf_data->get('sf_flash')->get('s_title')), $sf_flash->getRaw('s_vars')) ?>
<?php endif; ?>
