<?php if( $sf_data->get('sf_flash')->has('msg_error') || $sf_data->get('sf_flash')->has('msg_warning') || $sf_data->get('sf_flash')->has('msg_ok') || $sf_data->get('sf_flash')->has('msg_info') ): ?>
  <div id="messages">
    <?php if( $sf_data->get('sf_flash')->has('msg_error') ): ?>
      <div class="msg_error"><?php echo $sf_data->get('sf_flash')->get('msg_error'); ?></div>
    <?php endif; ?>
    <?php if( $sf_data->get('sf_flash')->has('msg_warning') ): ?>
      <div class="msg_warning"><?php echo __($sf_data->get('sf_flash')->get('msg_warning')); ?></div>
    <?php endif; ?>
    <?php if( $sf_data->get('sf_flash')->has('msg_ok') ): ?>
      <div class="msg_ok"><?php echo $sf_data->get('sf_flash')->get('msg_ok'); ?></div>
    <?php endif; ?>
    <?php if( $sf_data->get('sf_flash')->has('msg_info') ): ?>
      <div class="msg_info"><?php echo __($sf_data->get('sf_flash')->get('msg_info')); ?></div>
    <?php endif; ?>
  </div>
<?php endif; ?>